<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Entity\Subscriber;
use Zend\Http\PhpEnvironment\Response;
use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    protected $em;

    public function indexAction()
    {
        $repository = $this->getEntityManager()->getRepository('Application\Entity\Test');

        $testsJson = Json::encode($repository->findAllToArray(), true);
        return compact('testsJson');
    }

    public function subscribeAction()
    {
        $correct    = $this->params()->fromRoute('correct');
        $wrong      = $this->params()->fromRoute('wrong');

        $form = $this->getServiceLocator()->get('FormElementManager')->get('Application\Form\Subscribe');

        if (($prg = $this->prg()) instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return compact('correct', 'wrong', 'form');
        }

        $subscriber = new Subscriber;

        $form->bind($subscriber);
        $form->setData($prg);
        if ($form->isValid()) {
            $subscriber->setLogin($subscriber->getEmail());
            $em = $this->getEntityManager();
            $subscriber->setPassword(md5($clearPassword = $subscriber->getPassword()));
            $em->persist($subscriber);
            $em->flush();

            /** @todo create a service for that */
            $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
            $adapter = $authService->getAdapter();
            $adapter->setIdentityValue($subscriber->getLogin());
            $adapter->setCredentialValue($clearPassword);
            $authResult = $authService->authenticate();
            if ($authResult->isValid()) {
                return $this->redirect()->toRoute('home');
            }
            /* end ---------------------------- */

            $this->flashMessenger()->addMessage(sprintf('Bonjour %s', $subscriber->getFirstname()));
            return $this->redirect()->toRoute('home');
        }

        return compact('correct', 'wrong', 'form');
    }

    public function resultAction()
    {
        $correct    = $this->params()->fromRoute('correct');
        $wrong      = $this->params()->fromRoute('wrong');
        return compact('correct', 'wrong');
    }

    public function getEntityManager()
    {
        if (! $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine\ORM\EntityManager');
        }
        return $this->em;
    }

}

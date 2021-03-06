<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Http\PhpEnvironment\Response;
use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    protected $em;

    public function indexAction()
    {
        $repository = $this->getEntityManager()->getRepository('Application\Entity\Test');
        $limit = $this->getServiceLocator()->get('config')['website']['testLimitMax'];

        $testsJson = Json::encode($repository->findRandomToArray($limit, $this->params('theme')), true);
        return compact('testsJson');
    }

    public function loginAction()
    {
        if (($prg = $this->prg()) instanceof Response) {
            return $prg;
        } elseif ($prg !== false) {
            $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
            $adapter = $authService->getAdapter();
            $adapter->setIdentityValue($prg['login']);
            $adapter->setCredentialValue($prg['password']);
            $authResult = $authService->authenticate();

            if (! $authResult->isValid()) {
                $this->flashMessenger()->addErrorMessage('Mauvais login / password');
                $this->redirect()->toRoute('home');
            }
        }
        return $this->forward()->dispatch('Application\Controller\Index', ['action' => 'index']);
    }

    public function testAction()
    {
        $repository = $this->getEntityManager()->getRepository('Application\Entity\Test');
        $hash       = $this->params()->fromRoute('hash');

        if (! $test = $repository->findOneByHash($hash)) {
            return $this->notFoundAction();
        }

        $testsJson  = Json::encode($test->toArray(), true);
        return compact('testsJson');
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

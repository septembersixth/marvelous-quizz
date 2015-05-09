<?php

namespace Application\Controller;

use Application\Entity\Contact;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;

class ContactController extends AbstractActionController
{
    protected $em;

    public function indexAction()
    {
        $form = $this->getServiceLocator()->get('formElementManager')->get('Application\Form\Contact');

        if (($prg = $this->prg()) instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return compact('form');
        }

        $contact = new Contact;
        $form->bind($contact);
        $form->setData($prg);
        if ($form->isValid()) {
            $em = $this->getEntityManager();
            $em->persist($contact);
            $em->flush();
            $this->flashMessenger()->addMessage('Merci pour votre message');
            return $this->redirect()->toRoute('home');
        }

        return compact('form');
    }

    public function faqAction()
    {
        return [];
    }

    public function getEntityManager()
    {
        if (! $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine\ORM\EntityManager');
        }
        return $this->em;
    }
} 
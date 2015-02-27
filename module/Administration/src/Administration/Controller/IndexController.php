<?php

namespace Administration\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    public function LoginAction()
    {
        $form = $this->getServiceLocator()->get('FormElementManager')->get('Administration\Form\Login');
        return compact('form');
    }
} 
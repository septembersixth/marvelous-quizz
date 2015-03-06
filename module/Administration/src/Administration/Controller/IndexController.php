<?php

namespace Administration\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    public function loginAction()
    {
        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        if ($loggedUser = $authService->getIdentity()) {
            var_dump($loggedUser);
        }

        $form = $this->getServiceLocator()->get('FormElementManager')->get('Administration\Form\Login');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();
            $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
            $adapter = $authService->getAdapter();
            $adapter->setIdentityValue($data['login']);
            $adapter->setCredentialValue($data['password']);
            $authResult = $authService->authenticate();

            if ($authResult->isValid()) {
                return $this->redirect()->toRoute('administration/posts');
            }

        }

        return compact('form');
    }

    public function logoutAction()
    {
        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $authService->clearIdentity();
        return $this->redirect()->toRoute('administration/login');
    }
} 
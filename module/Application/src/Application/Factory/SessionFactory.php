<?php

namespace Application\Factory;

use Zend\Authentication\Storage\Session;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\Config\SessionConfig;
use Zend\Session\SessionManager;

class SessionFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sessionConfig = (new SessionConfig)->setOptions($serviceLocator->get('configuration')['session']);
        $session = new Session(null, null, new SessionManager($sessionConfig));
        return $session;
    }

} 
<?php

namespace Administration;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $event)
    {
        $application    = $event->getApplication();
        $sharedEvents   = $application->getEventManager()->getSharedManager();
//        $locator        = $event->getApplication()->getServiceManager();

        $sharedEvents->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, [$this, 'authOrRedirect'], 100);
        $sharedEvents->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, [$this, 'setLayout'], 100);
    }

    public function authOrRedirect(MvcEvent $event)
    {
        $routeMatch     = $event->getRouteMatch();
        $locator        = $event->getApplication()->getServiceManager();
        $auth           = $locator->get('Zend\Authentication\AuthenticationService');

        if (! $auth->hasIdentity() && $routeMatch->getParam('action') !== 'login') {
            return $event
                    ->getTarget()
                    ->redirect()
                    ->toRoute('administration/login', [], true)
            ;
        }
    }

    public function setLayout(MvcEvent $event)
    {
        $event->getViewModel()->setTemplate('layout/layout.phtml');
    }
} 
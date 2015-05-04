<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Validator\AbstractValidator;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $eventManager->attach('render', [$this, 'registerJsonStrategy'], 100);
        $eventManager->attach('render', [$this, 'injectLayoutConfig'], 100);


        $serviceLocator = $e->getApplication()->getServiceManager();
        $translator     = $serviceLocator->get('MvcTranslator');

        $translator->addTranslationFile(
            'phpArray',
            __DIR__ . '/resources/fr/Zend_Captcha.php',
            'default',
            'fr_FR'
        );

        $translator->addTranslationFile(
            'phpArray',
            __DIR__ . '/resources/fr/Zend_Validate.php',
            'default',
            'fr_FR'
        );

        AbstractValidator::setDefaultTranslator($translator);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function registerJsonStrategy(MvcEvent $e)
    {
        if (! $matches = $e->getRouteMatch()) {
            return;
        }
        $controller = $matches->getParam('controller');
        if (false === strpos($controller, 'Json')) {
            return;
        }

        $app          = $e->getTarget();
        $locator      = $app->getServiceManager();
        $view         = $locator->get('Zend\View\View');
        $jsonStrategy = $locator->get('ViewJsonStrategy');

        // Attach strategy, which is a listener aggregate, at high priority
        $view->getEventManager()->attach($jsonStrategy, 100);
    }

    public function injectLayoutConfig(MvcEvent $e)
    {
        $serviceManager = $e->getApplication()->getServiceManager();
        $viewModel      = $e->getApplication()->getMvcEvent()->getViewModel();

        $viewModel->websiteConfig = $serviceManager->get('config')['website'];
    }
}

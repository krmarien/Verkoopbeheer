<?php

namespace CommonBundle;

use Zend\Module\Manager,
	Zend\EventManager\Event,
    Zend\EventManager\StaticEventManager,
    Zend\Module\Consumer\AutoloaderProvider,
    Zend\Mvc\MvcEvent;

class Module implements AutoloaderProvider
{
	protected $locator = null;
	protected $moduleManager = null;

	public function init(Manager $moduleManager)
    {
    	$this->moduleManager = $moduleManager;
    
		$events = StaticEventManager::getInstance();
		$events->attach(
			'bootstrap', 'bootstrap', array($this, 'initializeView')
		);
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php'
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ 	=> __DIR__ . '/src/' . __NAMESPACE__,
                )
            )
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/src/Resources/config/module.config.php';
    }

    public function initializeView(Event $e)
    {
        $app = $e->getParam('application');
        $basePath = $app->getRequest()->getBasePath();
        $locator = $app->getLocator();
        $renderer = $locator->get('ZfTwig\TwigRenderer');
        $renderer->plugin('basePath')->setBasePath($basePath);
    
        $view = $locator->get('Zend\View\View');
        $twigStrategy = $locator->get('ZfTwig\TwigRenderingStrategy');
        $view->events()->attach($twigStrategy, 100);
    }
    
    public function getProvides()
    {
        return array(
            'name'    => 'CommonBundle',
            'version' => '1.0.0',
        );
    }
}
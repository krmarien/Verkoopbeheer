<?php
/**
 * Litus is a project by a group of students from the K.U.Leuven. The goal is to create
 * various applications to support the IT needs of student unions.
 *
 * @author Karsten Daemen <karsten.daemen@litus.cc>
 * @author Bram Gotink <bram.gotink@litus.cc>
 * @author Pieter Maene <pieter.maene@litus.cc>
 * @author Kristof Mariën <kristof.marien@litus.cc>
 * @author Michiel Staessen <michiel.staessen@litus.cc>
 * @author Alan Szepieniec <alan.szepieniec@litus.cc>
 *
 * @license http://litus.cc/LICENSE
 */

namespace CommonBundle\Component\Controller;

use Zend\Mvc\MvcEvent,
	Zend\Paginator\Paginator,
	Zend\Paginator\Adapter\ArrayAdapter;

/**
 * We extend the basic Zend controller to simplify database access, authentication
 * and some other common functionality.
 *
 * @author Pieter Maene <pieter.maene@litus.cc>
 */
class ActionController extends \Zend\Mvc\Controller\AbstractActionController implements DoctrineAware
{
    /**
     * @var \CommonBundle\Entity\General\Language
     */
    private $_language;

	/**
     * Execute the request
     *
     * @param  \Zend\Mvc\MvcEvent $e
     * @return mixed
     * @throws Exception\DomainException
     */
    public function onDispatch(MvcEvent $e)
    {
    	$startExecutionTime = microtime(true);

		$this->getServiceLocator()->get('Zend\View\Renderer\PhpRenderer')->plugin('headMeta')->setCharset('utf-8');

        $this->_initControllerPlugins();
        $this->_initViewHelpers();

        //\Zend\Registry::set('Zend_Locale', 'nl');
        //$translator = new \Zend\Translator\Translator('ArrayAdapter', 'vendor/ZendFramework/resources/languages/nl/Zend_Validate.php', 'nl');
        //\Zend\Registry::set('Zend_Translator', $translator);

		$result = parent::onDispatch($e);

        $result->flashMessenger = $this->flashMessenger();

        $result->now = array(
  			'iso8601' => date('c', time()),
  			'display' => date('l, F j Y, H:i', time())
  		);

  		$result->environment = getenv('APPLICATION_ENV');
  		$result->developmentInformation = array(
  			'executionTime' => round(microtime(true) - $startExecutionTime, 3) * 1000,
  			'doctrineUnitOfWork' => $this->getEntityManager()->getUnitOfWork()->size()
  		);

        $result->matchedRouteName = $this->getEvent()->getRouteMatch()->getMatchedRouteName();
        $result->setTerminal(true);

        $e->setResult($result);
        return $result;
    }

    /**
     * Does some initialization work for asynchronously requested actions.
     *
     * @return void
     * @throws \CommonBundle\Component\Controller\Request\Exception\NoXmlHttpRequestException The method was not accessed by a XHR request
     */
    protected function initAjax()
    {
        if (
        	!$this->getRequest()->getHeaders()->get('X_REQUESTED_WITH')
        	|| 'XMLHttpRequest' != $this->getRequest()->getHeaders()->get('X_REQUESTED_WITH')->getFieldValue()
        ) {
            throw new Request\Exception\NoXmlHttpRequestException(
            	'This page is accessible only through an asynchroneous request'
            );
        }
    }

    /**
     * Initializes our custom view helpers.
     *
     * @return void
     */
    private function _initViewHelpers()
    {
    	$renderer = $this->getServiceLocator()->get('Zend\View\Renderer\PhpRenderer');
    	$renderer->plugin('url')->setRouter($this->getServiceLocator()->get('router'));

    	// GetParam View Helper
    	$renderer->getHelperPluginManager()->setInvokableClass(
    		'getparam', 'CommonBundle\Component\View\Helper\GetParam'
    	);
    	$renderer->plugin('getParam')->setRouteMatch(
    		$this->getEvent()->getRouteMatch()
    	);

    	// Date View Helper
    	$renderer->getHelperPluginManager()->setInvokableClass(
    		'dateLocalized', 'CommonBundle\Component\View\Helper\DateLocalized'
    	);
    }

    /**
     * Initializes our custom controller plugins.
     *
     * @return void
     */
    private function _initControllerPlugins()
    {
    	// Paginator Plugin
        $this->getPluginManager()->setInvokableClass(
            'paginator', 'CommonBundle\Component\Controller\Plugin\Paginator'
        );
    }

    /**
     * Singleton implementation for the Entity Manager, retrieved
     * from the Zend Registry.
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
    }

    /**
     * Gets a parameter from a GET request.
     *
     * @param string $param The parameter's key
     * @param mixed $default The default value, returned when the parameter is not found
     * @return string
     */
    public function getParam($param, $default = null)
    {
        return $this->getEvent()->getRouteMatch()->getParam($param, $default);
    }
}

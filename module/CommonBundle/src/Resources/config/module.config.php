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

$asseticConfig = include __DIR__ . '/../../../../../config/assetic.config.php';

return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'install_common'                   => 'CommonBundle\Controller\InstallController',
                'common_activity'                  => 'CommonBundle\Controller\ActivityController',
                'common_activity_revenue'          => 'CommonBundle\Controller\Activity\RevenueController',
                'common_activity_expense'          => 'CommonBundle\Controller\Activity\ExpenseController',
                'common_counting'                  => 'CommonBundle\Controller\Counting\CountingController',
                'common_counting_register'         => 'CommonBundle\Controller\Counting\RegisterController',
                'common_activity_transaction_type' => 'CommonBundle\Controller\Activity\TransactionTypeController',
                'common_stock'                     => 'CommonBundle\Controller\StockController',
                'common_stock_purchase'            => 'CommonBundle\Controller\Stock\PurchaseController',
                'common_stock_sale'                => 'CommonBundle\Controller\Stock\SaleController',
            ),
            'assetic_configuration' => array(
                'parameters' => array(
                    'config' => array(
                        'cacheEnabled' => true,
                        'cachePath'    => __DIR__ . '/../../../../../data/cache',
                        'webPath'      => __DIR__ . '/../../../../../public/_assetic',
                        'baseUrl'      => '/_assetic',
                        'controllers'  => $asseticConfig['controllers'],
                        'routes'       => $asseticConfig['routes'],
                        'modules'      => array(
                            'commonbundle' => array(
                                'root_path' => __DIR__ . '/../assets',
                                'collections' => array(
                                	'common_js' => array(
                                	    'assets'  => array(
                                	        'common/js/jquery-1.7.2.min.js',
                                            'common/js/bootstrap.min.js',
                                	    ),
                                	),
                                    'common_css' => array(
                                        'assets'  => array(
                                            'common/css/bootstrap.min.css',
                                            'common/css/bootstrap-responsive.css',
                                            'common/css/admin.css',
                                        ),
                                        'options' => array(
                                            'output' => 'common.css'
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),

            'doctrine_config' => array(
                'parameters' => array(
                	'entityPaths' => array(
                		'commonbundle' => __DIR__ . '/../../Entity',
                	),
                ),
            ),

            'Zend\View\Helper\Doctype' => array(
                'parameters' => array(
                    'doctype' => 'HTML5',
                ),
            ),
            'Zend\Mvc\View\RouteNotFoundStrategy' => array(
                'parameters' => array(
                    'displayNotFoundReason' => true,
                    'displayExceptions'     => true,
                    'notFoundTemplate'      => 'error/404',
                ),
            ),
            'Zend\Mvc\View\ExceptionStrategy' => array(
                'parameters' => array(
                    'displayExceptions' => true,
                    'exceptionTemplate' => 'error/index',
                ),
            ),

            'Zend\Mvc\Controller\ActionController' => array(
                'parameters' => array(
                    'broker'       => 'Zend\Mvc\Controller\PluginBroker',
                ),
            ),
            'Zend\Mvc\Controller\PluginBroker' => array(
                'parameters' => array(
                    'loader' => 'Zend\Mvc\Controller\PluginLoader',
                ),
            ),

            'Zend\View\Resolver\AggregateResolver' => array(
                'injections' => array(
                    'Zend\View\Resolver\TemplateMapResolver',
                    'Zend\View\Resolver\TemplatePathStack',
                ),
            ),
            'Zend\View\Resolver\TemplateMapResolver' => array(
                'parameters' => array(
                    'map'  => array(
                        'layout' => __DIR__ . '/../layouts/layout.twig',
                    ),
                ),
            ),
            'Zend\View\Resolver\TemplatePathStack' => array(
                'parameters' => array(
                    'paths'  => array(
                        'common_layouts' => __DIR__ . '/../layouts',
                        'common_views' => __DIR__ . '/../views',
                    ),
                    'defaultSuffix' => 'twig'
                ),
            ),
            'ZfTwig\TwigRenderer' => array(
                'parameters' => array(
                    'resolver' => 'Zend\View\Resolver\AggregateResolver',
                ),
            ),
            'Zend\View\Renderer\PhpRenderer' => array(
                'parameters' => array(
                    'resolver' => 'Zend\View\Resolver\AggregateResolver',
                ),
            ),

            'Zend\Mvc\Router\RouteStack' => array(
                'parameters' => array(
                    'routes' => array(
                        'install_common' => array(
                            'type'    => 'Zend\Mvc\Router\Http\Segment',
                            'options' => array(
                                'route'    => '/install/common',
                                'constraints' => array(
                                ),
                                'defaults' => array(
                                    'controller' => 'install_common',
                                    'action'     => 'index',
                                ),
                            ),
                        ),
                        'index' => array(
                            'type'    => 'Zend\Mvc\Router\Http\Segment',
                            'options' => array(
                                'route'    => '/',
                                'constraints' => array(
                                ),
                                'defaults' => array(
                                    'controller' => 'common_activity',
                                    'action'     => 'manage',
                                ),
                            ),
                        ),
                        'common_activity' => array(
                            'type'    => 'Zend\Mvc\Router\Http\Segment',
                            'options' => array(
                                'route'    => '/activities[/:action[/:id]]',
                                'constraints' => array(
                                    'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    'id'      => '[a-zA-Z0-9_-]*',
                                ),
                                'defaults' => array(
                                    'controller' => 'common_activity',
                                    'action'     => 'manage',
                                ),
                            ),
                        ),
                        'common_activity_revenue' => array(
                            'type'    => 'Zend\Mvc\Router\Http\Segment',
                            'options' => array(
                                'route'    => '/activities/revenue[/:action[/:id]]',
                                'constraints' => array(
                                    'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    'id'      => '[a-zA-Z0-9_-]*',
                                ),
                                'defaults' => array(
                                    'controller' => 'common_activity_revenue',
                                    'action'     => 'add',
                                ),
                            ),
                        ),
                        'common_activity_expense' => array(
                            'type'    => 'Zend\Mvc\Router\Http\Segment',
                            'options' => array(
                                'route'    => '/activities/expense[/:action[/:id]]',
                                'constraints' => array(
                                    'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    'id'      => '[a-zA-Z0-9_-]*',
                                ),
                                'defaults' => array(
                                    'controller' => 'common_activity_expense',
                                    'action'     => 'add',
                                ),
                            ),
                        ),
                        'common_activity_transaction_type' => array(
                            'type'    => 'Zend\Mvc\Router\Http\Segment',
                            'options' => array(
                                'route'    => '/activities/transaction_type[/:action[/:id]]',
                                'constraints' => array(
                                    'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    'id'      => '[a-zA-Z0-9_-]*',
                                ),
                                'defaults' => array(
                                    'controller' => 'common_activity_transaction_type',
                                    'action'     => 'add',
                                ),
                            ),
                        ),
                        'common_stock' => array(
                            'type'    => 'Zend\Mvc\Router\Http\Segment',
                            'options' => array(
                                'route'    => '/stock[/:action[/:id]]',
                                'constraints' => array(
                                    'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    'id'      => '[a-zA-Z0-9_-]*',
                                ),
                                'defaults' => array(
                                    'controller' => 'common_stock',
                                    'action'     => 'manage',
                                ),
                            ),
                        ),
                        'common_stock_purchase' => array(
                            'type'    => 'Zend\Mvc\Router\Http\Segment',
                            'options' => array(
                                'route'    => '/stock/purchases[/:action[/:id]]',
                                'constraints' => array(
                                    'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    'id'      => '[a-zA-Z0-9_-]*',
                                ),
                                'defaults' => array(
                                    'controller' => 'common_stock_purchase',
                                    'action'     => 'add',
                                ),
                            ),
                        ),
                        'common_stock_sale' => array(
                            'type'    => 'Zend\Mvc\Router\Http\Segment',
                            'options' => array(
                                'route'    => '/stock/sales[/:action[/:id]]',
                                'constraints' => array(
                                    'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    'id'      => '[a-zA-Z0-9_-]*',
                                ),
                                'defaults' => array(
                                    'controller' => 'common_stock_sale',
                                    'action'     => 'add',
                                ),
                            ),
                        ),
                        'common_counting' => array(
                            'type'    => 'Zend\Mvc\Router\Http\Segment',
                            'options' => array(
                                'route'    => '/activities/counting[/:action[/:id]]',
                                'constraints' => array(
                                    'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    'id'      => '[a-zA-Z0-9_-]*',
                                ),
                                'defaults' => array(
                                    'controller' => 'common_counting',
                                    'action'     => 'add',
                                ),
                            ),
                        ),
                        'common_counting_register' => array(
                            'type'    => 'Zend\Mvc\Router\Http\Segment',
                            'options' => array(
                                'route'    => '/activities/counting/register[/:action[/:id]]',
                                'constraints' => array(
                                    'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    'id'      => '[a-zA-Z0-9_-]*',
                                ),
                                'defaults' => array(
                                    'controller' => 'common_counting_register',
                                    'action'     => 'add',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);

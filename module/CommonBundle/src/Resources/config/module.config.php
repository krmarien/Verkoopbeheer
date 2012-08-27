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

$asseticConfig = include './config/assetic.config.php';

return array(
    'router' => array(
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
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'nl',
        'translation_files' => array(
            array(
                'type'     => 'phparray',
                'filename' => './vendor/zendframework/zendframework/resources/languages/nl/Zend_Validate.php',
                'locale'   => 'nl'
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
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
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../layouts/layout.twig',
            'error/404'               => __DIR__ . '/../views/error/404.twig',
            'error/index'             => __DIR__ . '/../views/error/index.twig',
        ),
        'template_path_stack' => array(
            'commonbundle_layout' => __DIR__ . '/../layouts',
            'commonbundle_view' => __DIR__ . '/../views',
        ),
    ),

    'doctrine' => array(
        'driver' => array(
            'orm_default' => array(
                'drivers' => array(
                    'CommonBundle\Entity' => 'my_annotation_driver'
                ),
            ),
            'my_annotation_driver' => array(
                'paths' => array(
                    'commonbundle' => __DIR__ . '/../../Entity',
                ),
            ),
        ),
    ),

    'assetic_configuration' => array(
        'debug' => false,
        'webPath' => './public/_assetic',
        'strategyForRenderer' => array(
            'AsseticBundle\View\ViewHelperStrategy' => 'Zend\View\Renderer\PhpRenderer'
        ),
        'cacheEnabled' => true,
        'cachePath' => './data/cache',
        'baseUrl' => '/_assetic',
        'controllers' => $asseticConfig['controllers'],
        'routes' => $asseticConfig['routes'],
        'modules' => array(
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
                            'common/css/bootstrap-responsive.min.css',
                            'common/css/common.css',
                        ),
                        'options' => array(
                            'output' => 'common.css'
                        ),
                    ),
                ),
            ),
        ),
    ),
);

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

return array(
    'controllers' => array(
        'install_common' => array(
            '@common_css',
            '@common_js',
        ),
        'common_activity' => array(
            '@common_css',
            '@common_js',
        ),
        'common_activity_revenue' => array(
            '@common_css',
            '@common_js',
        ),
        'common_activity_expense' => array(
            '@common_css',
            '@common_js',
        ),
        'common_activity_transaction_type' => array(
            '@common_css',
            '@common_js',
        ),
        'common_stock' => array(
            '@common_css',
            '@common_js',
        ),
        'common_stock_purchase' => array(
            '@common_css',
            '@common_js',
        ),
        'common_stock_sale' => array(
            '@common_css',
            '@common_js',
        ),
        'common_counting' => array(
            '@common_css',
            '@common_js',
        ),
        'common_counting_register' => array(
            '@common_css',
            '@common_js',
        ),
    ),
    'routes' => array(),
);

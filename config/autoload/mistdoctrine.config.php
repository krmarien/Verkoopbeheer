<?php
return array(
    'di' => array(
        'instance' => array(
            'doctrine_em' => array(
                'parameters' => array(
                    'conn' => array(
                        'driver'   => 'pdo_pgsql',
                        'host'     => 'localhost',
                        'port'     => '5432', 
                        'user'     => 'verkoopbeheer',
                        'password' => 'groenveld',
                        'dbname'   => 'verkoopbeheer',
                    ),
                ),
            ),
            'doctrine_config' => array(
                'parameters' => array(
                    'autoGenerateProxyClasses' => ('development' == getenv('APPLICATION_ENV')),
                    'proxyDir'                 => realpath('data/proxies'),
                    'entityPaths'              => array(),
                ),
            ), 
        ),
    ),
);
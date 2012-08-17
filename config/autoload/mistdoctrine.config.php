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
                        'user'     => 'groenveld',
                        'password' => 'dae6ALpo',
                        'dbname'   => 'groenveldv3',
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
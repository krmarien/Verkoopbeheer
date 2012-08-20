<?php
return array(
    'doctrine' => array(
        'configuration' => array(
            'orm_default' => array(
                'generate_proxies'  => ('development' == getenv('APPLICATION_ENV')),
                'proxy_dir'         => 'data/proxies/',
                'proxy_namespace'   => 'DoctrineORMModule\Proxy',
            )
        ),
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOPgSql\Driver',
                'params' => array(
                    'host'     => 'localhost',
                    'port'     => '5432',
                    'user'     => 'verkoopbeheer',
                    'password' => 'groenveld',
                    'dbname'   => 'verkoopbeheer',
                ),
            ),
        ),
        'driver' => array(
            'my_annotation_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
            ),
        ),
    ),
);
<?php
return array(
    'modules' => array(
        'AsseticBundle',
        'MistDoctrine',
        'ZfTwig',

        'CommonBundle',
    ),
    'module_listener_options' => array(
        'config_cache_enabled' => false,
        'cache_dir'            => 'data/cache',
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
);

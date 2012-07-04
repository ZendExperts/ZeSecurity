<?php
// define used paths by ZeSecurity IDS
$ids = array(
    'log'=> __DIR__ . '/../../data/log/ze_security.ids.log',
    'tmp'=> '/tmp/',
    'cache'=> __DIR__ . '/../../data/cache/ze_security.ids.cache'
);

return array(
    'zendexperts_security' => array(
        'IDS' => array(
            'aggregate_in_session' => true,
            'levels' => array(
                'unlikely' => array(
                    'max_impact' => 5,
                    'actions' => array(
                        '1st' => 'ignore'
                    )
                ),
                'likely' => array(
                    'max_impact' => 25,
                    'actions' => array(
                        '1st' => 'log'
                    )
                ),
                'attack' => array(
                    'max_impact' => 50,
                    'actions' => array(
                        '1st' => 'log',
                        '2nd' => 'redirect',
                    )
                ),
                'threat' => array(
                    'max_impact' => null,
                    'actions' => array(
                        '1st' => 'log',
                        '2nd' => 'notify',
                        '4th' => 'clean_session',
                        '3rd' => 'redirect',
                    )
                ),
            ),
            'actions' => array(
                'log' => array(
                    'class' => 'ZeSecurity\IDS\Action\Log',
                    'options' => array(
                        // 'log_factory' => 'ZeSecurity\IDS\Action\Log\LogFactory',
                        'writer_factory' => 'ZeSecurity\IDS\Action\Log\StreamFactory',
                        'stream' => $ids['log'],
                        // 'formatter' => 'Zend\Log\Formatter\Simple',
                        // 'mode' => 'a',
                    ),
                ),
                'notify' => array(
                    'class' => 'ZeSecurity\IDS\Action\Log',
                    'options' => array(
                        'writer_factory' => 'ZeSecurity\IDS\Action\Log\EmailFactory',
                        'from' => 'PHPIDS <security@example.com>',
                        'to' => array(
                            'webadmin@example.com',
                        ),
                        'subject' => 'Intruder attack detected'
                    ),
                )
            ),
            'options' => array(
                'General' => array(
                    'tmp_path' => $ids['tmp'],
                    'scan_keys' => false,
                    // define which fields contain html and need preparation before hitting the PHPIDS rules(new in PHPIDS 0.5)
                    'html' => array(),
                    // define which fields contain JSON data and should be treated as such; for fewer false positives(new in PHPIDS 0.5.3)
                    'json' => array(),
                    // define which fields shouldn't be monitored (a[b]=c should be referenced via a.b)
                    // you can use regular expressions for wildcard exceptions - example: /.*foo/i
                    'exceptions' => array(
                        'GET.__utmz',
                        'GET.__utmc'
                    ),
                    'min_php_version' => '5.1.6',
                ),
                'Caching' => array(
                    //caching:      session|file|database|memcached|none
                    'caching' => 'file',
                    'expiration_time' => 600,
                    'path' => $ids['cache'],
                    /**
                    ; database cache
                    wrapper         = "mysql:host=localhost;port=3306;dbname=phpids"
                    user            = phpids_user
                    password        = 123456
                    table           = cache

                    ; memcached
                    ;host           = localhost
                    ;port           = 11211
                    ;key_prefix     = PHPIDS
                     */
                ),
            )
        )
    ),

);
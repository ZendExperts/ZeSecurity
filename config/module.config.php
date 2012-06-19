<?php
return array(
    'zendexperts_security' => array(
		'IDS'=>array(
            'aggregate_in_session'=>true,
            'levels'   =>array(),
			'actions'            => array(
				'ignore' => array(
                    'class' => 'ZeSecurity\IDS\Action\Ignore',
                ),
                'redirect' => array(
                    'class' => 'ZeSecurity\IDS\Action\Redirect',
                    'options' => array(
                        'url'=>'/'
                    )
                ),
                'clean_session' => array(
                    'class' => 'ZeSecurity\IDS\Action\CleanSession',
                    'options'=> array(
                        'send_expire_cookie' => true,
                        'clear_storage' => true,
                    ),
                )
			),
            'options'=>array(
                'General'=>array(
                    'filter_type'   => 'xml',
                    'filter_path'   => __DIR__ . '/../vendor/IDS/default_filter.xml',
                    // 'base_path'     => __DIR__ . '/../vendor/IDS/',
                    'use_base_path' => false,
//                    'tmp_path'      => __DIR__ . '/../../../data/tmp/',
                    'scan_keys'     => false,
                    // in case you want to use a different HTMLPurifier source, specify it here
                    // By default, those files are used that are being shipped with PHPIDS
                    'HTML_Purifier_Path'    => 'vendors/htmlpurifier/HTMLPurifier.auto.php',
                    'HTML_Purifier_Cache'   => 'vendors/htmlpurifier/HTMLPurifier/DefinitionCache/Serializer',
                    // define which fields contain html and need preparation before hitting the PHPIDS rules(new in PHPIDS 0.5)
                    'html'          => array(),
                    // define which fields contain JSON data and should be treated as such; for fewer false positives(new in PHPIDS 0.5.3)
                    'json'          => array(),
                    // define which fields shouldn't be monitored (a[b]=c should be referenced via a.b)
                    // you can use regular expressions for wildcard exceptions - example: /.*foo/i
                    'exceptions'    => array(
                        'GET.__utmz',
                        'GET.__utmc'
                    ),
                    'min_php_version'   => '5.1.6',
                ),
                'Caching'=>array(
                    //caching:      session|file|database|memcached|none
                    'caching' => 'none',
                    'expiration_time' => 600,
//                    'path' => __DIR__ . '/../../../data/cache/ze_security.ids.cache',
//                    'path' => 'tmp/default_filter.cache'
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
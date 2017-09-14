<?php

defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

return CMap::mergeArray(
    require(dirname(__FILE__) . '/web.main.php'),
    [

        'name'     => 'Leads',
        'language' => 'ru',

        'components' => [
            'log' => [
                'class'  => 'CLogRouter',
                'routes' => [
                    [
                        'class'  => 'CFileLogRoute',
                        'levels' => 'error, warning',
                    ],
                ],
            ],
        ],

        'params' => [
            'adminEmail'   => 'sklyarov_petr@mail.ru',
            'adminName'    => 'Администратор',
            'tmp'          => '/tmp',
	        'welcomeBonus' => 1000,
            'mailTitle'    => 'Подтверждение регистрации'
        ],
    ]
);

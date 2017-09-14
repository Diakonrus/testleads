<?php

return [
    'id' => md5(php_uname() . 'constant'),
    'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR . '..',
    'name' => 'Leads',
    'preload' => ['log', 'bootstrap'],
    'import' => [
        'application.models.*',
        'application.components.*'
    ],
    'modules' => [
        'administration' => [],
    ],
    'components' => [
        'user'=>[
            'class' => 'WebUser',
            'allowAutoLogin' => true,
            'autoUpdateFlash' => false,
        ],
        'mailer'=>[
            'class'=>'MailService',
            'pathViews' => 'application.views.backend.email',
            'pathLayouts' => 'application.views.email.backend.layouts'
        ],
        'bootstrap'=>[
            'class' => 'application.extensions.yiibooster.components.Bootstrap',
        ],
        'securityManager'=>array(
            'cryptAlgorithm' => 'rijndael-256',
            'encryptionKey' => '9519FAB0C0CE28A2',
        ),
        'db' => require(dirname(__FILE__).'/db.php'),
        'urlManager' => [
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => [
                '<_s:(api)>/<_c>' => '<_s>/<_c>/index',
                '<_s:(api)>/<_c:(start)>/<_a>' => '<_s>/<_c>/<_a>',
                '<_s:(api)>/<_c>/<class:.+>' => '<_s>/<_c>/index',
                'profile' => 'user/index',
                'registration/confirm/<code:.+>' => 'site/registrationConfirm',
                '<_s>' => 'site/<_s>',
                '<_m>' => 'site/index',
                '<_m>/<_c>' => '<_m>/<_c>',
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
];

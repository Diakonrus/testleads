<?php
return [
    'site_access' => [
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Доступ к сайту',
        'bizRule' => null,
        'data' => null
    ],

    'guest' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Guest',
        'bizRule' => null,
        'data' => null
    ],
    'user' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'User',
        'children' => [
            'guest',
            'site_access'
        ],
        'bizRule' => null,
        'data' => null
    ],
    'administrator' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Administrator',
        'children' => [
            'user',
        ],
        'bizRule' => null,
        'data' => null
    ],
];
?>
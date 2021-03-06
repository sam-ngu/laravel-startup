<?php

if (! function_exists('loadTable')) {
    function loadTable(string $name)
    {
        return require(__DIR__ . '/tables/' . $name . '.php');
    }
}

return [

//    'user' => [
//        'uuid' => [
//            'type' => 'uuid',
//        ],
//        'name' => [
//            'type' => 'string',
//
//        ],
//        'email' => [
//            'type' => 'string',
//            'attributes' => ['unique'],
//        ],
//        'avatar_type' => [
//            'type' => 'string',
//            'attributes' => ['nullable'],
//        ],
//        'avatar_location' => [
//            'type' => 'string',
//            'attributes' => ['nullable'],
//        ],
//        'password' => [
//            'type' => 'string',
//            'attributes' => ['nullable'],
//        ],
//        'password_changed_at' => [
//            'type' => 'timestamp',
//            'attributes' => ['nullable'],
//        ],
//        'active' => [
//            'type' => 'tinyInteger',
//            'attributes' => [
//                'unsigned',
//                'default' => [1],
//            ],
//        ],
//        'confirmed' => [
//            'type' => 'boolean',
//            'attributes' => [
//                'default' => [config('access.users.confirm_email') ? false : true],
//            ],
//        ],
//        'timezone' => [
//            'type' => 'string',
//            'attributes' => ['nullable'],
//        ],
//        'last_login_at' => [
//            'type' => 'timestamp',
//            'attributes' => ['nullable'],
//        ],
//        'last_login_ip' => [
//            'type' => 'string',
//            'attributes' => ['nullable'],
//        ],
//    ],

    'post' => [
        'title' => [
            'type' => 'string',
            'attributes' => ['nullable'],
        ],
        'body' => [
            'type' => 'mediumText',
            'attributes' => ['nullable'],
        ],
        'author_id' => [
            'type' => 'foreignId',
            'foreign' => [
                'references' => 'id',
                'on' => 'authors',
            ],
        ],
    ],

];

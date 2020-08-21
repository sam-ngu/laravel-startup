<?php

return [

    'user' => [
        'uuid' => [
            'type' => 'uuid',
        ],
        'first_name' => [
            'type'       => 'string',
            'attributes' => ['nullable'],
        ],
        'last_name'  => [
            'type'       => 'string',
            'attributes' => ['nullable'],
        ],
        'email'      => [
            'type'       => 'string',
            'attributes' => ['unique'],
        ],
        'avatar_type' => [
            'type'       => 'string',
            'attributes' => ['nullable'],
        ],
        'avatar_location' => [
            'type'       => 'string',
            'attributes' => ['nullable'],
        ],
        'password' => [
            'type'       => 'string',
            'attributes' => ['nullable'],
        ],
        'password_changed_at' => [
            'type' => 'timestamp',
            'attributes' => ['nullable']
        ],
        'active' => [
            'type' => 'tinyInteger',
            'attributes' => [
                'unsigned',
                'default' => [1]
            ]
        ],
        'confirmation_code' => [
            'type' => 'string',
            'attributes' => ['nullable'],
        ],
        'confirmed' => [
            'type' => 'boolean',
            'attributes' => [
                'default' => [config('access.users.confirm_email') ? false : true]
            ]
        ],
        'timezone' => [
            'type' => 'string',
            'attributes' => ['nullable'],
        ],
        'last_login_at' => [
            'type' => 'timestamp',
            'attributes' => ['nullable'],
        ],
        'last_login_ip' => [
            'type' => 'string',
            'attributes' => ['nullable'],
        ],
        


        'title'     => [
            'type'       => 'string',
            'attributes' => ['nullable'],
        ],
        'body'      => [
            'type'       => 'mediumText',
            'attributes' => ['nullable'],
        ],
        'author_id' => [
            'type'    => 'foreignId',
            'foreign' => [
                'references' => 'id',
                'on'         => 'authors',
            ],
        ],

    ],

];

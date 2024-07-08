<?php
    return [
        'module' => [
            [
                'title' => 'User Management',
                'icon' => 'fa fa-user',
                'name' => ['user'],
                'subModule' => [
                    [
                        'title' => 'User Group Management',
                        'route' => 'user/catalogue/index'
                    ],
                    [
                        'title' => 'User Management',
                        'route' => 'user/index'
                    ]
                ]
            ],
            [
                'title' => 'Post Management',
                'icon' => 'fa fa-file',
                'name' => ['post'],
                'subModule' => [
                    [
                        'title' => 'Manage Post Groups',
                        'route' => 'post/catalogue/index'
                    ],
                    [
                        'title' => 'Manage Posts',
                        'route' => 'post/index'
                    ]
                ]
            ],
            [
                'title' => 'General Configuration',
                'icon' => 'fa fa-language',
                'name' => ['language'],
                'subModule' => [
                    [
                        'title' => 'Manage Languages',
                        'route' => 'language/index'
                    ]
                ]
            ]
        ],
    ];
    
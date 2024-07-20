<?php
    return [
        'module' => [
            [
                'title' => '用户管理',
                'icon' => 'fa fa-user',
                'name' => ['user', 'permission'],
                'subModule' => [
                    [
                        'title' => '用户组管理',
                        'route' => 'user/catalogue/index'
                    ],
                    [
                        'title' => '用户管理',
                        'route' => 'user/index'
                    ],
                    [
                        'title' => '權限管理',
                        'route' => 'permission/index'
                    ]
                ]
            ],
            [
                'title' => '文章管理',
                'icon' => 'fa fa-file',
                'name' => ['post'],
                'subModule' => [
                    [
                        'title' => '管理文章组',
                        'route' => 'post/catalogue/index'
                    ],
                    [
                        'title' => '管理文章',
                        'route' => 'post/index'
                    ]
                ]
            ],
            [
                'title' => '常规配置',
                'icon' => 'fa fa-language',
                'name' => ['language'],
                'subModule' => [
                    [
                        'title' => '管理语言',
                        'route' => 'language/index'
                    ]
                ]
            ]
        ],
    ];
    
    
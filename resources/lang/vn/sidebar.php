<?php
    return [
        'module' => [
            [
                'title' => 'Quản lý thành viên',
                'icon' => 'fa fa-user',
                'name' => ['user', 'permission'],
                'subModule' => [
                    [
                        'title' => 'Quản lý nhóm thành viên',
                        'route' => 'user/catalogue/index'
                    ],
                    [
                        'title' => 'Quản lý thành viên',
                        'route' => 'user/index'
                    ],
                    [
                        'title' => 'Quản lý quyền',
                        'route' => 'permission/index'
                    ]
                ]
            ],
            [
                'title' => 'Quản lý bài viết',
                'icon' => 'fa fa-file',
                'name' => ['post'],
                'subModule' => [
                    [
                        'title' => 'Quản lý nhóm bài viết',
                        'route' => 'post/catalogue/index'
                    ],
                    [
                        'title' => 'Quản lý bài viết',
                        'route' => 'post/index'
                    ]
                ]
            ],
            [
                'title' => 'Cấu hình chung',
                'icon' => 'fa fa-language',
                'name' => ['language', 'generate'],
                'subModule' => [
                    [
                        'title' => 'Quản lý ngôn ngữ',
                        'route' => 'language/index'
                    ],
                    [
                        'title' => 'Quản lý Module',
                        'route' => 'generate/index'
                    ]
                ]
            ]
        ],
    ];
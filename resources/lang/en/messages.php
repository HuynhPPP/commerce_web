<?php
return [
    'postCatalogue' => [
        'index' => [
            'title' => 'Post Group Management',
            'table' => 'Post Group List',
        ],
        'create' => [
            'title' => 'Add New Post Group',
        ],
        'edit' => [
            'title' => 'Update Post Group',
        ],
        'delete' => [
            'title' => 'Delete Post Group',
        ],
        'table' => [
            'title' => 'Group Name',
            '',
        ],
    ],
    'permission' => [
            'index' => [
                'title' => 'Quản lí Quyền',
                'table' => 'Danh sách Quyền',
            ],
            'create' => [
                'title' => 'Thêm mới Quyền',
            ],
            'edit' => [
                'title' => 'Cập nhật Quyền',
            ],
            'delete' => [
                'title' => 'Xoá Quyền',
            ],
        ],

    'parent_id' => 'Select Parent Category',
    'parent_notice' => '*Select Root if there is no parent category',
    'image' => 'Select Thumbnail',
    'config_advange' => 'Advanced Configuration',
    'perpage' => 'Records',
    'keyword_search' => 'Search',
    'search_input' => 'Enter keyword...',
    'title' => 'Title',
    'description' => 'Short Description',
    'content' => 'Content',
    'multiple_image' => 'Upload Multiple Images',
    'seoConfig' => 'SEO Configuration',
    'seoTitle' => 'You do not have an SEO title',
    'seoCanonical' => 'https://your-url.html',
    'seoDescription' => 'You do not have an SEO description',
    'seoMetaTilte' => 'SEO Description',
    'seoCharacter' => 'Characters',
    'seoMetaKeyWord' => 'Characters',
    'seoMetaCanonical' => 'URL',
    'tableStatus' => 'Status',
    'tableAction' => 'Action',
    'generalTitle' => 'General Information',
    'generalDescription' => 'You are about to delete the post group named: ',
    'deleteWarning' => 'Note: ',
    'generalDescription2' => 'Cannot be restored after deletion. Make sure you want to perform this function.',
    'deleteButton' => 'Delete Data',
    'saveButton' => 'Save',

    'publish' => [
        '0' => 'Select Status',
        '1' => 'UnActive',
        '2' => 'Active'
    ],
    'follow' => [
        '0' => 'Select Navigation',
        '1' => 'No follow',
        '2' => 'Follow'
    ],
];

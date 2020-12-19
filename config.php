<?php

return [
    'file_storage_scenarios' => [
        'post_content' => '',
        'post_cover' => '',
        'post_image' => '',
        'open_graph' => ''
    ],

    'short_resource_class' => '',
    'full_resource_class' => '',

    'languages' => [
        [
            'id' => 'ru',
            'name' => 'Русский',
            'hide_from_url' => true
        ],
        [
            'id' => 'en',
            'name' => 'English'
        ]
    ],
    'url_templates' => [
        'index' => '/blog/{language}',
        'category' => '/categories/{language}/{alias}',
        'post' => '/blog/{alias}',
    ],
    'validation' => [
        'allow_same_post_url_aliases_for_different_languages' => true
    ],
    'fields' => [
        'post' => []
    ],
    'shortcodes' => []
];

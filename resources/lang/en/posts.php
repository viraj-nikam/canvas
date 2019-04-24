<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Post Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used by the paginator library to build
    | the simple pagination links. You are free to change them to anything
    | you want to customize your views to better match your application.
    |
    */

    'header'  => 'Posts',
    'empty'   => [
        'description' => 'No posts were found, start by',
        'action'      => 'adding a new post',
    ],
    'search'  => [
        'input' => 'Search',
        'empty' => 'No posts matched the given search criteria.',
    ],
    'details' => [
        'published' => 'Published',
        'draft'     => 'Draft',
        'updated'   => 'Updated',
    ],
    'forms'   => [
        'image'    => [
            'header' => 'Featured image',
        ],
        'publish'  => [
            'header'  => 'Publish date (m/d/y h:m)',
            'subtext' => [
                'details'  => 'Post scheduling uses a 24-hour time format and is utilizing the',
                'timezone' => 'timezone',
            ],
        ],
        'seo'      => [
            'header'   => 'SEO & Social',
            'meta'     => 'Meta Description',
            'facebook' => [
                'label'       => 'Facebook Card Title',
                'description' => 'Facebook Card Description',
                'placeholder' => 'Title in Facebook Card',
            ],
            'twitter'  => [
                'label'       => 'Twitter Card Title',
                'description' => 'Twitter Card Description',
                'placeholder' => 'Title in Twitter Card',
            ],
        ],
        'settings' => [
            'header'  => 'General settings',
            'summary' => [
                'label'       => 'Summary',
                'placeholder' => 'A descriptive summary..',
            ],
            'topic'   => [
                'label' => 'Topic',
            ],
            'tags'    => [
                'label' => 'Tags',
            ],
        ],
    ],
    'delete'  => [
        'header'  => 'Delete',
        'warning' => 'Deleted posts are gone forever. Are you sure?',
    ],

];

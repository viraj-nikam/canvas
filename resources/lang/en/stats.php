<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Statistic Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used by the paginator library to build
    | the simple pagination links. You are free to change them to anything
    | you want to customize your views to better match your application.
    |
    */

    'header'  => 'Stats',
    'subtext' => 'Click on a post below to see more detailed insights.',
    'empty'   => 'There are no published posts for which you can view stats.',
    'cards'   => [
        'views'      => [
            'title' => 'Views (30 days)',
        ],
        'posts'      => [
            'title' => 'Total posts',
        ],
        'publishing' => [
            'title'   => 'Publishing',
            'details' => [
                'published' => 'Published Post(s)',
                'drafts'    => 'Draft(s)',
            ],
        ],
    ],
    'details' => [
        'published' => 'Published on',
        'views'     => 'Views by traffic source',
        'reading'   => 'Popular reading times',
        'empty'     => 'Waiting until your post has more views to show these insights.',
    ],

];

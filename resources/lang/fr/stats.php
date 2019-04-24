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

    'header'  => 'Statistiques',
    'subtext' => 'Cliquez sur un post ci-dessous pour obtenir des informations plus détaillées.',
    'empty'   => 'Il n\'y a pas d\'articles publiés pour lesquels vous pouvez voir les statistiques.',
    'views'   => 'Vue(s)',
    'cards'   => [
        'views'      => [
            'title' => 'Vues (30 jours)',
        ],
        'posts'      => [
            'title' => 'Total des messages',
        ],
        'publishing' => [
            'title'   => 'Édition',
            'details' => [
                'published' => 'Publication(s) publiée(s)',
                'drafts'    => 'Brouillons)',
            ],
        ],
    ],
    'details' => [
        'created'   => 'Créé',
        'published' => 'Publié le',
        'views'     => 'Vues par source de trafic',
        'reading'   => [
            'header' => 'Temps de lecture populaires',
            'time'   => 'min',
            'read'   => 'lis',
        ],
        'empty'     => 'Attendre que votre message ait plus de vues pour montrer ces idées.',
        'referer'   => [
            'other'   => 'Autre',
            'unknown' => 'Les affichages de publication de cette catégorie ne pouvaient pas déterminer de manière fiable un parrain. par exemple. Mode de navigation privée',
        ],
    ],

];

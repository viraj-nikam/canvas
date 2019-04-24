<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Stats Page
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'header'  => 'Statistiques',
    'subtext' => 'Cliquez sur un post ci-dessous pour obtenir des informations plus détaillées.',
    'empty'   => 'Il n\'y a pas d\'articles publiés pour lesquels vous pouvez voir les statistiques.',
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
                'published' => 'Publication (s) publiée (s)',
                'drafts'    => 'Brouillons)',
            ],
        ],
    ],
    'actions' => [
        'new'     => 'Nouveau poste',
        'edit'    => 'Modifier le post',
        'details' => 'Détails',
    ],

];

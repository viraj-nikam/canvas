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

    'header'  => 'Estatísticas',
    'subtext' => 'Clique em uma postagem abaixo para ver informações mais detalhadas.',
    'empty'   => 'Não há posts publicados para os quais você pode ver as estatísticas.',
    'cards'   => [
        'views'      => [
            'title' => 'Visualizações (30 dias)',
        ],
        'posts'      => [
            'title' => 'Total de postagens',
        ],
        'publishing' => [
            'title'   => 'Publicação',
            'details' => [
                'published' => 'Publicado Post (s)',
                'drafts'    => 'Rascunho (s)',
            ],
        ],
    ],
    'actions' => [
        'new'     => 'Nova postagem',
        'edit'    => 'Editar post',
        'details' => 'Detalhes',
    ],

];

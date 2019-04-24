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

    'header'  => 'Postagens',
    'empty'   => [
        'description' => 'Nenhuma postagem foi encontrada, comece por',
        'action'      => 'adicionando uma nova postagem',
    ],
    'search'  => [
        'input' => 'Procurar',
        'empty' => 'Nenhuma postagem corresponde aos critérios de pesquisa fornecidos.',
    ],
    'details' => [
        'published' => 'Publicados',
        'draft'     => 'Esboço, projeto',
        'updated'   => 'Atualizado',
    ],
    'forms'   => [
        'image'    => [
            'header' => 'Imagem em destaque',
        ],
        'publish'  => [
            'header'  => 'Data de publicação (m / d / ah: m)',
            'subtext' => [
                'details'  => 'O agendamento de postagem usa um formato de horário de 24 horas e está utilizando',
                'timezone' => 'fuso horário',
            ],
        ],
        'seo'      => [
            'header'   => 'SEO e social',
            'meta'     => 'Meta Descrição',
            'facebook' => [
                'title'       => [
                    'label'       => 'Título do cartão do Facebook',
                    'placeholder' => 'Título no cartão do Facebook',
                ],
                'description' => [
                    'label'       => 'Descrição do cartão do Facebook',
                    'placeholder' => 'Descrição no cartão do Facebook',
                ],
            ],
            'twitter'  => [
                'title'       => [
                    'label'       => 'Título do cartão do Twitter',
                    'placeholder' => 'Título no Twitter Card',
                ],
                'description' => [
                    'label'       => 'Descrição do cartão do Twitter',
                    'placeholder' => 'Descrição no Twitter Card',
                ],
            ],
        ],
        'settings' => [
            'header'  => 'Configurações Gerais',
            'slug'    => [
                'label'       => 'Lesma',
                'placeholder' => 'uma lesma única',
            ],
            'summary' => [
                'label'       => 'Resumo',
                'placeholder' => 'Um resumo descritivo ..',
            ],
            'topic'   => [
                'label' => 'Tópico',
            ],
            'tags'    => [
                'label' => 'Tag',
            ],
        ],
    ],
    'delete'  => [
        'header'  => 'Excluir',
        'warning' => 'As postagens excluídas se foram para sempre. Você tem certeza?',
    ],

];

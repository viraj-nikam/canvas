<?php

return [

    'header'     => 'Configuraciones',
    'profile'    => [
        'label'       => 'Tu perfil',
        'description' => 'Elija un nombre de usuario único y comparta detalles públicos sobre usted.',
        'modal'       => [
            'header'   => 'Editar perfil',
            'username' => [
                'label'       => 'Nombre de usuario',
                'placeholder' => 'Elige un nombre de usuario...',
            ],
            'summary'  => [
                'label'       => 'Resumen',
                'placeholder' => 'Cuéntanos un poco sobre ti ...',
            ],
        ],
    ],
    'digest'     => [
        'label'       => 'Resumen semanal',
        'description' => 'Controle si desea recibir un resumen semanal de su contenido publicado.',
    ],
    'appearance' => [
        'label'       => 'Modo oscuro',
        'description' => 'Use una apariencia oscura para el lienzo.',
    ],
    'export'     => [
        'label'       => 'Descargue su información',
        'description' => 'Descargue una copia de la información que ha compartido en Canvas en un archivo .zip.',
    ],

];

<?php

return [

    'header'     => 'Réglages',
    'profile'    => [
        'label'       => 'Votre profil',
        'description' => 'Choisissez un nom d\'utilisateur unique et partagez les informations publiques vous concernant.',
        'modal'       => [
            'header'   => 'Editer le profil',
            'username' => [
                'label'       => 'Nom d\'utilisateur',
                'placeholder' => 'Choisissez un nom d\'utilisateur...',
            ],
            'summary'  => [
                'label'       => 'Sommaire',
                'placeholder' => 'Parle nous un peu de toi...',
            ],
        ],
    ],
    'digest'     => [
        'label'       => 'Digeste hebdomadaire',
        'description' => 'Contrôlez si vous souhaitez recevoir un résumé hebdomadaire de votre contenu publié.',
    ],
    'appearance' => [
        'label'       => 'Mode sombre',
        'description' => 'Utilisez une apparence sombre pour Canvas.',
    ],
    'export'     => [
        'label'       => 'Téléchargez vos informations',
        'description' => 'Téléchargez une copie des informations que vous avez partagées sur Canvas dans un fichier .zip.',
    ],

];

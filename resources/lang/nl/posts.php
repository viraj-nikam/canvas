<?php

return [

    'header'  => 'Berichten',
    'empty'   => [
        'description' => 'Er werden geen berichten gevonden, begin met',
        'action'      => 'nieuw bericht toevoegen.',
    ],
    'search'  => [
        'input' => 'Zoeken op titel...',
        'empty' => 'Geen berichten gevonden met de opgegeven zoekcriteria.',
    ],
    'details' => [
        'published' => 'Gepubliceerd',
        'draft'     => 'Concept',
        'updated'   => 'Aangepast',
        'scheduled' => 'Ingepland',
    ],
    'forms'   => [
        'editor'   => [
            'title'  => 'Titel',
            'body'   => 'Vertel je verhaal...',
            'link'   => 'Plak of typ een link...',
            'html'   => [
                'label'       => 'HTML invoegen',
                'placeholder' => 'Plak jouw HTML hier',
            ],
            'images' => [
                'errors'   => [
                    'size' => 'Afbeelding overschreed de maximale uploadgrootte van',
                ],
                'featured' => [
                    'title'       => 'Titel Uitgelichte Afbeelding',
                    'placeholder' => 'Voeg een titel toe voor je afbeelding',
                ],
                'picker'   => [
                    'greeting'    => 'Alstublieft',
                    'action'      => 'upload',
                    'item'        => 'een afbeelding',
                    'operator'    => 'of',
                    'unsplash'    => 'doorzoek Unsplash',
                    'key'         => 'Configureer je Unsplash API Key.',
                    'placeholder' => 'Zoek naar foto\'s met een hoge resolutie',
                    'clear'       => [
                        'action'      => 'Verwijder',
                        'description' => 'de geselecteerde afbeelding',
                    ],
                    'caption'     => [
                        'by' => 'Foto door',
                        'on' => 'op',
                    ],
                    'search'      => [
                        'empty' => 'We hebben geen resultaten gevonden.',
                    ],
                    'uploader'    => [
                        'label'   => 'Afbeelding toevoegen',
                        'caption' => [
                            'placeholder' => 'Voer een titel voor de afbeelding in (optioneel)',
                        ],
                        'layout'  => [
                            'default' => 'Standaard weergave',
                            'wide'    => 'Breede afbeelding',
                        ],
                    ],
                ],
            ],
        ],
        'image'    => [
            'header' => 'Uitgelichte afbeelding',
        ],
        'publish'  => [
            'header'  => 'Publicatiedatum (m/d/y h:m)',
            'subtext' => [
                'details'  => 'Het inplannen van een bericht gebruikt het 24-uurs tijdformaat en gaat uit van de',
                'timezone' => 'tijdzone',
            ],
        ],
        'seo'      => [
            'header'    => 'SEO & Social',
            'meta'      => 'Meta Description',
            'facebook'  => [
                'title'       => [
                    'label'       => 'Facebook Card Title',
                    'placeholder' => 'Title in Facebook Card',
                ],
                'description' => [
                    'label'       => 'Facebook Card Description',
                    'placeholder' => 'Description in Facebook Card',
                ],
            ],
            'twitter'   => [
                'title'       => [
                    'label'       => 'Twitter Card Title',
                    'placeholder' => 'Title in Twitter Card',
                ],
                'description' => [
                    'label'       => 'Twitter Card Description',
                    'placeholder' => 'Description in Twitter Card',
                ],
            ],
            'canonical' => [
                'label'       => 'Canonical',
                'placeholder' => 'Canonical URL van de originele bron',
            ],
            'sync'      => [
                'title'       => 'Synchroniseer met de bericht titel',
                'description' => 'Synchroniseer met de bericht samenvatting',
            ],
        ],
        'settings' => [
            'header'  => 'Algemene instellingen',
            'slug'    => [
                'label'       => 'Slug',
                'placeholder' => 'een-unieke-slug',
            ],
            'summary' => [
                'label'       => 'Samenvatting',
                'placeholder' => 'Een omschrijvende samenvatting..',
            ],
            'topic'   => [
                'label' => 'Onderwerp',
            ],
            'tags'    => [
                'label' => 'Labels',
            ],
        ],
    ],
    'delete'  => [
        'header'  => 'Delete',
        'warning' => 'Deleted posts are gone forever. Are you sure?',
    ],

];

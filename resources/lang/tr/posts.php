<?php

return [

    'header'  => 'Yazılar',
    'empty'   => [
        'description' => 'Mevcut yazı bulunamadı, katılımda bulunmak için',
        'action'      => 'yeni bir yazı ekleyin.',
    ],
    'search'  => [
        'input' => 'Başlığa göre ara...',
        'empty' => 'Belirtilen arama kriterleri ile eşleşen yazı bulunamadı.',
    ],
    'details' => [
        'published' => 'Yayımlandı',
        'draft'     => 'Taslak',
        'updated'   => 'Güncellendi',
        'scheduled' => 'Zamanlandı',
    ],
    'forms'   => [
        'editor'   => [
            'title'  => 'Başlık',
            'body'   => 'Hikayeni anlat...',
            'link'   => 'Bir bağlantı(link) yapıştırın ya da yazın...',
            'html'   => [
                'label'       => 'HTML yerleştir',
                'placeholder' => 'HTML\'inizi buraya yapıştırın',
            ],
            'images' => [
                'errors'   => [
                    'size' => 'Resim, maksimum yükleme boyutunu aştı',
                ],
                'featured' => [
                    'title'       => 'Öne Çıkan Resim Başlığı',
                    'placeholder' => 'Resminiz için bir başlık ekleyin',
                ],
                'picker'   => [
                    'greeting'    => 'Lütfen',
                    'action'      => 'yükle',
                    'item'        => 'bir resim',
                    'operator'    => 'ya da',
                    'unsplash'    => 'Unsplash\'te ara',
                    'key'         => 'Lütfen Unsplash API Anahtarınızı yapılandırın.',
                    'placeholder' => 'Ücretsiz yüksek çözünürlüklü fotoğrafları arayın',
                    'clear'       => [
                        'action'      => 'Kaldır',
                        'description' => 'seçili resmi',
                    ],
                    'caption'     => [
                        'by' => 'Fotoğraf',
                        'on' => 'tarafından yüklenmiştir',
                    ],
                    'search'      => [
                        'empty' => 'Herhangi bir eşleşme bulunamadı.',
                    ],
                    'uploader'    => [
                        'label'   => 'Resim ekle',
                        'caption' => [
                            'placeholder' => 'Resim için bir başlık ekleyin(isteğe bağlı)',
                        ],
                        'layout'  => [
                            'default' => 'Varsayılan yerleşim',
                            'wide'    => 'Geniş resim',
                        ],
                    ],
                ],
            ],
        ],
        'image'    => [
            'header' => 'Öne çıkan resim',
        ],
        'publish'  => [
            'header'  => 'Yayımlanma tarihi (d/m/y h:m)',
            'subtext' => [
                'details'  => 'Yazı zamanlaması için 24 saatlik zaman biçimi kullanılır ve',
                'timezone' => 'saat dilimi kullanılır.',
            ],
        ],
        'seo'      => [
            'header'    => 'SEO & Sosyal',
            'meta'      => 'Meta Açıklaması',
            'facebook'  => [
                'title'       => [
                    'label'       => 'Facebook Kart Başlığı',
                    'placeholder' => 'Facebook Kartındaki Başlık',
                ],
                'description' => [
                    'label'       => 'Facebook Kart Açıklaması',
                    'placeholder' => 'Facebook Kartındaki Açıklama',
                ],
            ],
            'twitter'   => [
                'title'       => [
                    'label'       => 'Twitter Kart Başlığı',
                    'placeholder' => 'Twitter Kartındaki Başlık',
                ],
                'description' => [
                    'label'       => 'Twitter Kart Açıklaması',
                    'placeholder' => 'Twitter Kartındaki Açıklama',
                ],
            ],
            'canonical' => [
                'label'       => 'Canonical',
                'placeholder' => 'Orjinal kaynağın Canonical URL\'i',
            ],
            'sync'      => [
                'title'       => 'Yazının başlığı ile senkronize et',
                'description' => 'Yazının özeti ile senkronize et',
            ],
        ],
        'settings' => [
            'header'  => 'Genel ayarlar',
            'slug'    => [
                'label'       => 'Slug',
                'placeholder' => 'benzersiz-bir-slug',
            ],
            'summary' => [
                'label'       => 'Özet',
                'placeholder' => 'Açıklayıcı bir özet..',
            ],
            'topic'   => [
                'label' => 'Konu',
            ],
            'tags'    => [
                'label' => 'Etiketler',
            ],
        ],
    ],
    'delete'  => [
        'header'  => 'Sil',
        'warning' => 'Silinen yazılar kalıcı olarak yok olur. Emin misiniz?',
    ],

];

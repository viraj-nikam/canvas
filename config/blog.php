<?php
return [
  /*
  |--------------------------------------------------------------------------
  | Blog Meta Configuration
  |--------------------------------------------------------------------------
  |
  | Here you may define all of the blog meta tags for your application.
  | These will be used for web scraping and open graph tags
  | on sites such as Facebook and Twitter.
  |
  */
  'name'            => 'Canvas',
  'title'           => 'Canvas',
  'subtitle'        => 'Minimal blog application for developers',
  'description'     => 'Blog',
  'author'          => 'Todd Austin',
  /*
  |--------------------------------------------------------------------------
  | Social Media Configuration
  |--------------------------------------------------------------------------
  |
  | You can include any of your social media channels here. They will be
  | displayed directly under the title of your application on the
  | blog index and post pages. Simply leave an empty string
  | for whatever options you do not want to display.
  |
  | Supported: "twitter", "github", "facebook", "linkedin",
  |            "instagram", "bitbucket", "googleplus"
  |
  */
  'twitter'         => 'https://twitter.com/user',
  'github'          => 'https://github.com/user',
  'facebook'        => 'https://facebook.com/user',
  'linkedin'        => 'https://linkedin.com/user',
  'instagram'       => 'https://instagram.com/user',
  'bitbucket'       => 'https://bitbucket.com/user',
  'googleplus'      => 'https://googleplus.com/user',
  /*
  |--------------------------------------------------------------------------
  | Blog Post Configuration
  |--------------------------------------------------------------------------
  |
  | Pretty self-explanatory here. Indicate how many posts you would
  | like to appear on each page and how many posts to display
  | via the rss feed.
  |
  */
  'posts_per_page'  => 6,
  'rss_size'        => 25,
  /*
  |--------------------------------------------------------------------------
  | Uploads Configuration
  |--------------------------------------------------------------------------
  |
  | Specify what type of storage you would like for your application. Just
  | as a reminder, your uploads directory MUST be writable by the
  | web server for the uploading to function properly.
  |
  | Supported: "local"
  |
  */
  'uploads'         => [
    'storage'       => 'local',
    'webpath'       => '/uploads/',
  ],
];
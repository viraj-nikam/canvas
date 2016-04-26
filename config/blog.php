<?php

return [

  /*
  |--------------------------------------------------------------------------
  | Blog Meta Configuration
  |--------------------------------------------------------------------------
  |
  | Here you may define all of the blog meta tags for your application.
  | The Twitter and GitHub accounts are linked to the header that
  | appears on each page.
  |
  */

  'name'            => 'Canvas',
  'title'           => 'Canvas',
  'subtitle'        => 'Minimal blog application for developers',
  'description'     => 'Blog',
  'author'          => 'Todd Austin',
  'twitter'         => 'https://twitter.com/example',
  'github'          => 'https://github.com/example',

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

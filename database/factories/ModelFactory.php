<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/*
|--------------------------------------------------------------------------
| Posts Model Factory
|--------------------------------------------------------------------------
|
| Create the Welcome post in the database.
|
*/
$factory->define(App\Models\Post::class, function ($faker) {
  return [
    'title'             => 'Welcome to Canvas',
    'subtitle'          => 'Let\'s get you started!',
    'page_image'        => 'placeholder.png',
    'content_raw'       => view('site.helpers.welcome'),
    'published_at'      => Carbon\Carbon::now(),
    'meta_description'  => 'Here is the meta description.',
    'is_draft'          => false,
  ];
});

/*
|--------------------------------------------------------------------------
| Tags Model Factory
|--------------------------------------------------------------------------
|
| Create tags for the Welcome post in the database.
|
*/
$factory->define(App\Models\Tag::class, function ($faker) {
  return [
    'tag'               => 'Getting Started',
    'title'             => 'Getting Started',
    'subtitle'          => 'Getting started with Canvas',
    'meta_description'  => 'Meta content for this tag.',
    'reverse_direction' => false,
    'created_at'        => Carbon\Carbon::now(),
  ];
});

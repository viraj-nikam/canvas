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
| User Model Factory
|--------------------------------------------------------------------------
|
| Create randoms users in the database.
|
*/
$factory->define(App\Models\User::class, function ($faker) {
  return [
    'name'            => $faker->name,
    'email'           => $faker->email,
    'password'        => str_random(10),
    'remember_token'  => str_random(10),
  ];
});

/*
|--------------------------------------------------------------------------
| Posts Model Factory
|--------------------------------------------------------------------------
|
| Create random posts in the database.
|
*/
$factory->define(App\Models\Post::class, function ($faker) {
  $images = ['wood.jpg', 'geese.jpg', 'puddle.jpg'];
  $title = $faker->sentence();
  return [
    'title'             => $title,
    'subtitle'          => str_limit($faker->sentence(mt_rand(2, 3)), 252),
    'page_image'        => $images[mt_rand(0, 2)],
    'content_raw'       => join("\n\n", $faker->paragraphs(mt_rand(3, 6))),
    'published_at'      => $faker->dateTimeBetween('-1 month', '+3 days'),
    'meta_description'  => $faker->sentence(),
    'is_draft'          => false,
  ];
});

/*
|--------------------------------------------------------------------------
| Tags Model Factory
|--------------------------------------------------------------------------
|
| Create random tags in the database.
|
*/
$factory->define(App\Models\Tag::class, function ($faker) {
  $images = ['wood.jpg', 'geese.jpg', 'puddle.jpg'];
  $word = $faker->domainWord;
  return [
    'tag'               => $word,
    'title'             => ucfirst($word),
    'subtitle'          => $faker->sentence,
    'page_image'        => $images[mt_rand(0, 2)],
    'meta_description'  => "Meta for $word",
    'reverse_direction' => false,
  ];
});

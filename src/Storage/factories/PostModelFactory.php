<?php

use Canvas\Post;

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Post::class, function (Faker\Generator $faker) {
    return [
        'id'                     => $faker->uuid,
        'slug'                   => $faker->slug,
        'title'                  => $faker->word,
        'summary'                => $faker->sentence,
        'body'                   => $faker->realText(),
        'published_at'           => now()->toDateTimeString(),
        'featured_image'         => $faker->imageUrl(),
        'featured_image_caption' => $faker->sentence,
        'user_id'                => (string) $faker->numberBetween(0, 5),
        'meta'                   => [
            'meta_description'    => $faker->sentence,
            'og_title'            => $faker->sentence,
            'og_description'      => $faker->sentence,
            'twitter_title'       => $faker->sentence,
            'twitter_description' => $faker->sentence,
            'canonical_link'      => $faker->sentence,
        ],
    ];
});

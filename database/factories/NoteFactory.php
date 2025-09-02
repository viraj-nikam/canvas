<?php

/* @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\Canvas\Models\Note::class, function (Faker\Generator $faker) {
    return [
        'id' => $faker->uuid,
        'body' => $faker->realText(),
        'user_id' => function () {
            return factory(\Canvas\Models\User::class)->create()->id;
        },
    ];
});


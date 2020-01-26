<?php

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\Canvas\Topic::class, function (Faker\Generator $faker) {
    return [
        'id'      => $faker->uuid,
        'slug'    => $faker->slug,
        'name'    => $faker->word,
        'user_id' => function () {
            $user = \App\User::inRandomOrder()->first();
            if(is_null($user))
                $user = factory(\App\User::class)->create();
            return $user->id;
        },
    ];
});

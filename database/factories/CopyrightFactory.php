<?php

use Faker\Generator as Faker;

$factory->define(App\Copyright::class, function (Faker $faker) {
    return [
      'id' => $faker->uuid,
      'owner' => $faker->word,
      'year' => $faker->numberBetween(2000, 2017),
      'publication_date' => $faker->dateTimeBetween(),
      'de-DE' => [
        'description' => $faker->sentence(5),
      ],
      'en-US' => [
        'description' => $faker->sentence(5),
      ]
    ];
});

<?php

use Faker\Generator as Faker;

$factory->define(App\FilterCategory::class, function (Faker $faker) {
    return [
      'id' => $faker->uuid,
      'publication_date' => $faker->dateTimeBetween(),
      'de-DE' => [
        'name' => $faker->word
      ],
      'en-US' => [
        'name' => $faker->word
      ]
    ];
});

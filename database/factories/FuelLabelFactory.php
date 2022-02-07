<?php

use Faker\Generator as Faker;

$factory->define(App\FuelLabel::class, function (Faker $faker) {
    return [
      'id' => $faker->uuid,
      'publication_date' => $faker->dateTimeBetween(),
      'de-DE' => [
        'text' => $faker->word
      ],
      'en-US' => [
        'text' => $faker->word
      ]
    ];
});

<?php

use Faker\Generator as Faker;

$factory->define(App\Magazine::class, function (Faker $faker) {
    return [
      'id' => $faker->uuid,
      'identifier' => $faker->unique()->word,
      'url_slug' => $faker->slug,
      'publication_date' => $faker->dateTimeBetween()
    ];
});

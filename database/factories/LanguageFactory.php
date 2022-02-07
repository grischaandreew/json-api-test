<?php

use Faker\Generator as Faker;

$factory->define(App\Language::class, function (Faker $faker) {
    return [
      'id' => $faker->uuid,
      'language_name' => $faker->languageCode,
      'country_name' => $faker->countryCode,
      'iso_language' => $faker->languageCode,
      'iso_country' => $faker->countryCode,
      'isDefault' => $faker->boolean,
      'publication_date' => $faker->dateTimeBetween()
    ];
});

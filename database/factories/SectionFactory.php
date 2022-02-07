<?php

use Faker\Generator as Faker;

$factory->define(App\Section::class, function (Faker $faker) {
    return [
       'id' => $faker->uuid,
       'de-DE' => [
         'title' => $faker->sentence(3),
         'section_headlines' => $faker->randomElements([
           $faker->sentence(2),
           $faker->sentence(3),
           $faker->sentence(3),
           $faker->sentence(3),
           $faker->sentence(3),
           $faker->sentence(3),
         ])
       ],
       'en-US' => [
         'title' => $faker->sentence(3),
         'section_headlines' => $faker->randomElements([
           $faker->sentence(2),
           $faker->sentence(3),
           $faker->sentence(3),
           $faker->sentence(3),
           $faker->sentence(3),
           $faker->sentence(3),
         ])
       ],
       'section_type' => $faker->randomElement(['hero-square', 'documents', 'hero-2by3', 'headerImage', 'text', 'contactPersons', 'video', 'single', 'equal3', 'gallery', 'staggered-3col']),
       'publication_date' => $faker->dateTimeBetween()
    ];
});

<?php

use Faker\Generator as Faker;

$factory->define(App\SocialPost::class, function (Faker $faker) {
    return [
      'id' => $faker->uuid,
      'origin_id' => $faker->word,
      'origin_url' => $faker->slug,
      'title' => $faker->sentence(3),
      'content' => $faker->text,
      'source' => $faker->randomElement(['twitter.com', 'facebook.com', 'pinterest.com', 'instagram.com']),
      'publication_date' => $faker->dateTimeBetween()
    ];
});

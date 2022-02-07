<?php

use Faker\Generator as Faker;

$factory->define(App\Article::class, function (Faker $faker) {
    return [
      'id' => $faker->uuid,
      'origin_id' => $faker->word,
      'url_slug'  => $faker->slug,
      'publication_date' => $faker->dateTimeBetween(),
      'display_date' => $faker->dateTimeBetween(),
      'read_count' => $faker->randomDigitNotNull,
      'download_count' => $faker->randomDigitNotNull,
      'share_count' => $faker->randomDigitNotNull,
      'de-DE' => [
        'title' => $faker->sentence(5),
        'seo_title' => $faker->sentence(5),
        'topic' => $faker->sentence(3),
        'excerpt' => $faker->unique()->text,
        'content' => $faker->unique()->text,
        'formatted_content' => $faker->unique()->text,
        'location' => $faker->address,
        'source' => $faker->randomElement(['mercedes.de', 'benz.com']),
        'og_title' => $faker->sentence(5),
        'og_image' => $faker->sentence(5),
        'og_description' => $faker->sentence(3),
        'localised_read_count' => $faker->randomDigitNotNull,
        'localised_download_count' => $faker->randomDigitNotNull,
        'localised_share_count' => $faker->randomDigitNotNull,
      ],
      'en-US' => [
        'title' => $faker->sentence(5),
        'seo_title' => $faker->sentence(5),
        'topic' => $faker->sentence(3),
        'excerpt' => $faker->unique()->text,
        'content' => $faker->unique()->text,
        'formatted_content' => $faker->unique()->text,
        'location' => $faker->address,
        'source' => $faker->randomElement(['mercedes.de', 'benz.com']),
        'og_title' => $faker->sentence(5),
        'og_image' => $faker->sentence(5),
        'og_description' => $faker->sentence(3),
        'localised_read_count' => $faker->randomDigitNotNull,
        'localised_download_count' => $faker->randomDigitNotNull,
        'localised_share_count' => $faker->randomDigitNotNull,
      ]
    ];
});

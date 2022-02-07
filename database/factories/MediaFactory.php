<?php

use Faker\Generator as Faker;

$factory->define(App\Media::class, function (Faker $faker) {
    return [
      'id' => $faker->uuid,
      'de-DE' => [
        'title' => $faker->sentence(3),
        'caption' => $faker->sentence(10),
        'description' => $faker->text,
        'og_title' => $faker->sentence(3),
        'og_image' => $faker->sentence(10),
        'og_description' => $faker->text,
      ],
      'en-US' => [
        'title' => $faker->sentence(3),
        'caption' => $faker->sentence(10),
        'description' => $faker->text,
        'og_title' => $faker->sentence(3),
        'og_image' => $faker->sentence(10),
        'og_description' => $faker->text,
      ],      
      'publishing_id' => $faker->word,
      'media_type' => $faker->randomElement(['audio', 'video', 'document', 'image']),
      'publication_date' => $faker->dateTimeBetween(),
      'file_type_id' => factory(App\FileType::class)->create()->id,
      'page_count' => $faker->randomDigitNotNull,
      'filesize' => $faker->numberBetween(102, 1024 * 10),
      'width' => $faker->numberBetween(100, 1200),
      'height' => $faker->numberBetween(100, 1200),
      'mars_publish_id' => $faker->word,
      'mars_shelf_number' => $faker->word,
      'mars_archive_number' => $faker->word,
      'content_language' => $faker->randomElement(['de-DE', 'en-US']),
      'storage_uuid' => $faker->uuid,
      'duration' => $faker->numberBetween(10, 60 * 60),
      'ratios' => $faker->randomElements([
        '3x4',
        '7x8',
        '2x1',
        '9x7',
        '5x3'
      ], 1, 4)
    ];
});

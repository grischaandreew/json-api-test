<?php
use Faker\Generator as Faker;

$factory->define(App\Teaser::class, function (Faker $faker) {
    return [
        'id' => $faker->uuid,
        'de-DE' => [
          'title' => $faker->sentence(3),
        ],
        'en-US' => [
          'title' => $faker->sentence(3),
        ],
        'article_id' => factory(App\Article::class)->create()->id,
        'publication_date' => $faker->dateTimeBetween()
    ];
});

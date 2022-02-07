<?php

use Faker\Generator as Faker;

$factory->define(App\FileType::class, function (Faker $faker) {
    return [
      'id' => $faker->uuid,
      'mime_types' => $faker->randomElements(['application/acad', 'application/astound', 'application/dsptype', 'application/dxf', 'application/futuresplash', 'application/gzip', 'application/javascript', 'application/json', 'application/listenup', 'application/mac-binhex40', 'application/mbedlet', 'application/mif', 'application/msexcel', 'application/mshelp', 'mspowerpoint']),
      'file_extensions' => $faker->randomElements(['dwg', 'asd', 'asn', 'tsp', 'dxf', 'spl', 'gz', 'js', 'json', 'ptlk', 'hqx', 'mbd', 'mif', 'xls', 'xla', 'hlp', 'chm', 'ppt', 'ppz', 'pps', 'pot']),
      'publication_date' => $faker->dateTimeBetween(),
      'de-DE' => [
        'name' => $faker->word
      ],
      'en-US' => [
        'name' => $faker->word
      ]
    ];
});

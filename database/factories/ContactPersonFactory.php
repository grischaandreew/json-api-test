<?php

use Faker\Generator as Faker;

$factory->define(App\ContactPerson::class, function (Faker $faker) {
    return [
        'id' => $faker->uuid,
        'publication_date' => $faker->dateTimeBetween(),
        'de-DE' => [
          'firstname' => $faker->firstName,
          'lastname' => $faker->lastName,
          'title' => $faker->title,
          'position' => $faker->word,
          'email' => $faker->safeEmail,
          'phone' => $faker->phoneNumber,
          'mobile' => isset($faker->mobileNumber) ? $faker->mobileNumber : $faker->phoneNumber,
          'fax' => isset($faker->faxNumber) ?  $faker->faxNumber : $faker->phoneNumber
        ],
        'en-US' => [
          'firstname' => $faker->firstName,
          'lastname' => $faker->lastName,
          'title' => $faker->title,
          'position' => $faker->word,
          'email' => $faker->safeEmail,
          'phone' => $faker->phoneNumber,
          'mobile' => isset($faker->mobileNumber) ? $faker->mobileNumber : $faker->phoneNumber,
          'fax' => isset($faker->faxNumber) ?  $faker->faxNumber : $faker->phoneNumber
        ]
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Listing;
use Faker\Generator as Faker;

$factory->define(Listing::class, function (Faker $faker) {
  return [
    'user_id' => function() {
      return factory(User::class)->create()->id;
    },
    'title' => $faker->name,
];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Listing;
use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
  $scheduled_date = $faker->dateTimeBetween('+1day', '+1year');

  return [
    'listing_id' => function() {
      return factory(Listing::class)->create()->id;
    },
    'title' => $faker->name,
    'content' => $faker->name,
    'start_line'=>$scheduled_date->format('Y-m-d'),
    'dead_line'=> $scheduled_date->modify('+1day')->format('Y-m-d'),
  ];
});

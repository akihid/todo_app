<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;
use App\User;
use App\Listing;
use App\Task;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('tasks')->delete();

      $listings = Listing::latest('created_at')->get();

      $faker = Faker::create('ja_JP');

      foreach ($listings as $listing) {
        foreach (range(1, 5) as $num) {
          Task::create([
            'listing_id' => $listing->id,
            'title' => $faker->realText(10),
            'content' => $faker->realText(30),
            'status' => rand(1, 3),
            'start_line' => Carbon::now(),
            'dead_line' => Carbon::now()->addDay($num),
          ]);
        }
      }
    }
}

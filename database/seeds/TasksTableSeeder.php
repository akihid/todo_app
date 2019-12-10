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
        $user = App\User::inRandomOrder()->first();
        foreach (range(1, 3) as $num) {
          Task::create([
            'user_id' => $user->id,
            'listing_id' => $listing->id,
            'title' => $faker->realText(10),
            'content' => $faker->realText(30),
            'start_line' => Carbon::now(),
            'dead_line' => Carbon::now()->addDay($num),
          ]);
        }
      }
    }
}

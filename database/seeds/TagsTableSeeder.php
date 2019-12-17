<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;
use App\Task;
use App\Tag;

class TagsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $faker = Faker::create('ja_JP');
    DB::table('tags')->delete();
    DB::table('task_tag')->delete();

    $tasks = Task::all();

    // タグ５個作成
    foreach (range(1, 5) as $num) {
      Tag::create([
        'name' => $faker->word()
      ]);
    }
    $tags = Tag::all();

    foreach ($tasks as $task) {
      $task->tags()->attach(
        $tags->random(rand(1,3))->pluck('id')->toArray()
      );
    }
  }
}

<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->delete();
      $faker = Faker::create('ja_JP');
      
      // テストログインユーザー
      App\User::create([
        'name' => 'テストユーザー',
        'email' => 'test@co.jp',
        'password' => Hash::make('password'),
        'birthplace' => rand(1, 47),
      ]);

      for ($i = 1; $i <= 10; $i++) {
        $name = $faker->name;
        App\User::create([
          'name' => $name,
          'email' => 'user' . $i . '@co.jp',
          'password' => Hash::make('password'),
          'birthplace' => rand(1, 47),
        ]);
      }
    }
}

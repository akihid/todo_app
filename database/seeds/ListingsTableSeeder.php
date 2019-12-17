<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Listing;
use App\User;

class ListingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('listings')->delete();

      $titles = ['趣味', '仕事', 'その他'];
      $users = User::all();

      foreach ($users as $user) {
        foreach ($titles as $title) {
          Listing::create([
            'title' => $title,
            'user_id' => $user->id
          ]);
        }
      }
    }
}

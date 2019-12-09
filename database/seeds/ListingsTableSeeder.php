<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Listing;

class ListingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $titles = ['趣味', '仕事', 'その他'];

      foreach ($titles as $title) {
        Listing::create([
          'title' => $title,
        ]);
      }
    }
}

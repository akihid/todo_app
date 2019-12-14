<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      if (Auth::check()) {
        $listing = Auth::user()->listings()->first();

        // リストがないとタスクを作れないため、遷移先を変更する
        if (is_null($listing)) {
          return view('/');
        }

        return redirect()->route('tasks.index', compact('listing'));
      }
      // 非ログイン時
      return view('/home');
    }
}

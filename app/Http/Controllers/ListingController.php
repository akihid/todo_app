<?php

namespace App\Http\Controllers;

use App\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ListingRequest;

class ListingController extends Controller
{

  // Todo：確認用のためタスク一覧作成時削除する
  public function index()
  { 
    $listings = Listing::all();

    return view('listings.index', compact('listings')); 
  }

  public function create()
  { 
    return view('listings/create'); 
  }

  public function store(ListingRequest $request)
  {
      $listing = new Listing();
      $listing->title = $request->title;

      Auth::user()->listings()->save($listing);
      return redirect()->route('listings.index');
  }
}

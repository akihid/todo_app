<?php

namespace App\Http\Controllers;

use App\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ListingRequest;

class ListingController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('listing_show_auth')->only(['edit', 'update', 'destroy']);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  { 
    return view('listings/create'); 
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\ListingRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(ListingRequest $request)
  {
    $listing = Auth::user()->listings()->create($request->validated());
    return redirect()->route('tasks.index', compact('listing'))->with('message', '作成しました');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  Listing  $listing
   * @return \Illuminate\Http\Response
   */
  public function edit(Listing $listing)
  {
    return view('listings.edit', compact('listing'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\ListingRequest  $request
   * @param  Listing  $listing
   * @return \Illuminate\Http\Response
   */
  public function update(ListingRequest $request, Listing $listing)
  {
    $listing->update($request->validated());

    return redirect()->route('tasks.index', compact('listing'))->with('message', '更新しました');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  Listing  $list
   * @return \Illuminate\Http\Response
   */
  public function destroy(Listing $listing)
  {
    $listing->delete();

    $listing = Auth::user()->listings()->get()->first();
    // リストがないとタスクを作れないため、遷移先を変更する
    if (is_null($listing)) {
      return view('/home')->with('message', '削除しました');
    }

    return redirect()->route('tasks.index', compact('listing'))->with('message', '削除しました');
  }
}

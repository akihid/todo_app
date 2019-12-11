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
    $listings = Auth::user()->listings()->get();

    return view('listings.index', compact('listings')); 
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
    return redirect()->route('listings.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  Listing  $listing
   * @return \Illuminate\Http\Response
   */
  public function show(Listing $listing)
  { 
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
   * @param  Board  $board
   * @return \Illuminate\Http\Response
   */
  public function update(ListingRequest $request, Listing $listing)
  {
    $listing->update($request->validated());

    return redirect()->route('listings.index')->with('message', '更新しました');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  Listing  $board
   * @return \Illuminate\Http\Response
   */
  public function destroy(Listing $listing)
  {
    $listing->delete();

    return redirect()->route('listings.index')->with('message', '削除しました');
  }
}

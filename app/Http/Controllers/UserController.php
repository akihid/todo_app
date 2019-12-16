<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;
use Storage;
use App\Services\OpenWeatherMap;

class UserController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth')->only(['show', 'edit', 'update']);
  }
  
    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     //
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, OpenWeatherMap $openweathermap)
    {
      $listings = $user->listings()->get();
      $weather_infos = $openweathermap->getWeather($user);
      return view('users.show', compact('user', 'listings', 'weather_infos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
      return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
      $file = $request->icon;
      if (!empty($file)) {
        $path = Storage::disk('s3')->putFile('/', $file, 'public');
        $user->update([
          'icon' => Storage::disk('s3')->url($path),
          'name' => $request->name,
          'email' => $request->email,
          'birthplace' => $request->birthplace,
        ]);
      } else {
        $user->update([
          'name' => $request->name,
          'email' => $request->email,
          'birthplace' => $request->birthplace,
        ]);
      }
      return redirect()->route('users.show', ['user'=>$user])->with('message', 'ユーザー情報を更新しました');
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     //
    // }

    /**
     * @param  User  $user
     * @return Tasks $tasks
     */
    public function getUserTasksInfo(User $user)
    {
      $listings = $user->listings()->get();

    }
}

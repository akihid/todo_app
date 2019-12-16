<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Storage;
use App\User;
use App\Task;
use App\Services\OpenWeatherMap;

class UserController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth')->only(['show', 'edit', 'update']);
    $this->middleware('user_show_auth')->only(['show', 'edit']);
  }
  
    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, OpenWeatherMap $openweathermap)
    {
      $listings = $user->listings()->get();
      
      // リストがないとタスクを作れないため、遷移先を変更する
      if ($listings->isEmpty()) {
        return view('/home');
      }
      $weather_infos = $openweathermap->getWeather($user);
      $task_status_array = $this->getUserTasksInfo($user);

      return view('users.show', compact('user', 'listings', 'weather_infos', 'task_status_array'));
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

    /**
     * @param  User  $user
     * @return Array[]
     */
    public function getUserTasksInfo(User $user)
    {
      $listings = $user->listings()->get();
      // リストの数ループ
      foreach($listings as $listing){
        // タスクのステータス分ループ
        foreach(Task::STATUS as $key => $val){
          $data[$listing->id][$val['label']] = $listing->tasks()->SearchStatus($key)->get()->count();
        }
        $data[$listing->id]['期限切れ'] = $listing->tasks()->ExpiredCount($key)->get()->count();
      }
      return $data;
    }
}

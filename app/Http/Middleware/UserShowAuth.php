<?php

namespace App\Http\Middleware;

use Closure;

class UserShowAuth
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    if(auth()->user()->id === $request->user->id) {
      return $next($request);
    }

    session()->flash('message', '別ユーザーページを参照する権限がありません');
    return redirect()->route('users.show', ['user'=>auth()->user()]);
  }
}

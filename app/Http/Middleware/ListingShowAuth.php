<?php

namespace App\Http\Middleware;

use Closure;

class ListingShowAuth
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
      if(auth()->user()->id === $request->listing->user_id) {
          return $next($request);
      }

      session()->flash('message', '別ユーザーのリストを参照する権限がありません');
      $listing = auth()->user()->listings()->first();
      if (is_null($listing)) {
        return redirect()->route('home');
      }
      return redirect()->route('tasks.index', compact('listing'));
    }
}

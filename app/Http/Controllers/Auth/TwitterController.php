<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Socialite;
use App\User;

class TwitterController extends Controller
{
    // ログイン
    public function redirectToProvider(){
        return Socialite::driver('twitter')->redirect();
    }
    // コールバック
    public function handleProviderCallback(){
        try {
            $twitterUser = Socialite::driver('twitter')->user();
        } catch (Exception $e) {
            return redirect('auth/twitter');
        }
        $user = User::where('auth_id', $twitterUser->id)->first();
        if (!$user) {
            $user = User::create([
              'name' => $twitterUser->name,
              'email' => $this->dummy_email($twitterUser),
              'password' => Hash::make($this->dummy_password($twitterUser)),
              'auth_id' => $twitterUser->id,
              'icon' => $twitterUser->avatar_original
          ]);
        }
        Auth::login($user);
        return redirect('/');
    }
    private function dummy_email($user){
      return $user->id . "@example.com";
    }
    private function dummy_password($user){
      return $user->id;
    }
} 
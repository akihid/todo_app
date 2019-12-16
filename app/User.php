<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
  use Notifiable;

  const BIRTHPLACE = [
    '1' => [ 'name' => ' 北海道', 'id' => '2128295' ],
    '2' => [ 'name' => ' 青森県', 'id' => '2130656' ],
    '3' => [ 'name' => '岩手県', 'id' => '2112518' ],
    '4' => [ 'name' => '宮城県', 'id' => '2111888' ],
    '5' => [ 'name' => '秋田県', 'id' => '2113124' ],
    '6' => [ 'name' => '山形県', 'id' => '2110554' ],
    '7' => [ 'name' => '福島県', 'id' => '2112922' ],
    '8' => [ 'name' => '茨城県', 'id' => '2112669' ],
    '9' => [ 'name' => '栃木県', 'id' => '1850310' ],
    '10' => [ 'name' => '群馬県', 'id' => '1863501' ],
    '11' => [ 'name' =>'埼玉県', 'id' => '1853226' ],
    '12' => [ 'name' => '千葉県', 'id' => '2113014' ],
    '13' => [ 'name' => '東京都', 'id' => '1850147' ],
    '14' => [ 'name' => '神奈川県', 'id' => '1860291' ],
    '15' => [ 'name' => '新潟県', 'id' => '1855429' ],
    '16' => [ 'name' => '富山県',  'id' => '1849872' ],
    '17' => [ 'name' => '石川県', 'id' => '1861387' ],
    '18' => [ 'name' => '福井県','id' => '1863983' ],
    '19' => [ 'name' => '山梨県','id' => '1848649' ],
    '20' => [ 'name' => '長野県','id' => '1856210' ],
    '21' => [ 'name' => '岐阜県', 'id' => '1863640' ],
    '22' => [ 'name' => '静岡県', 'id' => '1851715' ],
    '23' => [ 'name' => '愛知県', 'id' => '1865694' ],
    '24' => [ 'name' => '三重県', 'id' => '1857352' ],
    '25' => [ 'name' => '滋賀県', 'id' => '1852553' ],
    '26' => [ 'name' => '京都府', 'id' => '1857910' ],
    '27' => [ 'name' => '大阪府','id' => '1853909' ],
    '28' => [ 'name' => '兵庫県',  'id' => '1862047' ],
    '29' => [ 'name' => '奈良県', 'id' => '1855608' ],
    '30' => [ 'name' => '和歌山県', 'id' => '1848938' ],
    '31' => [ 'name' => '鳥取県', 'id' => '1849890' ],
    '32' => [ 'name' => '島根県','id' => '1852442' ],
    '33' => [ 'name' =>  '岡山県','id' => '1854381' ],
    '34' => [ 'name' => '広島県', 'id' => '1862413' ],
    '35' => [ 'name' => '山口県', 'id' => '1848681' ],
    '36' => ['name' =>  '徳島県', 'id' => '1850157' ],
    '37' => [ 'name' => '香川県', 'id' => '1851100' ],
    '38' => [ 'name' => '愛媛県', 'id' => '1864226' ],
    '39' => [ 'name' => '高知県', 'id' => '1859133' ],
    '40' => [ 'name' => '福岡県', 'id' => '1863958' ],
    '41' => [ 'name' =>  '佐賀県', 'id' => '1853299' ],
    '42' => [ 'name' => '長崎県', 'id' => '1856156' ],
    '43' => [ 'name' => '熊本県', 'id' => '1858419' ],
    '44' => [ 'name' => '大分県', 'id' => '1854484' ],
    '45' => [ 'name' =>  '宮崎県', 'id' => '1856710' ],
    '46' => [ 'name' =>  '鹿児島県', 'id' => '1860825' ],
    '47' => [ 'name' => '沖縄県', 'id' => '1854345' ]
  ];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'name', 'email', 'password', 'icon', 'birthplace', 'auth_id',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
      'password', 'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
      'email_verified_at' => 'datetime',
  ];

  public function listings() {
    return $this->hasMany('App\Listing');
  }

  public function tasks()
  {
    return $this->belongsToMany('App\Task', 'listings');
  }

  /**
   * パスワード再設定メールを送信する 
   * */ 
  public function sendPasswordResetNotification($token)
  { 
    Mail::to($this)->send(new ResetPassword($token)); 
  }
  
  /**
   * 出身地名返却
   * @return string
   */
  public function getBirthPlaceNameattribute()
  {
    $birthplace = $this->attributes['birthplace'];
    return self::BIRTHPLACE[$birthplace]['name'];
  }

    /**
   * 出身地ID返却
   * @return string
   */
  public function getBirthPlaceIdattribute()
  {
    $birthplace = $this->attributes['birthplace'];
    return self::BIRTHPLACE[$birthplace]['id'];
  }
}

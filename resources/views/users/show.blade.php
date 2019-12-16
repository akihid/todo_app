@extends('layouts.app')
@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <!-- ユーザー画像やタスク数を表示する -->
      <div class="card">
        <div class="card-header">{{$user->name}}のユーザーページ</div>
        <div class="card-body text-center">
          @isset ($user->icon)
            <img src="{{ $user->icon }}" alt="アバター画像">
          @else
            <img  src="/images/default.jpeg" alt="アバター画像">
          @endisset
        </div>
        <div class="card-body text-left">
          <div class="form-group">
            <label for="email">メールアドレス</label>
            <div class="form-control" >{{ $user->email }}</div>
          </div>

          @if (!empty($user->birthplace))
            <div class="form-group">
              <label for="email">出身地</label>
              <div class="form-control" >{{ $user->birthplace_name }}</div>
            </div>
          @endif

        </div>

        <!-- 現状必要ないが、いずれ使えるように判定しとく -->
        @if ($user->id == Auth::id())
          <a class="btn btn-primary btn-sm d-block mx-auto mb-3" href="{{ route('users.edit', ['user'=>$user]) }}">ユーザー情報の更新</a>
        @endif
      </div>
    </div>
    <!-- リストの一覧を表示する場所 -->
    <div class="col-md-4">
      <nav class="card">
        <div class="card-header">
          リスト一覧
          <div class="text-right">
            <a href="{{ route('listings.create') }}" class="btn btn-primary">
              リストを追加する
            </a>
          </div>
        </div>
      </nav>
      <table class="table">
        @foreach($listings as $list)
          <tbody>
            <tr>
              <td>{{ $list->title }}</td>
            </tr>
          </tbody>
        @endforeach
      </table>
      <div class="card">
          <div class="card-header">タスクの状態</div>
          <div class="text-right">
            <a href="{{ route('listings.create') }}" class="btn btn-primary">
              タスク一覧
            </a>
          </div>
        </div>
    </div>
  </div>
  <div class="bg-primary text-white text-center py-0 mt-3">{{(empty($user->birthplace)) ?'東京都' : $user->birthplace_name}}の直近24時間の3時間ごとの天気</div>
  <div class="row justify-content-center pt-2">
    <div class="card-group">
      @foreach ($weather_infos as $weather_info)      
        <div class="card">
          <div class="card-body">
            <div class="card-title text-center">
              <h5>{{ $weather_info['time'] }}</h5>
            </div>
            <div class="card-text">
              <img src="{{ $weather_info['icon'] }}">
              <p class="text-nowrap">{!! $weather_info['des'] !!}</p>
              <p>{{ $weather_info['temp'] }}℃</p>
              <p>湿度： {{ $weather_info['humidity'] }}%</p>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
@endsection 
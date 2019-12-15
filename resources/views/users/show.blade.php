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
          <a class="btn btn-primary btn-sm d-block mx-auto" href="{{ route('users.edit', ['user'=>$user]) }}">ユーザー情報の更新</a>
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

      <div class="card text-center">
        <div class="card-header">現在の {{ (empty($user->birthplace)) ? '東京都' : $user->birthplace_name }} の天気</div>
          <div class="card-body row">
            <div class="col">
              <img src="{{ $weather_info['icon'] }}">
            </div>
            <div class="col">
              <p class="p-now-des">{!! $weather_info['des'] !!}</p>
              <p class="p-now-temp">{{ $weather_info['temp'] }}℃</p>
              <p class="p-now-humidity">湿度：{{$weather_info['humidity'] }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row justify-content-center pt-2">
      <div class="col-md-8">
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
  </div>
</div>


@endsection 
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


          <!-- タスクの一覧横並べする -->

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
      <table class="table table-hover">
        @foreach($listings as $list)
          <tbody>
            <tr>
              <td>{{ $list->title }}</td>
            </tr>
          </tbody>
        @endforeach
      </table>
      </div>
    </div>
  </div>


  <!-- タスクのカレンダー表示でもする -->
  <div class="row">
  </div>


@endsection 
@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">

        <div class="card-body">
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
          @endif

          @if(Auth::check())
            <div class="mx-auto pt-5 pb-5">
              <nav class="panel panel-default">
                <div class="panel-heading text-center">
                  タスク管理用のリストを作成しましょう
                </div>
                <div class="panel-body pt-2">
                  <div class="text-center">
                    <a href="{{ route('listings.create') }}">リスト作成ページへ→</a>
                  </div>
                </div>
              </nav>
            </div>
          @else
            <div class="mx-auto pt-5 pb-5 text-center">
              <h1><b>Wellcome! ToDo!!!</b></h1>
              <p>タスクをカレンダー表示することで自分のタスクを管理しやすくしています。<br>マイページで24時間の天気情報の確認もできます。</p>
              <a href="https://github.com/akihid/todo_app">GitHub</a><span> | </span>
              <a href="{{ route('login') }}">LogIn</a><span> | </span>
              <a href="{{ route('register') }}">SignUp</a>
            </div>
          @endif 
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

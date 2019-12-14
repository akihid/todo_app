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
              <h1 class="text-center"><b>タスクを管理するにはリストを最初に作る必要があります</b></h1>
              <a href="{{ route('listings.create') }}" class="btn btn-primary">リスト作成ページへ</a>
              <a class="text-center" href="https://github.com/akihid/board">GitHub</a>
            </div>
          @else
            <div class="mx-auto pt-5 pb-5">
              <h1 class="text-center"><b>Hello！</b></h1>
              <p class="text-center">タスク管理サイトです。<br>タスクをカレンダー表示することで自分のタスクを管理しやすくしています。</p>
              <a class="text-center" href="https://github.com/akihid/todo_app">GitHub</a>
            </div>
          @endif 
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

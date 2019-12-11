@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col col-md-4">
        <nav class="card">
          <div class="card-header">リスト一覧</div>
          <div class="card-body">
            <a href="{{ route('listings.create') }}" class="btn btn-default btn-block">
              リストを追加する
            </a>
          </div>
          <div class="list-group">
            @foreach($listings as $listing)
              <a href="{{ route('tasks.index', ['listing' => $listing]) }}">
                {{ $listing->title }}
              </a>
            @endforeach
          </div>
        </nav>
      </div>
      <div class="column col-md-8">
        <div class="card">
          <div class="card-header">タスク</div>
          <div class="card-body">
            <div class="text-right">
              <a href="{{ route('tasks.create', ['listing' => $current_listing]) }}" class="btn btn-default btn-block">
                タスクを追加する
              </a>
            </div>
          </div>
          <table class="table">
            <thead>
            <tr>
              <th>タイトル</th>
              <th>状態</th>
              <th>期限</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
              @foreach($tasks as $task)
                <tr>
                  <td>{{ $task->title }}</td>
                  <td>
                    <span>
                      {{ $task->status }}
                    </span>
                  </td>
                  <td>{{ $task->dead_line }}</td>
                  <td>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
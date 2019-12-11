@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col col-md-4">
        <nav class="card">
          <div class="card-header">
            リスト一覧
            <div class="text-right">
              <a href="{{ route('listings.create') }}" class="btn btn-primary">
                リストを追加する
              </a>
            </div>
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
          <div class="card-header">
            タスク一覧
            <div class="text-right">
            <a href="{{ route('tasks.create', ['listing' => $current_listing]) }}" class="btn btn-primary">
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
                    <span class="label {{ $task->status_class }}">{{ $task->status_label }}</span>
                  </td>
                  <td>{{ $task->formatted_dead_line }}</td>
                  <td>
                  <a href="{{ route('tasks.edit', ['listing' => $task->listing, 'task' => $task]) }}">
                      編集
                    </a>
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
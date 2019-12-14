@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center carddetailPage">
      <div class="col col-md-offset-3 col-md-6">
        <nav class="card">
          <div class="card-header">タスク詳細</div>
            <div class="card-body">
              <div class="form-group">
                <label for="title">タイトル</label>
                <div class="form-control" >{{ $task->title }}</div>
              </div>
              <div class="form-group">
                <label for="content">概要</label>
                <div class="form-control h-auto">{!! nl2br(e($task->content)) !!}</div>
              </div>
              <div class="form-group">
                <label for="start_line">開始日</label>
                <div class="form-control" >{{ $task->formatted_start_line }}</div>
              </div>
              <div class="form-group">
                <label for="dead_line">終了日</label>
                <div class="form-control" >{{ $task->formatted_dead_line }}</div>
              </div>
              <div class="form-group">
                <label for="status">状態</label>
                <div class="form-control" >{{ $task->status_label }}</div>
              </div>
              <div class="form-group">
                <label for="title">設定リスト</label>
                <div class="form-control">{{ $listing->title }}</div>
              </div>

              <p class="text-center">
                <a class="btn btn-primary btn-sm" href="{{ route('tasks.edit', ['listing' => $task->listing, 'task' => $task]) }}">編集する</a>
                <a class="btn btn-danger btn-sm"  onclick="return confirm('このタスクを削除しても大丈夫ですか?')" rel="nofollow" data-method="delete" href="{{ route('tasks.destroy', ['listing' => $task->listing, 'task'=>$task]) }}">削除する</a>
              </p>

            </div>
          </div>
        </nav>
      </div>
    </div>
  </div>
@endsection
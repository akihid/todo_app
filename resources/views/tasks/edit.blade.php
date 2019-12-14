@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col col-md-offset-3 col-md-6">
        <nav class="card">
          <div class="card-header">タスク編集</div>
          <div class="card-body">
            @include('errors.form_errors')
            
            <form action="{{ route('tasks.update', ['task' => $task, 'listing' => $listing]) }}" method="POST">
              @csrf
              @method('PATCH')
              <div class="form-group">
                <label for="title">タイトル</label>
                <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $task->title) }}" />
              </div>
              <div class="form-group">
                <label for="content">概要</label>
                <textarea name="content" id="content" cols="20" rows="5" class="form-control">{{ old('content', $task->content) }}</textarea>
              </div>
              <div class="form-group">
                <label for="start_line">開始日</label>
                <input type="date" class="form-control" name="start_line" id="start_line" value="{{ old('start_line', $task->start_line) }}" />
              </div>
              <div class="form-group">
                <label for="dead_line">終了日</label>
                <input type="date" class="form-control" name="dead_line" id="dead_line" value="{{ old('dead_line', $task->dead_line) }}" />
              </div>
              <div class="form-group">
                <label for="status">状態</label>
                <select name="status" id="status" class="form-control">
                  @foreach(\App\Task::STATUS as $key => $val)
                  <option value="{{ $key }}" @if($key == old('status', $task->status)) selected  @endif >
                  {{ $val['label'] }} </option>

                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="title">設定リスト</label>
                <select name="listing_id" id="listing_id" class="form-control">
                  @foreach($listings as $list)
                    <option value="{{ $list->id }}" @if( $list->id == old('listing_id', $listing->id)) selected  @endif >
                      {{ $list->title }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary">更新</button>
              </div>
            </form>
          </div>
        </nav>
      </div>
    </div>
  </div>
@endsection
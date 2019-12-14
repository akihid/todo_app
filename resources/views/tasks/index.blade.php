@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col col-md-4">
        @include('listings._index', ['listings' => $listings])
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

          <div class="card-body">
            <form class="search-box" action="{{ route('tasks.index', ['listing' => $current_listing])}}" method="GET">
              @csrf
              <div  class="form-row">
                <div class="col form-group">
                  <label for="status">タスク名</label>
                  <input type="text" name="search_title" class="form-control" id="search_title"  value = "{{ $search_params['search_title'] }}" placeholder="タスク名を入力してください">
                </div>
                <div class="col form-group">
                  <label for="status">状態</label>
                  <select name="search_status" id="search_status" class="form-control">
                    <option value=""></option>
                    @foreach(\App\Task::STATUS as $key => $val)
                      <option value="{{ $key }}" @if($key == $search_params['search_status']) selected  @endif>
                        {{ $val['label'] }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <label for="search_deadline">期限</label>
              <div class="form-group form-row">
                <input type="date" class="col form-control" name="search_deadline_start" id="search_deadline_start" value = "{{ $search_params['search_deadline_start'] }}" />
                <div class="align-items-center">~</div>
                <input type="date" class="col form-control" name="search_deadline_end" id="search_deadline_end" value = "{{ $search_params['search_deadline_end'] }}" />
              </div>
              <div class="text-right">
                <button type="submit" class="btn btn-primary">検索</button>
              </div>
            </form>
          </div>

          <table class="table table-hover">
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
                    <span class="{{ $task->status_class }}">{{ $task->status_label }}</span>
                  </td>
                  <td>
                    {{ $task->formatted_dead_line }}
                    @if ($task->is_deadline_over_today)
                      <i class="fas fa-exclamation-triangle" style="color:red;"></i>
                    @endif
                  </td>
                  

                  <td>
                    <a href="{{ route('tasks.show', ['listing' => $task->listing, 'task' => $task]) }}">詳細</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    @include('tasks._calender', ['tasks' => $tasks])
  </div>
@endsection
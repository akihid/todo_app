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
            <a href="{{ route('tasks.create', ['listing' => $listing]) }}" class="btn btn-primary">
                タスクを追加する
              </a>
            </div>
          </div>

          <div class="card-body">
            @include('tasks._search')
          </div>

          @include('tasks._index')
          {{ $tasks->appends(Request::except('page'))->links('pagination.default') }}
        </div>
      </div>
    </div>

    @include('tasks._calender', ['tasks' => $tasks])
  </div>
@endsection
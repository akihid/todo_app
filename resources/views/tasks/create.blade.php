@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col col-md-offset-3 col-md-6">
        <nav class="card">
          <div class="card-header">タスク追加</div>
          <div class="card-body">
            @include('errors.form_errors')
            
            <form action="{{ route('tasks.store', ['listing' => $listing]) }}" method="POST">
              @csrf
              <div class="form-group">
                <label for="title">タイトル</label>
                <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" />
              </div>
              <div class="form-group">
                <label for="content">概要</label>
                <input type="text" class="form-control" name="content" id="content" value="{{ old('content') }}" />
              </div>
              <div class="form-group">
                <label for="start_line">開始日</label>
                <input type="date" class="form-control" name="start_line" id="start_line" value="{{ old('start_line') }}" />
              </div>
              <div class="form-group">
                <label for="dead_line">終了日</label>
                <input type="date" class="form-control" name="dead_line" id="dead_line" value="{{ old('dead_line') }}" />
              </div>
              <div class="text-right">
                <button type="submit" class="btn btn-primary">送信</button>
              </div>
            </form>
          </div>
        </nav>
      </div>
    </div>
  </div>
@endsection
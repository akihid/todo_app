@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col col-md-offset-3 col-md-6">
        <nav class="card">
          <div class="card-header">リスト追加</div>
          <div class="card-body">
            @include('errors.form_errors')
            
            <form action="{{ route('listings.store') }}" method="post">
              @csrf
              @include('listings._form', ['title' => '', 'submitBtn' => '作成'])
            </form>
          </div>
        </nav>
      </div>
    </div>
  </div>
@endsection
@extends('layouts.app')
@section('content')

@include('errors.form_errors')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-8 col-md-12">
      <div class="card">
        <div class="card-header">ユーザー情報の更新</div>
          <div class="card-body">
            <form method="POST" action="{{ route('users.update', ['user' => Auth::user()]) }}" enctype="multipart/form-data">
              @csrf
              @method('PATCH')

              <div class="mb-1 text-center">
                @isset ($user->icon)
                  <img src="{{ $user->icon }}" alt="アバター画像">
                @else
                  <img  src="/images/default.jpeg" alt="アバター画像">
                @endisset
              </div>

              <div class="form-group row">
                <input type="file" id="icon" name="icon" class="form-control">
              </div>

              <label for="name" class="col-form-label text-md-right">名前</label>
              <div class="form-group row">
                <input type="text" class="form-control m-1" name="name" value="{{ old('name', $user->name) }}">
              </div>

              <label for="email" class="col-form-label text-md-right">メールアドレス</label>
              <div class="form-group row">
                <input type="text" class="form-control m-1" name="email" value="{{ old('email', $user->email) }}">
              </div>

              <label for="birthplace" class="col-form-label text-md-right">出身地</label>
              <div class="form-group row">
              <select name="birthplace" class='form-control'>
                <option value=""></option>
                @foreach(\App\User::BIRTHPLACE as $key => $val)
                  <option value="{{ $key }}" @if($key == $user->birthplace) selected  @endif>
                    {{ $val }}
                  </option>
                @endforeach
              </select>

              </div>
              <div class="form-group row">
              <input type="submit" class="btn btn-primary d-block mx-auto" value="更新">
              </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection
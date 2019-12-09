@extends('layouts.app')
@section('content')

<div class="row">
  <div class="col-lg-6 col-md-12">
    <h1>リスト一覧</h1>
    @forelse ($listings as $list)
      {{ $list->title }}
    @empty
      <p class="text-center">まだリストがありません</p>
    @endforelse
  </div>
</div>
@endsection
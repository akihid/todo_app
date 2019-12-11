@extends('layouts.app')
@section('content')

<div class="row">
  <div class="col-lg-6 col-md-12">
    <a href="{{ route('listings.create') }}">作成する</a>
    <h1>リスト一覧</h1>
    @forelse ($listings as $listing)
    <a href="{{ route('tasks.index', ['listing' => $listing]) }}">
                {{ $listing->title }}
              </a>
      {{ $listing->title }}
      <a class="btn btn-primary btn-sm" href="{{ route('listings.edit', ['listing'=>$listing]) }}">修正する</a>
      <form method="post" action="{{ route('listings.destroy', ['listing'=>$listing]) }}">
        @csrf
        @method('DELETE')
        <input type="submit" value="削除" class="btn btn-danger btn-sm" onclick='return confirm("本当に削除しますか？");'>
      </form>
    @empty
      <p class="text-center">まだリストがありません</p>
    @endforelse
  </div>
</div>
@endsection
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
      <a class="btn btn-primary btn-sm" href="{{ route('listings.edit', ['listing'=>$listing]) }}">修正する</a>
      <form method="post" action="{{ route('listings.destroy', ['listing'=>$listing]) }}">
        @csrf
        @method('DELETE')
        <input type="submit" value="削除" class="btn btn-danger btn-sm" onclick='return confirm("本当に削除しますか？");'>
      </form>
    @endforeach
  </div>
</nav>
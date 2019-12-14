<nav class="card">
  <div class="card-header">
    リスト一覧
    <div class="text-right">
      <a href="{{ route('listings.create') }}" class="btn btn-primary">
        リストを追加する
      </a>
    </div>
  </div>
    @foreach($listings as $listing)
    <div class="card">
      <div class="card-body @if($current_listing == $listing) bg-warning @endif">
        <a href="{{ route('tasks.index', ['listing' => $listing]) }}" class="h4">{{ $listing->title }}</a>
        <p class="text-right">
          <a href="{{ route('listings.edit', ['listing'=>$listing]) }}"><i class="fas fa-pen"></i></a>
          <a onclick="return confirm('{{ $listing->title }}を削除して大丈夫ですか？')" href="{{ route('listings.destroy', ['listing'=>$listing]) }}"><i class="fas fa-trash"></i></a>
        </p>
      </div>
      
    </div>
    @endforeach
</nav>
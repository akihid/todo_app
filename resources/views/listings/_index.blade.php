<nav class="card">
  <div class="card-header">
    リスト一覧
    <div class="text-right">
      <a href="{{ route('listings.create') }}" class="btn btn-primary">
        リストを追加する
      </a>
    </div>
  </div>
</nav>
<table class="table table-hover">
  @foreach($listings as $listing)
    <tbody>
      <tr class="@if($current_listing == $listing) table-secondary @endif">
        <td><a href="{{ route('tasks.index', ['listing' => $listing]) }}">{{ $listing->title }}</a></td>
        <td><a href="{{ route('listings.edit', ['listing'=>$listing]) }}"><i class="fas fa-pen"></i></a></td>
        <td><a onclick="return confirm('{{ $listing->title }}を削除して大丈夫ですか？')" href="{{ route('listings.destroy', ['listing'=>$listing]) }}"><i class="fas fa-trash"></i></a></td>
      </tr>
    </tbody>
  @endforeach
</table>


  <!-- <div class="card">
    <ul class="list-group list-group-flush">
      <li class="list-group-item">
        <a href="{{ route('tasks.index', ['listing' => $listing]) }}">{{ $listing->title }}
        <a href="{{ route('listings.edit', ['listing'=>$listing]) }}"><i class="fas fa-pen"></i></a>
        <a onclick="return confirm('{{ $listing->title }}を削除して大丈夫ですか？')" href="{{ route('listings.destroy', ['listing'=>$listing]) }}"><i class="fas fa-trash"></i></a>
      </li>
    </ul>
  </div> -->
  

  <!-- @foreach($listings as $listing)
    <div class="card">
      <div class="card-body @if($current_listing == $listing) bg-secondary @endif">
        <a href="{{ route('tasks.index', ['listing' => $listing]) }}" class="h4">{{ $listing->title }}</a>
        <p class="text-right">
          <a href="{{ route('listings.edit', ['listing'=>$listing]) }}"><i class="fas fa-pen"></i></a>
          <a onclick="return confirm('{{ $listing->title }}を削除して大丈夫ですか？')" href="{{ route('listings.destroy', ['listing'=>$listing]) }}"><i class="fas fa-trash"></i></a>
        </p>
      </div>
      
    </div>
    @endforeach -->
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
  @foreach($listings as $list)
    <tbody>
      <tr class="@if($listing == $list) table-secondary @endif">
        <td><a href="{{ route('tasks.index', ['listing' => $list]) }}">{{ $list->title }}</a></td>
        <td><a href="{{ route('listings.edit', ['listing'=>$list]) }}"><i class="fas fa-pen"></i></a></td>
        <td><a onclick="return confirm('{{ $list->title }}を削除して大丈夫ですか？')" rel="nofollow" data-method="delete" href="{{ route('listings.destroy', ['listing'=>$list]) }}"><i class="fas fa-trash"></i></a></td>
      </tr>
    </tbody>
  @endforeach
</table>
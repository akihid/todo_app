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
        <td><a class="btn btn-primary btn-sm" href="{{ route('listings.edit', ['listing' => $list]) }}">修正</a></td>
        <td>
          <form method="post" action="{{ route('listings.destroy', ['listing'=>$list])}}">
            @csrf
            @method('DELETE')
            <input type="submit" value="削除" class="btn btn-danger btn-sm" onclick='return confirm("本当に削除しますか？");'>
          </form>
        </td>
      </tr>
    </tbody>
  @endforeach
</table>
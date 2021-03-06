<form class="search-box" action="{{ route('tasks.index', ['listing' => $listing])}}" method="GET">
  @csrf
  <div  class="form-row">
    <div class="col form-group">
      <label for="status">タスク名</label>
      <input type="text" name="search_title" class="form-control" id="search_title"  value = "{{ $search_params['search_title'] }}" placeholder="タスク名を入力してください">
    </div>
    <div class="col form-group">
      <label for="status">状態</label>
      <select name="search_status" id="search_status" class="form-control">
        <option value=""></option>
        @foreach(\App\Task::STATUS as $key => $val)
          <option value="{{ $key }}" @if($key == $search_params['search_status']) selected  @endif>
            {{ $val['label'] }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="col form-group">
      <label for="tag">タグ</label>
      <input type="text" name="search_tag" class="form-control" id="search_tag"  value = "{{ $search_params['search_tag'] }}" placeholder="タグ名を入力してください">
    </div>
    <div class="col form-group">
      <label for="sort_by">ソート順</label>
      <select name="sort_by" id="sort_by" class="form-control">
        <option value=""></option>
        <option value="status" @if($search_params['sort_by'] == 'status') selected  @endif >状態でソート</option>
        <option value="dead_line" @if($search_params['sort_by'] == 'dead_line') selected  @endif >期限でソート</option>
      </select>
    </div>
  </div>
  <label for="search_deadline">期限</label>
  <div class="form-group form-row">
    <input type="date" class="col form-control" name="search_deadline_start" id="search_deadline_start" value = "{{ $search_params['search_deadline_start'] }}" />
    <div class="align-items-center">~</div>
    <input type="date" class="col form-control" name="search_deadline_end" id="search_deadline_end" value = "{{ $search_params['search_deadline_end'] }}" />
  </div>
  <div class="text-right">
    <a class="btn btn-secondary btn-sm" href="{{ route('tasks.store', ['listing' => $listing]) }}">クリア</a>
    <button type="submit" class="btn btn-primary btn-sm">検索</button>
  </div>
</form>

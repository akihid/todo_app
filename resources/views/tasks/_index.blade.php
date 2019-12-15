<table class="table table-hover">
  <thead>
  <tr>
    <th>タイトル</th>
    <th>状態</th>
    <th>期限</th>
    <th></th>
  </tr>
  </thead>
  <tbody>
    @foreach($tasks as $task)
      <tr>
        <td>{{ $task->title }}</td>
        <td>
          <span class="{{ $task->status_class }}">{{ $task->status_label }}</span>
        </td>
        <td>
          {{ $task->formatted_dead_line }}
          @if ($task->is_deadline_over_today)
            <i class="fas fa-exclamation-triangle" style="color:red;"></i>
          @endif
        </td>
        <td>
          <a href="{{ route('tasks.show', ['listing' => $task->listing, 'task' => $task]) }}">詳細</a>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

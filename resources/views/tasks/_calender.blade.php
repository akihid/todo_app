<div id='calendar' class="mt-5"></div>

<link href='/fullcalendar/core/main.css' rel='stylesheet' />
<link href='/fullcalendar/daygrid/main.css' rel='stylesheet' />
<script src='/fullcalendar/core/main.js'></script>
<script src='/fullcalendar/daygrid/main.js'></script>
<script src='/fullcalendar/core/locales/ja.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
    plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
    locale: 'ja',
    events : [
      @foreach($tasks as $task)
      {
        title : '{{ $task->title }}',
        start : '{{ $task->start_line }}',
        url: '{{ route('tasks.show', ['listing' => $task->listing, 'task' => $task]) }}',
        textColor: 'white',
        color : '{{ $task->status_color }}',
        
        @if ($task->dead_line)
          end: '{{ $task->dead_line }}',
        @endif
      },
      
      @endforeach
    ]
  });
  calendar.setOption('locale', 'ja');
  calendar.render();
});   
</script>
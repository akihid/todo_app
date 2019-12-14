<div id='calendar' class="mt-5"></div>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/lang/ja.js"></script> 

<script>
  $(document).ready(function() {
    $('#calendar').fullCalendar({
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
      ],
    });
  });
</script>
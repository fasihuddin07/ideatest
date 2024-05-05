<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    
    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <title>Idea Test</title>
    <style>
  

    ::-webkit-scrollbar {
       width: 5px;
    }

    ::-webkit-scrollbar-track {
       box-shadow: inset 0 0 5px grey;
       border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
       background: #404040 ;
       border-radius: 5px;
    }

    /* ::-webkit-scrollbar-thumb:hover {
       background: #404040;
    } */
    html {
       zoom: 80%;
    }
  </style>
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container">
        <a class="navbar-brand" href="#">IDEA TEST</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
          
            <li class="nav-item">
              <a class="nav-link" href="{{ url('auth/logout') }}">Logout</a>
            </li>
            <li class="nav-item">
              @if (Auth::check())
              <a class="nav-link" href="#" style="color: #000">{{ Auth::user()->name }}</a>
              @endif
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->

    <div class="content">
      <div class="container">
        <div class="col-md-3" style="float: right">
          <div class="form-group">
              <select class="form-control" id="filterStatus">
                <option value="All">All</option>
                <option value="Incomplete">Incomplete</option>
                <option value="Complete">Complete</option>
            </select>
            </div>

            <div class="form-group">
              <select id="sortByName" class="form-control">
                  <option value="asc">By Task Title (A-Z)</option>
                  <option value="desc">By Task Title  (Z-A)</option>
              </select>
          </div>
       
      </div>
      
        <a href="#" class="btn btn-outline-success" id="addTasksBtn" style="float: right">Add Tasks</a>
        <h2 class="mb-5">TASKS</h2>
    
        <div class="table-responsive custom-table-responsive">
          <table class="table custom-table">
            <thead>
              <tr>  
             
                <th scope="col">S#NO</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Deadline</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>

              </tr>
            </thead>
            <tbody id="taskTableBody">
              @php
                $i = 1;
              @endphp
              @forelse ($task as $tasks)
              
              <tr scope="row" class="service-row">
            
                <td>
                  {{ $i++ }}
                </td>
                <td>{{ $tasks->title }}</td>
                <td>
                  {{ $tasks->description }}
                </td>
                <td>{{ $tasks->deadline }}</td>
                <td>
                
                  <select class="form-control update-status" style="
                  color: #777;
                  background-color: #212529;
                  border: #212529;"
                   data-task-id="{{ $tasks->id }}">
                    <option value="{{ $tasks->status }}">{{ $tasks->status }}</option>
                    @if ($tasks->status == "Incomplete")
                    <option value="Complete">Complete</option>
                    @else
                    <option value="Incomplete">Incomplete</option>
                    @endif

                </select>
                </td>
                <td>
                  <a href="{{ url('destroy') }}/{{ $tasks->id }}" class="btn btn-outline-danger">Delete</a>
                  <a href="#" class="btn btn-outline-warning assigntaskBtn" data-task-id="{{ $tasks->id }}">Assign</a>
                </td>
              </tr>
              @empty
                <tr>
                  <td colspan="6" class="text text-center">No Data Insert</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
      {{-- <-------Add Task Modal ----> --}}
    <div class="modal fade" id="addTasksModal" tabindex="-1" role="dialog" aria-labelledby="addTasksModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="addTasksModalLabel">Add Tasks</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form action="{{ url('store') }}" method="POST">
                      @csrf
                      <div class="form-group">
                          <label for="taskName">Title</label>
                          <input type="text" name="title" class="form-control">
                      </div>
                      <div class="form-group">
                          <label for="taskName">Description</label>
                          <textarea type="text" name="description" class="form-control"></textarea>
                      </div>
                      <div class="form-group">
                          <label for="taskName">Deadline</label>
                          <input type="date" name="deadline" class="form-control">
                      </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-outline-primary">ADD TASK</button>
                  </form>
              </div>
          </div>
      </div>
  </div>
  {{-- <---End---> --}}
  {{-- <-------Task Assign Modal ----> --}}
    <div class="modal fade" id="assigntaskModal" tabindex="-1" role="dialog" aria-labelledby="assignTasksModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="assignTasksModalLabel">Assign Task</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form action="{{ url('assigntask') }}" method="POST">
                      @csrf
                      <input type="hidden" id="task_id" name="task_id">
                      <div class="form-group">
                          <label for="taskName">Select Users</label>
                          <select name="assign_user" id="" class="form-control">
                            <option value="">Select Users</option>
                            @forelse ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @empty
                              <option value="">No Users</option>
                            @endforelse
                          </select>
                      </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-outline-primary">Assign</button>
                  </form>
              </div>
          </div>
      </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
  $(document).ready(function() {
     
      // Sort tasks alphabetically by name
      $('#sortByName').change(function() {
          var order = $(this).val();
          // alert(order);
          sortTasks(order);
      });

      function sortTasks(order) {
        // alert(order);
          var rows = $('#taskTableBody tr').get();
          // alert(rows);
          rows.sort(function(a, b) {
              var keyA = $(a).children('td:eq(1)').text().toUpperCase();
              // console.log(keyA);
              var keyB = $(b).children('td:eq(1)').text().toUpperCase();
              if (order === 'asc') {
                  return (keyA < keyB) ? -1 : (keyA > keyB) ? 1 : 0;
              } else {
                  return (keyA > keyB) ? -1 : (keyA < keyB) ? 1 : 0;
              }
          });
          $.each(rows, function(index, row) {
              $('#taskTableBody').append(row);
          });
      }
  });
</script>

<script>
  $(document).ready(function(){
      $('#addTasksBtn').click(function(){
          $('#addTasksModal').modal('show');
      });
  });
  $('.assigntaskBtn').click(function () {
            var taskId = $(this).data('task-id');
            $('#task_id').val(taskId);
            $('#assigntaskModal').modal('show');
        });
  </script>

<script>
  $(document).ready(function() {
      $('.update-status').change(function() {
          var taskId = $(this).data('task-id');
          var status = $(this).val();
          // alert(status);
          $.ajax({
              url: "{{ url('update') }}",
              method: 'POST',
              data: {
                  _token: "{{ csrf_token() }}",
                  taskId: taskId,
                  status: status
              },
              success: function(response) {
                  console.log(response);
              },
              error: function(e, status, error) {
                  console.error(e.responseText);
              }
          });
      });
  });
  </script>
<script>
  $(document).ready(function () {
      $('#filterStatus').on('change', function () {
          var selectedStatus = $(this).val();

          // Show or hide table rows based on the selected status
          $('.service-row').each(function () {
              var rowStatus = $(this).find('.update-status').val();
              var showRow = selectedStatus === 'All' || rowStatus === selectedStatus;
              $(this).toggle(showRow);
          });
      });
  });
</script>
  
  </body>
</html>

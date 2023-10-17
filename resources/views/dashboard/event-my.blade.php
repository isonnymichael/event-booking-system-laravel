@extends('layouts.master')
@section("title", $title)

@section("content")
    <!-- DataTables -->
    <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="/plugins/summernote/summernote-bs4.min.css">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{$title}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @foreach ($breadcrumbs as $b)
                        <li @class(["breadcrumb-item","active" => empty($b['link'])])>
                        @if (empty($b['link']))
                        {{$b['title']}}
                        @else
                        <a href="{{$b['link']}}">{{$b['title']}}</a>
                        @endif
                        </li>
                    @endforeach
                </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
  
      <!-- Main content -->
      <section class="content pb-5">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title"></h3>
                  @if (Auth::user()->role == "admin")
                    <div class="float-right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modal-add-event">Add Event</button>
                    </div>
                    
                  @endif
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="data-table" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                      <th style="width:1%">#</th>
                      <th>Title</th>
                      <th>Date</th>
                      <th>Time</th>
                      <th>Location</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($events as $event)
                        <tr>
                            <td>{{$loop->iteration}}.</td>
                            <td><a href="/event/{{$event->id}}">{{$event->title}}</a></td>
                            <td>{{\Carbon\Carbon::parse($event->date)->formatLocalized('%a, %d %b %Y')}}</td>
                            <td>{{\Carbon\Carbon::parse($event->time)->format('H:i') }}</td>
                            <td>{{$event->location}}</td>
                      </tr>
                    @endforeach
                    
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </section>

    {{-- Modal Delete --}}
    <div class="modal fade" id="modal-delete-event">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Event</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure to delete <span class="font-weight-bold" id="delete-title-text"></span>?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancel</button>
                    <form method="POST" action="/event/delete">
                        @csrf
                        <input type="hidden" id="delete-id-event" name="id">
                        <input type="hidden" id="delete-title-event" name="title">

                        <button type="submit" class="btn btn-outline-light">Yes</button>
                    </form>
                    
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    {{-- Modal Edit --}}
    <div class="modal fade" id="modal-edit-event">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Event</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-edit-event" method="POST" action="/event/edit">
                        @csrf
                        <input type="hidden" name="id" id="edit-id">
                        <div class="form-group">
                            <label for="edit-title">Title</label>
                            <input name="title" type="text" class="form-control" id="edit-title" placeholder="Enter Title ..." autofocus required>
                        </div>
                        <div class="form-group">
                            <label for="edit-description">Description</label>
                            <textarea name="description" id="edit-description" class="form-control" rows="3" placeholder="Enter Description..." required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-6 form-group">
                                <label for="edit-date">Date</label>
                                <input name="date" type="date" class="form-control" id="edit-date" required>
                            </div>

                            <div class="col-6 form-group">
                                <label for="edit-time">Time</label>
                                <input name="time" type="time" class="form-control" id="edit-time" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 form-group">
                                <label for="edit-location">Location</label>
                                <input name="location" type="text" class="form-control" id="edit-location" required>
                            </div>

                            <div class="col-6 form-group">
                                <label for="edit-time">Slots</label>
                                <input name="slots_available" type="number" class="form-control" id="edit-slots" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" form="form-edit-event" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    <!-- /.modal-dialog -->
    </div>

    {{-- Modal Add --}}
    <div class="modal fade" id="modal-add-event">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Event</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-add-event" method="POST" action="/event/add">
                        @csrf
                        <div class="form-group">
                            <label for="add-title">Title</label>
                            <input name="title" type="text" class="form-control" id="add-title" placeholder="Enter Title ..." autofocus required>
                        </div>
                        <div class="form-group">
                            <label for="add-description">Description</label>
                            <textarea name="description" id="add-description" class="form-control" rows="3" placeholder="Enter Description..." required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-6 form-group">
                                <label for="add-date">Date</label>
                                <input name="date" type="date" class="form-control" id="add-date" required>
                            </div>

                            <div class="col-6 form-group">
                                <label for="add-time">Time</label>
                                <input name="time" type="time" class="form-control" id="add-time" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 form-group">
                                <label for="add-location">Location</label>
                                <input name="location" type="text" class="form-control" id="add-location" required>
                            </div>

                            <div class="col-6 form-group">
                                <label for="add-time">Slots</label>
                                <input name="slots_available" type="number" class="form-control" id="add-slots" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" form="form-add-event" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->

    <!-- jQuery -->
    <script src="/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="/plugins/jszip/jszip.min.js"></script>
    <script src="/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- Toastr -->
    <script src="/plugins/toastr/toastr.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Summernote -->
    <script src="/plugins/summernote/summernote-bs4.min.js"></script>

    <script>
    $(function () {

        $('#data-table').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "autoWidth": true,
            "responsive": true,
        });

        var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
        });

        @if (session('status'))
            Toast.fire({
                icon: 'success',
                title: '{{session('status')}}'
            });
        @endif
        @if (session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{session('error')}}'
            });
        @endif
        
    });

    $('.modal').on('shown.bs.modal', function () {
        $(this).find("input:visible:first").focus();

        $('#add-description').summernote()
        $('#edit-description').summernote();
        $('.dropdown-toggle').dropdown();
    })  

    function editEvent(event){
        $('#edit-description').summernote('code', '');

        $("#edit-id").val(event.id);
        $("#edit-title").val(event.title);
        $("#edit-description").val(event.description);
        $("#edit-date").val(event.date);
        $("#edit-time").val(event.time);
        $("#edit-location").val(event.location);
        $("#edit-slots").val(event.slots_available);

        $("#modal-edit-event").modal("show");

        setTimeout(function() { 
            $('#edit-description').summernote('code', event.description);
        }, 400);
        
    }

    function deleteEvent(id, title){
        $("#delete-title-text").text(title);
        $("#delete-id-event").val(id);
        $("#delete-title-event").val(title);
        
        $("#modal-delete-event").modal("show");
    }


    </script>
@endsection

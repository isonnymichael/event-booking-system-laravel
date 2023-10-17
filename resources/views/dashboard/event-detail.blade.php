@extends('layouts.master')
@section("title", $title)

@section("content")
    <!-- Toastr -->
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

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
            
            <!-- Default box -->
            <div class="card"> 
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                            {!! $event->description !!}
                        </div>


                        <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                            <div class="text-muted">
                                <p class="text-sm">Date
                                <b class="d-block">{{\Carbon\Carbon::parse($event->date)->formatLocalized('%A, %d %B %Y')}}</b>
                                </p>
                                <p class="text-sm">Time
                                <b class="d-block">{{\Carbon\Carbon::parse($event->time)->format('H:i') }}</b>
                                </p>
                                <p class="text-sm">Location
                                <b class="d-block">{{$event->location}}</b>
                                </p>
                                <p class="text-sm">Slots
                                <b class="d-block">{{ $event->slots_available }}</b>
                                </p>
                                @if (Auth::user()->role == "admin")
                                    <p class="text-sm">Created by
                                    <b class="d-block">{{ $event->name }}</b>
                                @endif
                                </p>
                            </div>

                            @if (Auth::user()->role == "admin" || $event->created_by_user_id == Auth::user()->id)
                                <div class="text-center alert alert-primary">
                                    You are Administrator of this Event
                                </div>
                            @elseif ($isBooked)
                                <div class="text-center alert alert-warning">
                                    You have registered for this event
                                </div>
                            @elseif ($isFull)
                                <div class="text-center alert alert-danger">
                                    This Event is full
                                </div>
                            @else
                                <div class="text-center mt-5 mb-3">
                                    <form action="/event/booking" method="POST">
                                        @csrf
                                        <input type="hidden" name="event_id" value="{{$idEvent}}">
                                        <button class="btn btn-block btn-sm btn-success">Book Event</button>
                                    </form>
                                </div>
                            @endif 
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>

            <!-- /.card -->
        <!-- /.card -->
        </div>
        <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

     <!-- Toastr -->
     <script src="/plugins/toastr/toastr.min.js"></script>
     <!-- SweetAlert2 -->
     <script src="/plugins/sweetalert2/sweetalert2.min.js"></script>
     <!-- Summernote -->
    <script>
            $(function () {

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
    </script>
@endsection
@extends('layouts.master')
@section("title", "Dashboard")

@section("content")
  <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">{{$title}}</h1>
          </div><!-- /.col -->
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
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          @if (Auth::user()->role == "user")
          <div class="col-12 col-sm-6 col-md-3">
            <div onclick="window.location.href = '/event/contribute'" style="cursor: pointer" class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-calendar-plus"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Contribute Event</span>
                <span class="info-box-number">
                  {{$datas['card']['contribute_events']}}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div onclick="window.location.href = '/event/my'" style="cursor: pointer" class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-calendar-check"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">My Event</span>
                <span class="info-box-number">
                  {{$datas['card']['my_events']}}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          @endif
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div onclick="window.location.href = '/event/list'" style="cursor: pointer" class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-calendar"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">All Event</span>
                <span class="info-box-number">{{$datas['card']['events']}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          @if (Auth::user()->role == "admin")
          <div class="col-12 col-sm-6 col-md-3">
            <div onclick="window.location.href = '/event/booked'" style="cursor: pointer" class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-calendar-check"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Event Booked</span>
                <span class="info-box-number">{{$datas['card']['bookeds']}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

            <div class="col-12 col-sm-6 col-md-3">
              <div onclick="window.location.href = '/users'" style="cursor: pointer" class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Users</span>
                  <span class="info-box-number">{{$datas['card']['users']}}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div> 
          @endif

          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <div class="col-md-8">

            <!-- TABLE: LATEST ORDERS -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Latest Events</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  @if (count($datas['latest_event']) > 0)
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>Title</th>
                      <th>Date</th>
                      <th>Time</th>
                      <th>Location</th>
                      <th>Slots</th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach ($datas['latest_event'] as $event)
                        <tr>
                            <td><a href="/event/{{$event->id}}">{{$event->title}}</a></td>
                            <td>{{\Carbon\Carbon::parse($event->date)->formatLocalized('%a, %d %b %Y')}}</td>
                            <td>{{\Carbon\Carbon::parse($event->time)->format('H:i') }}</td>
                            <td>{{$event->location}}</td>
                            <td class="text-right">
                                @if (Auth::user()->role == "admin")
                                    {{$event->total_booking}}/{{$event->slots_available}}
                                @else
                                   {{$event->slots_available}}
                                @endif
                            </td>
                      </tr>
                    @endforeach
                    </tbody>
                  </table>
                  @else
                  <div class="mx-3 alert alert-warning">
                    No Event Yet
                  </div>
                  @endif
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->

          <div class="col-md-4">

            <!-- Event LIST -->
            <div class="card">
              <div class="card-header">
                @if (Auth::user()->role == "admin")
                <h3 class="card-title">Recently Added Event</h3>
                @else
                <h3 class="card-title">Upcoming My Event</h3>
                @endif
                
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                @if (count($datas['recenly_added_event']) == 0)
                  <div class="mx-3 alert alert-warning">
                    No Event Yet
                  </div>
                @endif
                <ul class="products-list product-list-in-card pl-2 pr-2">
                  @foreach ($datas['recenly_added_event'] as $event)
                    <li class="item">
                      <div class="">
                        <a href="/event/{{$event->id}}" class="product-title">{{$event->title}}
                          @if (Auth::user()->role == "admin")
                          <span class="badge badge-primary float-right">
                            {{$event->total_booking}}/{{$event->slots_available}}
                          </span>
                          @endif
                        </a>
                        <span class="product-description small">
                          Created by {{$event->name}} | 
                          {{\Carbon\Carbon::parse($event->date)->formatLocalized('%a, %d %b %Y')}} {{\Carbon\Carbon::parse($event->time)->format('H:i') }} |
                          {{$event->location}}
                        </span>
                      </div>
                    </li>
                    <!-- /.item -->
                @endforeach
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->

@endsection

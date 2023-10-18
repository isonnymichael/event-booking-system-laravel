@extends('layouts.master')
@section("title", $title)

@section('content')
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
            <div class="col-md-3">
  
              <!-- Profile Image -->
              <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                  <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                         src="/img/avatar5.png"
                         alt="User profile picture">
                  </div>
  
                  <h3 class="profile-username text-center">{{$user->name}}</h3>
  
                  <p class="text-muted text-center">{{$user->email}}</p>
  
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
  
              <!-- About Me Box -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">About Me</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
  
                  <strong><i class="fas fa-map-marker-alt mr-1"></i> Created At</strong>
  
                  <p class="text-muted">
                    {{\Carbon\Carbon::parse($user->created_at)->formatLocalized('%a, %d %b %Y')}}
                    {{\Carbon\Carbon::parse($user->created_at)->format('H:i') }}
                </p>
  
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
              <div class="card">
                <div class="card-body">
                  <div class="tab-content">
                    <div class="" id="settings">
                      <form action="/profile" method="POST" class="form-horizontal" oninput='inputNewPassword2.setCustomValidity(inputNewPassword2.value != inputNewPassword.value ? "Passwords do not match." : "")'>
                        @csrf
                        <input type="hidden" name="id" value="{{$user->id}}">
                        <div class="form-group row">
                          <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                          <div class="col-sm-10">
                            <input name="name" type="text" class="form-control" id="inputName" value="{{$user->name}}" placeholder="Name">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                          <div class="col-sm-10">
                            <input style="background-color: #717375 !important;" type="email" class="form-control" id="inputEmail" value="{{$user->email}}" disabled readonly>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputOldPassword" class="col-sm-2 col-form-label">Old Password</label>
                          <div class="col-sm-10">
                            <input name="oldPassword" type="password" class="form-control" id="inputOldPassword">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputNewPassword" class="col-sm-2 col-form-label">New Password</label>
                          <div class="col-sm-10">
                            <input name="newPassword" type="password" class="form-control" id="inputNewPassword">
                          </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputNewPassword2" class="col-sm-2 col-form-label">Repeat Password</label>
                            <div class="col-sm-10">
                              <input type="password" class="form-control" id="inputNewPassword2">
                            </div>
                          </div>
                        <div class="form-group row">
                          <div class="offset-sm-2 col-sm-10 text-right">
                            <button type="submit" class="btn btn-danger">Save Changes</button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <!-- /.tab-pane -->
                  </div>
                  <!-- /.tab-content -->
                </div><!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->

    <!-- Toastr -->
    <script src="/plugins/toastr/toastr.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="/plugins/sweetalert2/sweetalert2.min.js"></script>

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
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SIMKEMAWA - Sistem Informasi Manajemen Kegiatan Mahasiswa</title>

  <!-- Custom fonts for this template-->
  <link href="{{ url('/assets/admin/') }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{ url('/assets/admin/') }}/css/sb-admin-2.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container mt-1 pt-1">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-5 col-lg-6 col-md-4">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row"> 
              <div class="col-lg-12">
                <div class="p-4">
                  <div class="text-center">
                    <img src="https://www.poliwangi.ac.id/vendors/uploads/2019/11/kop-300x286.png" class="img-fluid" width="200">

                    <h2 class="h5 text-gray-900 mb-1 pt-3" style="line-height: 30px; letter-spacing: 0.5px">
                      <b>Sistem Informasi Manajemen Kegiatan Mahasiswa</b>
                    </h1>

                    <p class="mb-3 text-gray-600">Silahkan login terlebih dahulu</p>
                  </div>

                  @if ($errors->any())
                      <div class="alert alert-danger">
                          <ul class="mb-0">
                              @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                      </div>
                  @endif

                  @if (!empty(Session::get('message')))
                  <div class="alert alert-{{ Session::get('status') }} alert-dismissible fade show" role="alert"> 
                      <span class="alert-inner--text">{{ Session::get('message') }}</span>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div> 
                  @endif

                  <form class="user" action="{{ url('/login') }}" method="POST">
                    {{ csrf_field() }}

                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="email" type="text" placeholder="Username" autocomplete="off" name="username" autofocus>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="password" type="password" placeholder="Password" name="password">
                    </div> 

                    <button class="btn btn-primary btn-user btn-block" type="submit">
                      <B>LOGIN</B>
                    </button>

                    <a href="{{ url('register') }}" class="btn btn btn-outline-primary btn-block mt-3">Daftar Sebagai Mahasiswa</a>
                  </form>
                  <hr>
                  <!-- <div class="text-center">
                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="register.html">Create an Account!</a>
                  </div> -->
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="{{ url('/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ url('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ url('/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ url('/js/sb-admin-2.min.js') }}"></script>

</body>

</html>

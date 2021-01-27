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
  <link href="{{ url('assets/admin/') }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{ url('assets/admin/') }}/css/sb-admin-2.min.css" rel="stylesheet">

  @yield('custom-css')

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    @include('_layout/admin/sidebar')
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::guard('admin')->user()->name }}</span>
                
                @if (Auth::guard('admin')->user()->hak_akses == 'ormawa')
                  @php
                    $penggunaID = Auth::guard('admin')->user()->id;

                    $data = collect(DB::select("SELECT 
                            o.*, p.username
                        FROM ormawa o
                        inner join pengguna p
                            on p.id = o.pengguna_id
                        where o.pengguna_id = $penggunaID
                    "))->first();
                  @endphp
                  <img class="img-profile rounded-circle" src="{{ url('uploads/logo/' . $data->foto ) }}">
                @else
                  <img class="img-profile rounded-circle" src="{{ url('assets/admin/img/user.png') }}">
                @endif
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                @php
                  $level = Request::segment(1);
                @endphp

                @if ($level == 'ormawa')
                  <a class="dropdown-item" href="{{ url('ormawa/pengguna/update/') }}">
                    Edit Profil
                  </a>
                  <a class="dropdown-item" href="{{ url('ormawa/pengguna/update_password/') }}">
                    Ubah Password
                  </a>
                @else
                  <a class="dropdown-item" href="{{ url('admin/pengguna/ubah_password/') }}/{{ Auth::guard('admin')->user()->id }}">
                    Edit Profil
                  </a>
                @endif

                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          @yield('content')

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Apakah anda yakin?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Anda akan keluar dari aplikasi</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
          <a class="btn btn-primary" href="{{ url('logout') }}">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="{{ url('assets/admin/') }}/vendor/jquery/jquery.min.js"></script>
  <script src="{{ url('assets/admin/') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ url('assets/admin/') }}/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ url('assets/admin/') }}/js/sb-admin-2.min.js"></script>


  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

  <?php 
  $status = !empty(Session::get('status')) ? Session::get('status') : ''; 
  $message = !empty(Session::get('message')) ? Session::get('message') : ''; 
  ?>
  @if (!empty($message))
    <script>
    Swal.fire({
      title: 'Notifikasi',
      text: '<?= $message ?>',
      type: '<?= $status ?>',
      confirmButtonText: 'Ok!'
    })
    </script>
  @endif

  @yield('custom-js')

</body>

</html>

<?php 
$page = Request::segment(2);

$role = Auth::guard('admin')->user()->hak_akses;
?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
      <!-- <div class="sidebar-brand-icon">
        <i class="fas fa-chalkboard-teacher"></i>
      </div> -->

      <div class="sidebar-brand-text mx-3">S I M K E M A W A</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ ($page == 'dashboard') ? 'active':'' }}">
    <a class="nav-link" href="{{ url($role . '/dashboard') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading 
    <div class="sidebar-heading">
      MENU UTAMA
    </div>-->

    @if ($role == 'admin')
      {{-- <li class="nav-item {{ ($page == 'proker') ? 'active':'' }}">
          <a class="nav-link" href="{{ url('admin/proker') }}">
          <i class="fas fa-fw fa-archive"></i>
          <span>Proker Ormawa</span></a>
      </li> --}}
      <li class="nav-item {{ ($page == 'kegiatan') ? 'active':'' }}">
          <a class="nav-link" href="{{ url('admin/kegiatan') }}">
          <i class="fas fa-fw fa-archive"></i>
          <span>Data Kegiatan</span></a>
      </li>
      {{-- <li class="nav-item {{ ($page == 'ormawa') ? 'active':'' }}">
          <a class="nav-link" href="{{ url('admin/ormawa') }}">
          <i class="fas fa-fw fa-archive"></i>
          <span>Data Ormawa</span></a>
      </li> --}}
      <li class="nav-item {{ ($page == 'ruangan') ? 'active':'' }}">
          <a class="nav-link" href="{{ url('admin/ruangan') }}">
          <i class="fas fa-fw fa-archive"></i>
          <span>Data Ruangan</span></a>
      </li>
      <li class="nav-item {{ ($page == 'laporan_kegiatan') ? 'active':'' }}">
          <a class="nav-link" href="{{ url('admin/laporan_kegiatan') }}">
          <i class="fas fa-fw fa-archive"></i>
          <span>Laporan Kegiatan</span></a>
      </li>
      {{-- <li class="nav-item {{ ($page == 'report') ? 'active':'' }}">
          <a class="nav-link" href="{{ url('admin/report') }}">
          <i class="fas fa-fw fa-archive"></i>
          <span>Laporan</span></a>
      </li> --}}
      {{-- <li class="nav-item {{ ($page == 'pengguna') ? 'active':'' }}">
          <a class="nav-link" href="{{ url('admin/pengguna') }}">
          <i class="fas fa-fw fa-archive"></i>
          <span>Kelola Data User</span></a>
      </li> --}}

      <li class="nav-item {{ ($page == 'pengguna' || $page == 'ormawa' || $page == 'mahasiswa') ? 'active':'' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-users"></i>
          <span>Kelola Data User</span>
        </a>
        <div id="collapseTwo" class="collapse {{ ($page == 'pengguna' || $page == 'ormawa' || $page == 'mahasiswa') ? 'show':'' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item {{ ($page == 'pengguna') ? 'active':'' }}" href="{{ url('admin/pengguna') }}">Data Pengguna</a>
            <a class="collapse-item {{ ($page == 'ormawa') ? 'active':'' }}" href="{{ url('admin/ormawa') }}">Data Ormawa</a>
            {{-- <a class="collapse-item {{ ($page == 'mahasiswa') ? 'active':'' }}" href="{{ url('admin/mahasiswa') }}">Data Mahasiswa</a> --}}
          </div>
        </div>
      </li>
    @elseif ($role == "wadir")
      <li class="nav-item {{ ($page == 'ormawa') ? 'active':'' }}">
          <a class="nav-link" href="{{ url('wadir/ormawa') }}">
          <i class="fas fa-fw fa-archive"></i>
          <span>Ormawa</span></a>
      </li>
      <li class="nav-item {{ ($page == 'kegiatan') ? 'active':'' }}">
          <a class="nav-link" href="{{ url('wadir/kegiatan') }}">
          <i class="fas fa-fw fa-archive"></i>
          <span>Laporan Kegiatan</span></a>
      </li>
    @elseif ($role == "ormawa")
      <li class="nav-item {{ ($page == 'kegiatan') ? 'active':'' }}">
          <a class="nav-link" href="{{ url('ormawa/kegiatan') }}">
          <i class="fas fa-fw fa-archive"></i>
          <span>Data Kegiatan</span></a>
      </li>
    @endif

    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

  </ul>
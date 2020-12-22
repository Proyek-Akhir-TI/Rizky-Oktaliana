@extends('_layout.admin.app')

@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-6">
        <h1 class="h3 mb-4 text-gray-800">Data {{ $title }}</h1>
    </div>
    <div class="col-lg-6 text-right">
        <a href="{{ url('admin/' . $prefix . '/tambah') }}" class="btn btn-primary"><i class="fas fa-plus pr-1"></i> Tambah Data</a>
    </div>
</div>

<div class="row">

  <div class="col-lg-12">

    <div class="card shadow mb-4">
      <div class="card-body">
          <table class="table table-borderless table-hover">
              <thead>
                  <th>NIM</th> 
                  <th>Nama</th> 
                  <th>Username</th> 
                  <th>Angkatan</th> 
                  <th>Prodi</th> 
                  <th>Foto</th> 
                  <th>Aksi</th>
              </thead>
              <tbody>
                  @if (!empty($data))
                    @foreach ($data as $value)
                        <tr>
                            <td>{{ $value->nim }}</td>
                            <td>{{ $value->nama }}</td>
                            <td>{{ $value->username }}</td>
                            <td>{{ $value->angkatan }}</td>
                            <td>{{ $value->prodi }}</td>
                            <td>
                                <img src="https://via.placeholder.com/100x100.png?text=Belum+tersedia" class="img-fluid">
                            </td>
                            <td>
                                <a href="{{ url('admin/' . $prefix . '/reset_password/' . $value->id) }}" class="btn btn-outline-warning btn-sm mr-1" onclick="return confirm('Apakah anda yakin reset password?');">Reset Password</a>
                                <a href="{{ url('admin/' . $prefix . '/hapus/' . $value->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin?');">Hapus</a>
                            </td>
                        </tr>
                    @endforeach
                  @else
                        <tr>
                            <td colspan="10">Belum ada data</td>
                        </tr>
                  @endif
              </tbody>
          </table>
      </div>
    </div>

  </div>

</div>
@endsection
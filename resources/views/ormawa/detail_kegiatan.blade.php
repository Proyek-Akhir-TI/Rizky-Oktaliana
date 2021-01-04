@extends('_layout.admin.app')

@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-6">
        <h1 class="h3 mb-4 text-gray-800">Detail Data {{ $title }}</h1>
    </div>
    {{-- <div class="col-lg-6 text-right">
      <a href="{{ url('admin/' . $prefix . '/reset_password/' . $data->id) }}" class="btn btn-outline-warning mr-1" onclick="return confirm('Apakah anda yakin?');">Reset Password</a>
      <a href="{{ url('admin/' . $prefix . '/edit/' . $data->id) }}" class="btn btn-warning">Edit Data</a>
    </div> --}}
</div>

<div class="row">

  <div class="col-lg-5">

    <div class="card shadow mb-4">
      <div class="card-body">

        <table>
          <tr>
            <table class="table">
              <tr>
                <td width="30%">Nama</td>
                <td>{{ $data->nama }}</td>
              </tr>
              <tr>
                <td>Himpunan</td>
                <td>{{ $data->nama_ormawa }}</td>
              </tr>
              <tr>
                <td>Ruangan</td>
                <td>{{ $data->nama_ruangan }}</td>
              </tr>
              <tr>
                <td>Waktu</td>
                <td>{{ $data->tanggal }} | {{ date('H:i', strtotime($data->waktu_mulai)) }} - {{ date('H:i', strtotime($data->waktu_akhir)) }}</td>
              </tr>
              <tr>
                <td>Jumlah Peserta Pendaftar</td>
                <td>{{ ($data->jml_peserta) }}</td>
              </tr>
              <tr>
                <td>Jumlah Kehadiran</td>
                <td>{{ ($data->jml_kehadiran) }}</td>
              </tr>
              <tr>
                <td>Kuota</td>
                <td>{{ $data->kuota }}</td>
              </tr>
              <tr>
                <td>Poster</td>
                <td><img src="{{ url('uploads/' . $data->poster) }}" class="img-fluid"></td>
              </tr>
            </table>
          </tr>
        </table>
      </div>
    </div>

  </div>

</div>
@endsection
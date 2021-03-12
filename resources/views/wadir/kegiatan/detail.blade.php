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
                <td>Total Biaya Kegiatan</td>
                <td>{{ rupiah($data->total_biaya_kegiatan) }}</td>
              </tr>
              <tr>
                <td>Biaya Keikutsertaan</td>
                <td>{{ empty($data->biaya_keikutsertaan) ? 'Free' : rupiah($data->biaya_keikutsertaan) }}</td>
              </tr>
              <tr>
                <td>Jumlah Peserta Pendaftar</td>
                <td>{{ ($jml_peserta) }}</td>
              </tr>
              <tr>
                <td>Jumlah Kuota Peserta</td>
                <td>{{ ($data->kuota) }}</td>
              </tr>
              {{-- <tr>
                <td>Kuota</td>
                <td>{{ $data->kuota }}</td>
              </tr> --}}
            </table>
          </tr>
        </table>
      </div>
    </div>

  </div>
  
  <div class="col-md-7">

    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <h5 style="letter-spacing: 1px">Peserta</h5>
          </div>
          <div class="col-md-6 text-right ">
            <a href="{{ url('wadir/kegiatan/cetak_peserta/' . $data->id_kegiatan) }}" class="btn btn-primary">Cetak</a>
          </div>
        </div>

        <table class="table table-striped table-borderless">
          <thead>
            <th>Nama</th>
            <th>NIM</th>
            <th>Email</th>
            <th>Jurusan</th>
          </thead>
          <tbody>
            @if (!empty($peserta))
              @foreach ($peserta as $value)
                  <tr>
                      <td>{{ $value->name }}</td> 
                      <td>{{ $value->NIM }}</td>
                      <td>{{ $value->Email }}</td>
                      <td>{{ $value->jurusan }}</td>
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
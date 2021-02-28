@extends('_layout.admin.app')

@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-6">
        <h1 class="h3 mb-4 text-gray-800">Detail Data {{ $title }}</h1>
    </div>
    <div class="col-lg-6 text-right">
      <a href="{{ url('admin/' . $prefix . '/reset_password/' . $data->id_ormawa) }}" class="btn btn-outline-warning mr-1" onclick="return confirm('Apakah anda yakin?');">Reset Password</a>
      <a href="{{ url('admin/' . $prefix . '/edit/' . $data->id_ormawa) }}" class="btn btn-warning">Edit Data</a>
    </div>
</div>

<div class="row">
  <div class="col-lg-12">

    <div class="card shadow mb-4">
      <div class="card-body">

        <div class="row">
          <div class="col-md-6">
            <table>
              <tr>
                <table class="table">
                  <tr>
                    <td>Nama</td>
                    <td><b>{{ $data->nama }}</b></td>
                  </tr>
                  <tr>
                    <td>Username</td>
                    <td><b>{{ $pengguna->username }}</b></td>
                  </tr>
                </table>
              </tr>
            </table>
          </div>
          <div class="col-md-6">
            <table>
              <tr>
                <table class="table">
                  <tr>
                    <td>Nama Ketua</td>
                    <td><b>{{ $data->nama_ketua }}</b></td>
                  </tr>
                  <tr>
                    <td>No. HP.</td>
                    <td><b>{{ $data->no_hp }}</b></td>
                  </tr>
                </table>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card shadow mb-4">
      <div class="card-body">
        <h5 style="letter-spacing: 1px">Riwayat Ketua</h5>

        <div class="row mt-3">
          <div class="col-md-12">
              <form class="form-inline" method="GET" action="{{ url('admin/ormawa/detail/' . $data->id_ormawa) }}">
                  <input type="hidden" name="ormawa_id" value="{{ $data->id_ormawa }}">

                  <div class="input-group mb-2 mr-sm-2">
                      <select name="tahun" id="tahun" class="form-control">
                          <option value="">- Semua Tahun -</option>
                          <option {{ ($tahun == "2021") ? 'selected' : '' }} value="2021">2021</option>
                          <option {{ ($tahun == "2020") ? 'selected' : '' }} value="2020">2020</option>
                          <option {{ ($tahun == "2019") ? 'selected' : '' }} value="2019">2019</option>
                      </select>
                  </div>

                  <button type="submit" class="btn btn-primary mb-2">Cari</button>
              </form>
          </div>
      </div>

        <table class="table table-striped table-borderless">
          <thead>
            <th>Nama Ketua</th>
            <th>Tahun Jabatan</th>
          </thead>
          <tbody>
            @forelse ($ketuas as $value)
              <tr>
                  <td>{{ $value->nama_ketua }}</td> 
                  <td>{{ $value->periode }}</td>
              </tr>
            @empty
              <tr>
                  <td colspan="10">Belum ada data</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card shadow mb-4">
      <div class="card-body">
        <h5 style="letter-spacing: 1px">Kegiatan</h5>

        <table class="table table-striped table-borderless">
          <thead>
            <th>Nama</th>
            <th>Ruangan</th>
            <th>Waktu</th>
            <th>Status</th>
            <th>Aksi</th>
          </thead>
          <tbody>
            @if (!empty($kegiatan))
              @foreach ($kegiatan as $value)
                  <tr>
                      <td>{{ $value->nama }}</td> 
                      <td>{{ $value->nama_ruangan }}</td>
                      <td>{{ $value->tanggal }} | {{ date('H:i', strtotime($value->waktu_mulai)) }} - {{ date('H:i', strtotime($value->waktu_akhir)) }}</td>
                      <td>{{ ($value->status == 1) ? 'Belum Terlaksana' : 'Sudah Terlaksana' }}</td>
                      <td>
                          <a href="{{ url('admin/kegiatan/detail/' . $value->id_kegiatan) }}" class="btn btn-outline-primary btn-sm mr-1">Detail</a>
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
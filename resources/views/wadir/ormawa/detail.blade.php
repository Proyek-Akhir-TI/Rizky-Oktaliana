@extends('_layout.admin.app')

@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-6">
        <h1 class="h3 mb-4 text-gray-800">Detail Data {{ $title }}</h1>
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
              <form class="form-inline" method="GET" action="{{ url('wadir/ormawa/detail/' . $data->id_ormawa) }}">
                  <input type="hidden" name="ormawa_id" value="{{ $data->id_ormawa }}">

                  <div class="input-group mb-2 mr-sm-2">
                      <select name="tahun_ketua" id="tahun_ketua" class="form-control">
                          <option value="">- Semua Tahun -</option>
                          <option {{ ($tahun_ketua == "2021") ? 'selected' : '' }} value="2021">2021</option>
                          <option {{ ($tahun_ketua == "2020") ? 'selected' : '' }} value="2020">2020</option>
                          <option {{ ($tahun_ketua == "2019") ? 'selected' : '' }} value="2019">2019</option>
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
        <div class="row">
          <div class="col-md-6">
            <h5 style="letter-spacing: 1px">Kegiatan</h5>
          </div>
          <div class="col-md-6">
            <form class="form-inline ml-auto"style="display: flex; justify-content: flex-end" method="GET" action="{{ url('wadir/ormawa/detail/' . $data->id_ormawa) }}">
              <div class="form-group mx-sm-3 mb-2">
                <select name="tahun" id="tahun" class="form-control">
                  <option {{ ($tahun == "") ? 'selected' : '' }} value="">Semua Tahun</option>
                  <option {{ ($tahun == "2019") ? 'selected' : '' }} value="2019">2019</option>
                  <option {{ ($tahun == "2020") ? 'selected' : '' }} value="2020">2020</option>
                  <option {{ ($tahun == "2021") ? 'selected' : '' }} value="2021">2021</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary mb-2">Lihat</button>
            </form>
            
          </div>
        </div>

        <table class="table table-striped table-borderless">
          <thead>
            <th>Nama</th>
            <th>Ruangan</th>
            <th>Waktu</th>
            <th>Status</th>
            <th>Total Biaya Kegiatan</th>
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
                      <td>{{ rupiah($value->total_biaya_kegiatan) }}</td>
                      <td>
                          <a href="{{ url('wadir/kegiatan/detail/' . $value->id_kegiatan) }}" class="btn btn-outline-primary btn-sm mr-1">Detail</a>
                      </td>
                  </tr>
              @endforeach
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><strong>{{ rupiah($total_biaya_kegiatan) }}</strong></td>
                <td></td>
              </tr>
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
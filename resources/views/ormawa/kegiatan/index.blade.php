@extends('_layout.admin.app')

@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-6">
        <h1 class="h3 mb-4 text-gray-800">Data {{ $title }}</h1>
    </div>
    {{-- <div class="col-lg-6 text-right">
        <a href="{{ url('ormawa/' . $prefix . '/tambah') }}" class="btn btn-primary"><i class="fas fa-plus pr-1"></i> Tambah Data</a>
    </div> --}} 
</div>

<div class="row mb-3">
    <div class="col-md-8">
        <form class="form-inline" method="GET" action="{{ url('ormawa/kegiatan/search') }}">
            <div class="input-group mb-2 mr-sm-2">
                <select name="bulan" id="bulan" class="form-control">
                    <option value="">- Semua Bulan -</option>
                    <option {{ ($bulan == '01') ? 'selected' : '' }} value="01">Januari</option>
                    <option {{ ($bulan == '02') ? 'selected' : '' }} value="02">Februari</option>
                    <option {{ ($bulan == '03') ? 'selected' : '' }} value="03">Maret</option>
                    <option {{ ($bulan == '04') ? 'selected' : '' }} value="04">April</option>
                    <option {{ ($bulan == '05') ? 'selected' : '' }} value="05">Mei</option>
                    <option {{ ($bulan == '06') ? 'selected' : '' }} value="06">Juni</option>
                    <option {{ ($bulan == '07') ? 'selected' : '' }} value="07">Juli</option>
                    <option {{ ($bulan == '08') ? 'selected' : '' }} value="08">Agustus</option>
                    <option {{ ($bulan == '09') ? 'selected' : '' }} value="09">September</option>
                    <option {{ ($bulan == '10') ? 'selected' : '' }} value="10">Oktober</option>
                    <option {{ ($bulan == '11') ? 'selected' : '' }} value="11">November</option>
                    <option {{ ($bulan == '12') ? 'selected' : '' }} value="12">Desember</option>
                </select>
            </div>
            <div class="input-group mb-2 mr-sm-2">
                <select name="tahun" id="tahun" class="form-control">
                    <option value="">- Semua Tahun -</option>
                    <option {{ ($tahun == "2021") ? 'selected' : '' }} value="2021">2021</option>
                    <option {{ ($tahun == "2020") ? 'selected' : '' }} value="2020">2020</option>
                    <option {{ ($tahun == "2019") ? 'selected' : '' }} value="2019">2019</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-outline-primary mb-2">Cari</button>
        </form>
    </div>

    <div class="col-md-4 text-right">
        <a href="{{ url('ormawa/kegiatan/tambah') }}" class="btn btn-primary">Tambah Kegiatan</a>
    </div>
</div>

<div class="row">

  <div class="col-lg-12">

    <div class="card shadow mb-4">
      <div class="card-body">
          <table class="table table-borderless table-hover">
              <thead>
                  <th>Nama</th>
                  <th>Ruangan</th>
                  <th>Waktu</th>
                  <th>Status Kegiatan</th>
                  <th>Aksi</th>
              </thead>
              <tbody>
                  @if (!empty($data))
                    @foreach ($data as $value)
                        <tr>
                            <td>{{ $value->nama }}</td>
                            <td>{{ $value->nama_ruangan }}</td>
                            <td>{{ $value->tanggal }} | {{ date('H:i', strtotime($value->waktu_mulai)) }} - {{ date('H:i', strtotime($value->waktu_akhir)) }}</td> 
                            <td>{{ ($value->status == 1) ? 'Belum Terlaksana' : 'Sudah Terlaksana' }}</td>
                            <td>
                                <a href="{{ url('ormawa/' . $prefix . '/detail/' . $value->id_kegiatan) }}" class="btn btn-primary btn-sm mr-1">Detail</a>
                                <a href="{{ url('ormawa/' . $prefix . '/edit/' . $value->id_kegiatan) }}" class="btn btn-warning btn-sm mr-1">Edit</a>
                                <a href="{{ url('ormawa/' . $prefix . '/hapus/' . $value->id_kegiatan) }}" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin?');">Hapus</a>
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
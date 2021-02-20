@extends('_layout.admin.app')

@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-6">
        <h1 class="h3 mb-4 text-gray-800">Data {{ $title }}</h1>
    </div>
    {{-- <div class="col-lg-6 text-right">
        <a href="{{ url('wadir/' . $prefix . '/tambah') }}" class="btn btn-primary"><i class="fas fa-plus pr-1"></i> Tambah Data</a>
    </div> --}}
</div>

<div class="row mb-3">
    <div class="col-md-7">
        <form class="form-inline" method="GET" action="{{ url('wadir/laporan_ruangan/search') }}">
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

    <div class="col-md-5 text-right">
        <a href="{{ url("wadir/laporan_ruangan/cetak?tahun=$tahun") }}" target="_blank" class="btn btn-warning">Cetak</a>
    </div>
</div>

<div class="row">

  <div class="col-lg-12">

    <div class="card shadow mb-4">
      <div class="card-body">
          <table class="table table-borderless table-hover">
              <thead>
                  <th>Nama Ruangan</th> 
                  <th>Jumlah Kegiatan</th>
              </thead>
              <tbody>
                  @if (!empty($data))
                    @foreach ($data as $value)
                        <tr>
                            <td>{{ $value->nama_ruangan }}</td>
                            <td>{{ $value->jml_kegiatan }}</td>
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
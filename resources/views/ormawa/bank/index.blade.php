@extends('_layout.admin.app')

@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-6">
        <h1 class="h3 mb-4 text-gray-800">Data {{ $title }}</h1>
    </div>
    <div class="col-lg-6 text-right">
        <a href="{{ url('ormawa/' . $prefix . '/tambah') }}" class="btn btn-primary"><i class="fas fa-plus pr-1"></i> Tambah Data</a>
    </div>
</div>

<div class="row">

  <div class="col-lg-12">

    <div class="card shadow mb-4">
      <div class="card-body">
          <table class="table table-borderless table-hover">
              <thead>
                  <th>Nama Bank</th> 
                  <th>Atas Nama</th> 
                  <th>No. Rekening</th> 
                  <th>Aksi</th>
              </thead>
              <tbody>
                  @if (!empty($data))
                    @foreach ($data as $value)
                        <tr>
                            <td>{{ $value->nama_bank }}</td>
                            <td>{{ $value->pemilik_rekening }}</td>
                            <td>{{ $value->nomor_rekening }}</td>
                            <td>
                                <a href="{{ url('ormawa/' . $prefix . '/edit/' . $value->id_bankuser) }}" class="btn btn-outline-warning btn-sm mr-1">Edit</a>
                                <a href="{{ url('ormawa/' . $prefix . '/hapus/' . $value->id_bankuser) }}" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin?');">Hapus</a>
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
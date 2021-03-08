@extends('_layout.admin.app')

@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-6">
        <h1 class="h3 mb-4 text-gray-800">Data {{ $title }}</h1>
    </div>
</div>

<div class="row">

  <div class="col-lg-12">

    <div class="card shadow mb-4">
      <div class="card-body">
          <table class="table table-borderless table-hover">
              <thead>
                  <th>Nama Peserta</th> 
                  <th>Nama Kegiatan</th> 
                  <th>Tanggal Pemesanan</th>
                  <th>Batas Transaksi</th>
                  <th>Bukti Pembayaran</th>
                  <th>Status</th>
                  <th>Aksi</th>
              </thead>
              <tbody>
                  @if (!empty($data))
                    @foreach ($data as $value)
                        <tr>
                            <td>{{ $value->nama_peserta }}</td>
                            <td>{{ $value->nama_kegiatan }}</td>
                            <td>{{ $value->tgl_pesan }}</td>
                            <td>{{ $value->batas_transaksi }}</td>
                            <td>
                                <img src="{{ ("http://api.simkemawa.cobadulu.online/gambar/" . $value->bukti_pembayaran) }}" width="70">
                            </td>
                            <td>
                                <span class="badge badge-{{ get_status($value->id_status)['color'] }}">{{ get_status($value->id_status)['name'] }}</span>
                            </td>
                            <td>
                                <a href="{{ url('ormawa/' . $prefix . '/detail/' . $value->transaksi_id) }}" class="btn btn-outline-primary btn-sm mr-1">Lihat</a>
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
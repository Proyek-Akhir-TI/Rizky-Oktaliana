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
                <td width="30%">Nama Peserta</td>
                <td>{{ $data->nama_peserta }}</td>
              </tr>
              <tr>
                <td width="30%">Nama Kegiatan</td>
                <td>{{ $data->nama_kegiatan }}</td>
              </tr>
              <tr>
                <td width="30%">Tanggal Pesan</td>
                <td>{{ $data->tgl_pesan }}</td>
              </tr>
              <tr>
                <td width="30%">Batas Transaksi</td>
                <td>{{ $data->nama_peserta }}</td>
              </tr>
              <tr>
                <td width="30%">Status</td>
                <td>
                  <span class="badge badge-{{ get_status($data->id_status)['color'] }}">{{ get_status($data->id_status)['name'] }}</span>
                </td>
              </tr>
            </table>

            @if ($data->id_status == '2')
              <a href="{{ url('ormawa/pemesanan/confirm/' . $data->transaksi_id) }}" class="btn btn-primary">Konfirmasi</a>
            @elseif ($data->id_status == '3')
              <a href="{{ url('ormawa/pemesanan/unconfirm/' . $data->transaksi_id) }}" class="btn btn-warning">Batal Konfirmasi</a>
            @endif
          </tr>
        </table>
      </div>
    </div>

  </div>
  
  <div class="col-md-7">

    <div class="card shadow mb-4">
      <div class="card-body">
        <h5 style="letter-spacing: 1px">Bukti Pembayaran</h5>

        <img src="{{ ("http://api.simkemawa.cobadulu.online/gambar/" . $data->bukti_pembayaran) }}" class="img-fluid">
      </div>
    </div>
  </div>

</div>
@endsection

@extends('_layout/front')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Judul Kegiatan</h1>
                <p>Nama Ormawa</p>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label>Ruangan</label>
                    <p><b>{{ $data->nama_ruangan }}</b></p>
                </div>
                <div class="form-group">
                    <label>Waktu</label>
                    <p><b>{{ $data->tanggal }} | {{ date('H:i', strtotime($data->waktu_mulai)) }} - {{ date('H:i', strtotime($data->waktu_akhir)) }}</b></p>
                </div>
                {{-- <div class="form-group">
                    <label>Sisa Kuota</label>
                    <p><b>Lab</b></p>
                </div> --}}
                <div class="form-group">
                    <label>Biaya</label>
                    <p><b>{{ empty($data->biaya_keikutsertaan) ? "Gratis" : $data->biaya_keikutsertaan }}</b></p>
                </div>
                <div class="form-group">
                    <label>Aksi</label>
                    <p>
                        <a href="{{ url('register') }}" class="btn btn-primary">Daftar Kegiatan</a>               
                    </p>
                </div>
            </div>
            <div class="col-md-7">
                <img src="{{ empty($data->poster) ? 'https://via.placeholder.com/300x300.png?text=Belum+tersedia' : url('uploads/' . $data->poster) }}" class="img-fluid">
            </div>
        </div>
    </div>
</section>


@endsection
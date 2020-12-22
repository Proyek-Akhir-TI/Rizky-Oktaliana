@extends('_layout/front')

@section('content')
<section>
    <div class="container my-5">
        <div class="jumbotron" style="border-radius: 20px">
            <p>Selamat Datang di</p>
            <h1 class="display-4">Sistem Informasi Kegiatan Mahasiswa</h1>
            <p class="lead">Politeknik Negeri Banyuwangi</p>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <h3>Daftar Kegiatan</h3>
        <p class="mb-4">Daftar kegiatan yang akan terselenggara</p>

        <div class="row">
            @forelse ($kegiatan as $value)
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="{{ empty($value->poster) ? 'https://via.placeholder.com/300x300.png?text=Belum+tersedia' : url('uploads/' . $value->poster) }}" class="img-fluid">
                                </div>
                                <div class="col-md-9">
                                    <h4 class="mb-0">{{ $value->nama }}</h4>
                                    <span>{{ $value->nama_ormawa }}</span>
                                    <p class="mt-2">{{ $value->tanggal }} | {{ date('H:i', strtotime($value->waktu_mulai)) }} - {{ date('H:i', strtotime($value->waktu_akhir)) }}</p>
                                    <a href="{{ url('kegiatan/detail/' . $value->id) }}">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12 text-center">
                    <p>Belum ada kegiatan</p>
                </div>
            @endforelse

        </div>
    </div>
</section>
@endsection
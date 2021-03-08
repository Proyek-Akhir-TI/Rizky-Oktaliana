@extends('_layout.admin.app')

@section('custom-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-6">
        <h1 class="h3 mb-4 text-gray-800">Tambah Data {{ $title }}</h1>
    </div>
</div>

<div class="row">

  <div class="col-lg-5">

    <div class="card shadow mb-4">
      <div class="card-body">

        <form action="{{ url($form_action_url) }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}

            <input type="hidden" name="id_pengguna" value="{{ $ormawa_id }}">
            
            <div class="form-group">
                <label for="nama">Nama Kegiatan</label>
                <input type="text" class="form-control" id="nama" name="nama"> 
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="poster">Poster</label>
                <input type="file" class="form-control" id="poster" name="poster"> 
            </div>
            <div class="form-group">
                <label for="id_ruangan">Ruangan</label>
                <select name="id_ruangan" id="id_ruangan" class="form-control">
                  <option value="">- Pilih Ruangan -</option>

                  @foreach ($ruangan as $value)
                      <option value="{{ $value->id_ruangan }}">{{ $value->nama }}</option>
                  @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input type="text" class="form-control" id="tanggal" name="tanggal"> 
            </div>
            <div class="form-group">
                <label for="waktu_mulai">Waktu Mulai</label>
                <input type="text" class="form-control" id="waktu_mulai" name="waktu_mulai"> 
            </div>
            <div class="form-group">
                <label for="waktu_akhir">Waktu Akhir</label>
                <input type="text" class="form-control" id="waktu_akhir" name="waktu_akhir"> 
            </div>
            <div class="form-group">
                <label for="kuota">Kuota Peserta</label>
                <input type="number" class="form-control" id="kuota" name="kuota"> 
            </div>
            <div class="form-group">
                <label for="total_biaya_kegiatan">Total Biaya Kegiatan</label>
                <input type="text" class="form-control" id="total_biaya_kegiatan" name="total_biaya_kegiatan"> 
            </div>
            <div class="form-group">
                <label for="biaya_keikutsertaan">Biaya Keikutsertaan</label>
                <input type="text" class="form-control" id="biaya_keikutsertaan" name="biaya_keikutsertaan"> 
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan Data</button>
        </form>
      </div>
    </div>

  </div>

</div>
@endsection

@section('custom-js')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.0.2/cleave.min.js" integrity="sha512-SvgzybymTn9KvnNGu0HxXiGoNeOi0TTK7viiG0EGn2Qbeu/NFi3JdWrJs2JHiGA1Lph+dxiDv5F9gDlcgBzjfA==" crossorigin="anonymous"></script>
<script>
$("#tanggal").flatpickr({
    altInput: true,
    altFormat: "j F Y",
    dateFormat: "Y-m-d",
});
$("#waktu_mulai").flatpickr({
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
});
$("#waktu_akhir").flatpickr({
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
});

var cleave = new Cleave('#total_biaya_kegiatan', {
    numeral: true,
    numeralThousandsGroupStyle: 'thousand'
});
var cleave2 = new Cleave('#biaya_keikutsertaan', {
    numeral: true,
    numeralThousandsGroupStyle: 'thousand'
});
</script>
@endsection
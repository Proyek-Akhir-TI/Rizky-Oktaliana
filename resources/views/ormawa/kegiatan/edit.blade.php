@extends('_layout.admin.app')

@section('custom-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-6">
        <h1 class="h3 mb-4 text-gray-800">Edit Data {{ $title }}</h1>
    </div>
</div>

<div class="row">

  <div class="col-lg-5">

    <div class="card shadow mb-4">
      <div class="card-body">

        <form action="{{ url($form_action_url) }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}

            <input type="hidden" name="ormawa_id" value="{{ $ormawa_id }}">
            
            <div class="form-group">
                <label for="nama">Nama Kegiatan</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ $data->nama }}"> 
            </div>
            <div class="form-group">
                <label for="poster">Poster</label>
                <input type="file" class="form-control" id="poster" name="poster">
                <img src="{{ url('uploads/' . $data->poster) }}" class="img-fluid">
            </div>
            <div class="form-group">
                <label for="ruangan_id">Ruangan</label>
                <select name="ruangan_id" id="ruangan_id" class="form-control">
                  <option value="">- Pilih Ruangan -</option>

                  @foreach ($ruangan as $value)
                      <option {{ ($data->ruangan_id == $value->id) ? 'selected' : '' }} value="{{ $value->id }}">{{ $value->nama }}</option>
                  @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input type="text" class="form-control" id="tanggal" name="tanggal" value="{{ $data->tanggal }}"> 
            </div>
            <div class="form-group">
                <label for="waktu_mulai">Waktu Mulai</label>
                <input type="text" class="form-control" id="waktu_mulai" name="waktu_mulai" value="{{ $data->waktu_mulai }}"> 
            </div>
            <div class="form-group">
                <label for="waktu_akhir">Waktu Mulai</label>
                <input type="text" class="form-control" id="waktu_akhir" name="waktu_akhir" value="{{ $data->waktu_akhir }}"> 
            </div>
            <div class="form-group">
                <label for="kuota">Kuota Peserta</label>
                <input type="number" class="form-control" id="kuota" name="kuota" value="{{ $data->kuota }}"> 
            </div>
            <div class="form-group">
                <label for="total_biaya_kegiatan">Total Biaya Kegiatan</label>
                <input type="number" class="form-control" id="total_biaya_kegiatan" name="total_biaya_kegiatan" value="{{ $data->total_biaya_kegiatan }}"> 
            </div>
            <div class="form-group">
                <label for="biaya_keikutsertaan">Biaya Keikutsertaan</label>
                <input type="number" class="form-control" id="biaya_keikutsertaan" name="biaya_keikutsertaan" value="{{ $data->biaya_keikutsertaan }}"> 
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
</script>
@endsection
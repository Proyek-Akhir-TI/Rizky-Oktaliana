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

        <form action="{{ url($form_action_url) }}" method="POST">
            {{ csrf_field() }}
            
            <div class="form-group">
                <label for="nama">Nama Proker</label>
                <input type="text" class="form-control" id="nama" name="nama"> 
            </div>
            <div class="form-group">
                <label for="ormawa_id">Ormawa</label>
                <select name="ormawa_id" id="ormawa_id" class="form-control">
                  <option value="">- Pilih Ormawa -</option>

                  @foreach ($ormawa as $value)
                      <option value="{{ $value->id }}">{{ $value->nama }}</option>
                  @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="ruangan_id">Ruangan</label>
                <select name="ruangan_id" id="ruangan_id" class="form-control">
                  <option value="">- Pilih Ruangan -</option>

                  @foreach ($ruangan as $value)
                      <option value="{{ $value->id }}">{{ $value->nama }}</option>
                  @endforeach
                </select>
            </div>
            {{-- <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                  <option value="">- Pilih Status -</option>
                  
                  <option value="1">Belum Dilaksanakan</option>
                  <option value="2">Sudah Dilaksanakan</option>
                  <option value="3">Tidak Dilaksanakan</option>
                </select>
            </div> --}}
            <div class="form-group">
                <label for="tanggal_mulai">Tanggal Mulai</label>
                <input type="text" class="form-control" id="tanggal_mulai" name="tanggal_mulai"> 
            </div>
            <div class="form-group">
                <label for="tanggal_akhir">Tanggal Akhir</label>
                <input type="text" class="form-control" id="tanggal_akhir" name="tanggal_akhir"> 
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
$("#tanggal_mulai").flatpickr({
    altInput: true,
    altFormat: "j F Y",
    dateFormat: "Y-m-d",
});
$("#tanggal_akhir").flatpickr({
    altInput: true,
    altFormat: "j F Y",
    dateFormat: "Y-m-d",
});
</script>
@endsection
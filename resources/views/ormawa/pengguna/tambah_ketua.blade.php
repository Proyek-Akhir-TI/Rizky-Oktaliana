@extends('_layout.admin.app')

@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-6">
        <h1 class="h3 mb-4 text-gray-800">Tambah {{ $title }}</h1>
    </div>
</div>

<div class="row">

    <div class="col-lg-5">
  
      <div class="card shadow mb-4">
        <div class="card-body">
  
          @if ($errors->any())
              <div class="alert alert-danger">
                  <ul class="mb-0">
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif
  
          <form action="{{ url($form_action_url) }}" method="POST" enctype="multipart/form-data">
              {{ csrf_field() }}
              
              <div class="form-group">
                  <label for="nama_ketua">Nama Ketua</label>
                  <input type="text" class="form-control" id="nama_ketua" name="nama_ketua">
              </div>
              <div class="form-group">
                  <label for="periode">Periode</label>
                  <input type="text" class="form-control" id="periode" name="periode">
              </div>
              <div class="form-group">
                  <label>Status</label>
                  <select name="status" class="form-control" required>
                      <option value="">Pilih Status</option>
                      <option value="1">Aktif</option>
                      <option value="2">Tidak Aktif</option>
                  </select>
              </div>
              
              <button type="submit" class="btn btn-primary">Simpan</button>
          </form>
        </div>
      </div>
    </div>

</div>
@endsection
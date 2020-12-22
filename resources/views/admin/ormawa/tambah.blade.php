@extends('_layout.admin.app')

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
                <label for="nama">Nama Ormawa</label>
                <input type="text" class="form-control" id="nama" name="nama"> 
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username"> 
                <small>* Password secara default menggunakan username ini</small>
            </div>
            <div class="form-group">
                <label for="no_hp">No. HP</label>
                <input type="text" class="form-control" id="no_hp" name="no_hp"> 
            </div>
            <div class="form-group">
                <label for="nama_ketua">Nama Ketua</label>
                <input type="text" class="form-control" id="nama_ketua" name="nama_ketua"> 
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan Data</button>
        </form>
      </div>
    </div>

  </div>

</div>
@endsection
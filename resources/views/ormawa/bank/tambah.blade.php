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
                <label for="id_bank">Nama Bank</label>
                <select name="id_bank" id="id_bank" class="form-control">
                  <option value="">- Pilih Bank -</option>

                  @foreach ($banks as $v)
                      <option value="{{ $v->id_bank }}">{{ $v->nama_bank }}</option>
                  @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="pemilik_rekening">Atas Nama</label>
                <input type="text" class="form-control" id="pemilik_rekening" name="pemilik_rekening"> 
            </div>
            
            <div class="form-group">
                <label for="nomor_rekening">No. Rekening</label>
                <input type="text" class="form-control" id="nomor_rekening" name="nomor_rekening"> 
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan Data</button>
        </form>
      </div>
    </div>

  </div>

</div>
@endsection
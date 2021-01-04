@extends('_layout.admin.app')

@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-6">
        <h1 class="h3 mb-4 text-gray-800">Edit Profil</h1>
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
                <input type="text" class="form-control" id="nama_ketua" name="nama_ketua" value="{{ $data->nama_ketua }}">
            </div>
            <div class="form-group">
                <label for="username">No. Hp.</label>
                <input type="text" class="form-control" id="username" name="username" value="{{ $data->username }}">
            </div>
            <div class="form-group">
                <label for="foto">Logo Himpunan</label>
                <input type="file" class="form-control" id="foto" name="foto" value="{{ $data->foto }}">

                @if (empty($data->foto))
                    <p>Belum ada foto</p>
                @else
                    <img src="{{ url('uploads/logo/' . $data->foto ) }}" class="img-fluid mt-3">
                @endif
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="{{ $data->username }}">
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
      </div>
    </div>

  </div>

</div>
@endsection
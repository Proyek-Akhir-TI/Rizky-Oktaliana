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

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url($form_action_url) }}" method="POST">
            {{ csrf_field() }}
            
            <div class="form-group">
                <label for="name">Nama Pengguna</label>
                <input type="text" class="form-control" id="name" name="name" autocomplete="off" value="{{ old('name') }}"> 
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}"> 
            </div>
            <div class="form-group">
                <label for="hak_akses">Hak Akses</label>
                <select name="hak_akses" id="hak_akses" class="form-control" required>
                  <option value="">- Pilih Hak Akses -</option>
                  <option {{ (old('hak_akses') == 'admin') ? 'selected' : '' }} value="admin">Admin</option>
                  <option {{ (old('hak_akses') == 'wadir') ? 'selected' : '' }} value="wadir">Wadir</option>
                </select>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password"> 
            </div>
            <div class="form-group">
                <label for="re_password">Ulangi Password</label>
                <input type="password" class="form-control" id="re_password" name="re_password"> 
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan Data</button>
        </form>
      </div>
    </div>

  </div>

</div>
@endsection
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
                  <label for="no_hp">No. Hp.</label>
                  <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ $data->no_hp }}">
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

    <div class="col-lg-7">
  
        <div class="card shadow mb-4">
            <div class="card-body">
                <a href="{{ url('ormawa/ketua/tambah') }}" class="btn btn-sm btn-primary mb-3">Tambah</a>

                <table class="table">
                    <thead>
                        <th>Nama Ketua</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @foreach ($ormawa_ketua as $value)
                            <tr>
                                <td>{{ $value->nama_ketua }}</td>
                                <td>{{ $value->periode }}</td>
                                <td>{{ ($value->status == 1) ? 'Aktif' : 'Tidak Aktif' }}</td>
                                <td>
                                    <a href="{{ url('ormawa/ketua/edit/' . $value->id_ormawa_ketua) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="{{ url('ormawa/ketua/hapus/' . $value->id_ormawa_ketua) }}" class="btn btn-sm btn-danger">Hapus</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
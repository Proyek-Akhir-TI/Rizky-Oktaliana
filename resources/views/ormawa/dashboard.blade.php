@extends('_layout.admin.app')

@section('custom-css')

<link rel="stylesheet" href="{{ url('assets/admin/vendor/fullcalendar/fullcalendar.min.css') }}" />

<style>

#calendar {
    width: auto;
    margin: 0 auto;
}

.response {
    height: 60px;
}

.success {
    background: #cdf3cd;
    padding: 10px 60px;
    border: #c3e6c3 1px solid;
    display: inline-block;
}
</style>
@endsection

@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-6">
        <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>
    </div> 
</div>

<div class="row">
    
    <div class="col-md-6">
        <div class="alert alert-primary">
            <p>Selamat Datang! Kamu login sebagai Ormawa!</p>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
@endsection
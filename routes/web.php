<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

// Route::get('admin/dashboard', 'DashboardController@index');
Route::get('home', 'HomeController@index');


// halaman yang diakses tanpa login
Route::get('/login', 'LoginController@getLogin')->middleware('guest');
Route::get('/register', 'LoginController@register')->middleware('guest');
Route::post('/login', 'LoginController@postLogin');
Route::post('/register', 'LoginController@doRegister');
Route::get('/logout', 'LoginController@logout');

Route::get('/kegiatan/detail/{id}', 'KegiatanController@detail');

// Route::get('/dashboard', 'admin/DashboardController@index')->middleware('auth:admin');

Route::group([
    'name'       => 'admin.',
    'prefix'     => 'admin',
    'middleware' => ['auth:admin', 'check_user:admin'],
    'namespace'  => 'Admin',
], function () {
    Route::get('dashboard', ['uses' => 'DashboardController@index']);
    Route::get('dashboard/calender/get_data', ['uses' => 'DashboardController@getDataCalendar']);

    // PROKER
    Route::get('proker', ['uses' => 'ProkerController@index']);
    Route::get('proker/tambah', ['uses' => 'ProkerController@tambah']);
    Route::post('proker/tambah', ['uses' => 'ProkerController@prosesTambah']);
    Route::get('proker/edit/{id}', ['uses' => 'ProkerController@edit']);
    Route::post('proker/edit/{id}', ['uses' => 'ProkerController@prosesEdit']);
    Route::get('proker/hapus/{id}', ['uses' => 'ProkerController@hapus']);
    
    // KEGIATAN
    Route::get('kegiatan', ['uses' => 'KegiatanController@index']);
    Route::get('kegiatan/search', ['uses' => 'KegiatanController@search']);
    Route::get('kegiatan/detail/{id}', ['uses' => 'KegiatanController@detail']); 
    // LAPORAN KEGIATAN
    Route::get('laporan_kegiatan', ['uses' => 'LaporanKegiatanControlller@index']);
    Route::get('laporan_kegiatan/search', ['uses' => 'LaporanKegiatanControlller@search']);
    Route::get('laporan_kegiatan/detail/{id}', ['uses' => 'LaporanKegiatanControlller@detail']); 

    // ORMAWA
    Route::get('ormawa', ['uses' => 'OrmawaController@index']);
    Route::get('ormawa/tambah', ['uses' => 'OrmawaController@tambah']);
    Route::post('ormawa/tambah', ['uses' => 'OrmawaController@prosesTambah']);
    Route::get('ormawa/edit/{id}', ['uses' => 'OrmawaController@edit']);
    Route::post('ormawa/edit/{id}', ['uses' => 'OrmawaController@prosesEdit']);
    Route::get('ormawa/hapus/{id}', ['uses' => 'OrmawaController@hapus']);
    Route::get('ormawa/detail/{id}', ['uses' => 'OrmawaController@detail']);
    Route::get('ormawa/reset_password/{id}', ['uses' => 'OrmawaController@resetPassword']);

    // RUANGAN
    Route::get('ruangan', ['uses' => 'RuanganController@index']);
    Route::get('ruangan/tambah', ['uses' => 'RuanganController@tambah']);
    Route::post('ruangan/tambah', ['uses' => 'RuanganController@prosesTambah']);
    Route::get('ruangan/edit/{id}', ['uses' => 'RuanganController@edit']);
    Route::post('ruangan/edit/{id}', ['uses' => 'RuanganController@prosesEdit']);
    Route::get('ruangan/hapus/{id}', ['uses' => 'RuanganController@hapus']);

    // MAHASISWA
    Route::get('mahasiswa', ['uses' => 'MahasiswaController@index']);
    Route::get('mahasiswa/hapus/{id}', ['uses' => 'MahasiswaController@hapus']);
    Route::get('mahasiswa/reset_password/{id}', ['uses' => 'MahasiswaController@resetPassword']);

    // PENGGUNA APLIKASI
    Route::get('pengguna', ['uses' => 'PenggunaController@index']);
    Route::get('pengguna/tambah', ['uses' => 'PenggunaController@tambah']);
    Route::post('pengguna/tambah', ['uses' => 'PenggunaController@prosesTambah']);
    Route::get('pengguna/edit/{id}', ['uses' => 'PenggunaController@edit']);
    Route::post('pengguna/edit/{id}', ['uses' => 'PenggunaController@prosesEdit']);
    Route::get('pengguna/hapus/{id}', ['uses' => 'PenggunaController@hapus']);
    Route::get('pengguna/ubah_password/{id}', ['uses' => 'PenggunaController@ubah_password']);
    Route::post('pengguna/ubah_password/{id}', ['uses' => 'PenggunaController@prosesUbahPassword']);
});

Route::group([
    'name'       => 'wadir.',
    'prefix'     => 'wadir',
    'middleware' => ['auth:admin', 'check_user:wadir'],
    'namespace'  => 'Wadir',
], function () {
    Route::get('dashboard', ['uses' => 'DashboardController@index']);
    Route::get('dashboard/search_kegiatan', ['uses' => 'DashboardController@search_kegiatan']);
    Route::get('dashboard/calender/get_data', ['uses' => 'DashboardController@getDataCalendar']);
    
    // KEGIATAN
    Route::get('kegiatan', ['uses' => 'KegiatanController@index']);
    Route::get('kegiatan/detail/{id}', ['uses' => 'KegiatanController@detail']); 
    Route::get('kegiatan/search', ['uses' => 'KegiatanController@search']);

    // ORMAWA
    Route::get('ormawa', ['uses' => 'OrmawaController@index']);
    Route::get('ormawa/detail/{id}', ['uses' => 'OrmawaController@detail']);

});

Route::group([
    'name'       => 'ormawa.',
    'prefix'     => 'ormawa',
    'middleware' => ['auth:admin', 'check_user:ormawa'],
    'namespace'  => 'Ormawa',
], function () {
    Route::get('dashboard', ['uses' => 'DashboardController@index']);
    Route::get('dashboard/calender/get_data', ['uses' => 'DashboardController@getDataCalendar']);
    Route::get('dashboard/search_kegiatan', ['uses' => 'DashboardController@index']);
    Route::get('dashboard/detail_kegiatan/{id}', ['uses' => 'DashboardController@detail_kegiatan']);
    
    // KEGIATAN
    Route::get('kegiatan', ['uses' => 'KegiatanOrmawaController@index']);
    Route::get('kegiatan/detail/{id}', ['uses' => 'KegiatanOrmawaController@detail']); 
    Route::get('kegiatan/search', ['uses' => 'KegiatanOrmawaController@search']);
    Route::get('kegiatan/tambah', ['uses' => 'KegiatanOrmawaController@tambah']);
    Route::post('kegiatan/tambah', ['uses' => 'KegiatanOrmawaController@prosesTambah']);
    Route::get('kegiatan/edit/{id}', ['uses' => 'KegiatanOrmawaController@edit']);
    Route::post('kegiatan/edit/{id}', ['uses' => 'KegiatanOrmawaController@prosesEdit']);

    Route::get('pengguna/update', ['uses' => 'PenggunaController@update']);
    Route::post('pengguna/update', ['uses' => 'PenggunaController@prosesUpdate']);
    Route::get('pengguna/update_password', ['uses' => 'PenggunaController@updatePassword']);
    Route::post('pengguna/update_password', ['uses' => 'PenggunaController@prosesUpdatePassword']);

});

Route::group([
    'name'       => 'mahasiswa.',
    'prefix'     => 'mahasiswa',
    'middleware' => ['auth:admin', 'check_user:mahasiswa'],
    'namespace'  => 'Mahasiswa',
], function () {
    Route::get('dashboard', ['uses' => 'DashboardController@index']);
    Route::get('dashboard/calender/get_data', ['uses' => 'DashboardController@getDataCalendar']);
    
    // KEGIATAN
    Route::get('kegiatan', ['uses' => 'KegiatanController@index']);
    Route::get('kegiatan/detail/{id}', ['uses' => 'KegiatanController@detail']); 
    Route::get('kegiatan/search', ['uses' => 'KegiatanController@search']);
    Route::get('kegiatan/tambah', ['uses' => 'KegiatanController@tambah']);
    Route::post('kegiatan/tambah', ['uses' => 'KegiatanController@prosesTambah']);
    Route::get('kegiatan/edit/{id}', ['uses' => 'KegiatanController@edit']);
    Route::post('kegiatan/edit/{id}', ['uses' => 'KegiatanController@prosesEdit']);

});
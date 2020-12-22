<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrmawaController extends Controller
{
    function __construct()
    {
        $this->title  = 'Ormawa';
        $this->prefix = 'ormawa';
        $app_type     = 'admin';

        $this->root = $app_type . '/' . $this->prefix;
    }

    public function index()
    {
        $data = DB::table('ormawa')->get();

        $title  = $this->title;
        $prefix = $this->prefix;

        return view($this->root . '/index', compact(
            'data',
            'title',
            'form_action_url',
            'prefix'
        ));
    }

    public function tambah()
    {
        $title           = $this->title;
        $prefix          = $this->prefix;
        $form_action_url = $this->root . '/tambah';

        return view($this->root . '/tambah', compact(
            'data',
            'title',
            'form_action_url',
            'prefix'
        ));
    }

    public function prosesTambah(Request $request)
    {
        $data = $request->input();

        unset($data['_token']);

        $data['password'] = bcrypt($data['username']);

        $data_pengguna = [
            'name'      => $data['nama'],
            'username'  => $data['username'],
            'password'  => bcrypt($data['username']),
            'hak_akses' => 'ormawa',
        ];
        $data['pengguna_id'] = DB::table('pengguna')->insertGetId($data_pengguna);

        DB::table('ormawa')->insert($data);

        $this->message("success", "Data berhasil disimpan!");
        return redirect($this->root);
    }

    public function edit($id)
    {
        $data = DB::table('ormawa')->where('id', $id)->first();

        $title           = $this->title;
        $prefix          = $this->prefix;
        $form_action_url = $this->root . '/edit/' . $id;

        return view($this->root . '/edit', compact(
            'data',
            'title',
            'form_action_url',
            'prefix'
        ));
    }

    public function prosesEdit($id, Request $request)
    {
        $data = $request->input();
        
        $data['password'] = bcrypt($data['username']);
        
        unset($data['_token']);

        $data_pengguna = [
            'name'      => $data['nama'],
            'username'  => $data['username'],
            'password'  => bcrypt($data['username']),
            'hak_akses' => 'ormawa',
        ];
        DB::table('pengguna')
            ->where('id', $data['pengguna_id'])
            ->update($data_pengguna);

        DB::table('ormawa')
            ->where('id', $id)
            ->update($data);
            
        $this->message("success", "Perubahan berhasil disimpan!");
        return redirect($this->root);
    }

    public function hapus($id)
    {
        $ormawa = DB::table('ormawa')->where('id', $id)->first();

        DB::table('ormawa')
            ->where('id', $id)
            ->delete();

        DB::table('pengguna')
            ->where('id', $ormawa->id)
            ->delete();

        $this->message("success", "Data berhasil dihapus!");
        return redirect($this->root);
    }

    public function resetPassword($id)
    {
        $data = DB::table('ormawa')->where('id', $id)->first();

        DB::table('ormawa')
            ->where('id', $id)
            ->update([
                'password' => bcrypt($data->username)
            ]);

        $this->message("success", "Password berhasil direset!");
        return redirect($this->root);
    }

    public function detail($id)
    {
        $data = DB::table('ormawa')->where('id', $id)->first();
        
		$kegiatan = DB::select("SELECT 
                IF(k.tanggal > curdate(), 'Belum Terlaksana', 'Sudah Terlaksana') AS status,
				k.*,
				o.nama AS nama_ormawa,
				r.nama AS nama_ruangan
			FROM kegiatan k
			left join ormawa o
				on o.id = k.ormawa_id
			left join ruangan r
				on r.id = k.ruangan_id
            where k.ormawa_id = $id
		");

        $title           = $this->title;
        $prefix          = $this->prefix;
        $form_action_url = $this->root . '/edit/' . $id;

        return view($this->root . '/detail', compact(
            'data',
            'proker',
            'kegiatan',
            'title',
            'form_action_url',
            'prefix'
        ));
    }
}

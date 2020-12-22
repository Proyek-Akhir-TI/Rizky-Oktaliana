<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProkerController extends Controller
{
    function __construct()
    {
        $this->title  = 'Program Kerja (Proker)';
        $this->prefix = 'proker';
        $app_type     = 'admin';

        $this->root = $app_type . '/' . $this->prefix;
    }

    public function index()
    {
		$data = DB::select("SELECT 
				p.*,
				o.nama AS nama_ormawa,
				r.nama AS nama_ruangan
			FROM proker p
			left join ormawa o
				on o.id = p.ormawa_id
			left join ruangan r
				on r.id = p.ruangan_id
		");

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

        $ormawa = DB::table('ormawa')->get();
        $ruangan = DB::table('ruangan')->get();

        return view($this->root . '/tambah', compact(
            'data',
            'ormawa',
            'ruangan',
            'title',
            'form_action_url',
            'prefix'
        ));
    }

    public function prosesTambah(Request $request)
    {
        $data = $request->input();

        unset($data['_token']);

        DB::table('proker')->insert($data);

        $this->message("success", "Data berhasil disimpan!");
        return redirect($this->root);
    }

    public function edit($id)
    {
        $data = DB::table('proker')->where('id', $id)->first();

        $ormawa = DB::table('ormawa')->get();
        $ruangan = DB::table('ruangan')->get();

        $title           = $this->title;
        $prefix          = $this->prefix;
        $form_action_url = $this->root . '/edit/' . $id;

        return view($this->root . '/edit', compact(
            'data',
            'ormawa',
            'ruangan',
            'title',
            'form_action_url',
            'prefix'
        ));
    }

    public function prosesEdit($id, Request $request)
    {
        $data = $request->input();
        
        unset($data['_token']);

        DB::table('proker')
            ->where('id', $id)
            ->update($data);

        $this->message("success", "Perubahan berhasil disimpan!");
        return redirect($this->root);
    }

    public function hapus($id)
    {
        DB::table('proker')
            ->where('id', $id)
            ->delete();

        $this->message("success", "Data berhasil dihapus!");
        return redirect($this->root);
    }
}

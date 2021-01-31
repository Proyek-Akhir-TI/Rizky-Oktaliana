<?php

namespace App\Http\Controllers\Wadir;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrmawaController extends Controller
{
    function __construct()
    {
        $this->title  = 'Ormawa';
        $this->prefix = 'ormawa';
        $app_type     = 'wadir';

        $this->root = $app_type . '/' . $this->prefix;
    }

    public function index()
    {
        $data = DB::select("SELECT
                o.*, ok.nama_ketua
            FROM ormawa o
            inner join (
                select * from ormawa_ketua where status = 1
            ) ok
                on ok.ormawa_id = o.id
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

    public function detail($id, Request $request)
    {
        $data = DB::select("SELECT
                o.*, ok.nama_ketua
            FROM ormawa o
            inner join (
                select * from ormawa_ketua where status = 1
            ) ok
                on ok.ormawa_id = o.id
            where o.id = $id
        ");

        $data = collect($data)->first();
        
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
        
        $ketuas = DB::table('ormawa_ketua')
            ->where('ormawa_id', $id);

        $tahun = empty($request->tahun) ? '' : $request->tahun;

        if (!empty($tahun)) {
            $ketuas = $ketuas->where('periode', $tahun);
        }

        $ketuas = $ketuas->get();

        $title           = $this->title;
        $prefix          = $this->prefix;
        $form_action_url = $this->root . '/edit/' . $id;

        return view($this->root . '/detail', compact(
            'data',
            'proker',
            'kegiatan',
            'ketuas',
            'tahun',
            'title',
            'form_action_url',
            'prefix'
        ));
    }
}

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

    public function detail(Request $request, $id)
    {
        $data = DB::table('ormawa')->where('id', $id)->first();
        $tahun = empty($request->input('tahun')) ? "" : $request->input('tahun');

        $qTahun = "";

        if (!empty($tahun)) {
            $qTahun = " AND date_format(k.tanggal, '%Y') = '$tahun'";
        }
        
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
            where k.ormawa_id = $id $qTahun
		");
        
		$total_biaya_kegiatan = DB::select("SELECT 
				sum(k.total_biaya_kegiatan) AS total_biaya_kegiatan
			FROM kegiatan k
			left join ormawa o
				on o.id = k.ormawa_id
			left join ruangan r
				on r.id = k.ruangan_id
            where k.ormawa_id = $id $qTahun
        ");
        
        $total_biaya_kegiatan = collect($total_biaya_kegiatan)->first()->total_biaya_kegiatan;

        $title           = $this->title;
        $prefix          = $this->prefix;
        $form_action_url = $this->root . '/edit/' . $id;

        return view($this->root . '/detail', compact(
            'data',
            'proker',
            'kegiatan',
            'total_biaya_kegiatan',
            'title',
            'form_action_url',
            'tahun',
            'prefix'
        ));
    }
}

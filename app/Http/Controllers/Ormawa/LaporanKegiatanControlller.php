<?php

namespace App\Http\Controllers\Ormawa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanKegiatanControlller extends Controller
{
    function __construct()
    {
        $this->title  = 'Laporan Kegiatan';
        $this->prefix = 'laporan_kegiatan';
        $app_type     = 'ormawa';

        $this->root = $app_type . '/' . $this->prefix;
    }

    public function index()
    {
        $penggunaID = Auth::guard('admin')->user()->id;

		$data = DB::select("SELECT 
				k.*,
				o.nama AS nama_ormawa,
				r.nama AS nama_ruangan
			FROM kegiatan k
			left join ormawa o
				on o.id = k.ormawa_id
			left join ruangan r
				on r.id = k.ruangan_id
            WHERE o.pengguna_id = $penggunaID
		");

        $ormawa = DB::table('ormawa')->get();

        $title  = $this->title;
        $prefix = $this->prefix;

        $bulan = '';
        $tahun = '';
        $ormawa_id = '';

        return view($this->root . '/index', compact(
            'data',
            'ormawa',
            'ormawa_id',
            'bulan',
            'tahun',
            'title',
            'prefix'
        ));
    }

    public function search(Request $request)
    {
        $bulan     = empty($request['bulan']) ? ""    : $request['bulan'];
        $tahun     = empty($request['tahun']) ? ""    : $request['tahun'];
        $penggunaID = Auth::guard('admin')->user()->id;
        
		// $data = DB::select("SELECT 
		// 		k.*,
		// 		o.nama AS nama_ormawa,
		// 		r.nama AS nama_ruangan
		// 	FROM kegiatan k
		// 	left join ormawa o
		// 		on o.id = k.ormawa_id
		// 	left join ruangan r
		// 		on r.id = k.ruangan_id
        // ");
        $data = []; 
        $qWaktu = '';

        if (!empty($bulan) || !empty($tahun)) {
            
            if (!empty($bulan) && !empty($tahun)) {
                $qWaktu = " AND DATE_FORMAT(k.tanggal, '%m-%Y') = '$bulan-$tahun'";
            } elseif (!empty($tahun)) {
                $qWaktu = " AND DATE_FORMAT(k.tanggal, '%Y') = '$tahun'";
            }
        }

        $data = DB::select("SELECT 
                k.*,
                o.nama AS nama_ormawa,
                r.nama AS nama_ruangan
            FROM kegiatan k
            left join ormawa o
                on o.id = k.ormawa_id
            left join ruangan r
                on r.id = k.ruangan_id
            where  o.pengguna_id = $penggunaID $qWaktu
        ");

        $ormawa = DB::table('ormawa')->get();

        $title  = $this->title;
        $prefix = $this->prefix;

        return view($this->root . '/index', compact(
            'data',
            'ormawa',
            'bulan',
            'tahun',
            'title',
            'prefix'
        ));
    }

    public function detail($id)
    {
		$data = DB::select("SELECT 
				k.*,
				o.nama AS nama_ormawa,
				r.nama AS nama_ruangan
			FROM kegiatan k
			left join ormawa o
				on o.id = k.ormawa_id
			left join ruangan r
				on r.id = k.ruangan_id
            where k.id = $id
        ");
        
        $data = collect($data)->first();

        $title           = $this->title;
        $prefix          = $this->prefix;
        $form_action_url = $this->root . '/detail/' . $id;

        return view($this->root . '/detail', compact(
            'data',
            'title',
            'form_action_url',
            'prefix'
        ));
    }


    public function cetak(Request $request)
    {
        $penggunaID = Auth::guard('admin')->user()->id; 
        $bulan     = empty($request['bulan']) ? ""    : $request['bulan'];
        $tahun     = empty($request['tahun']) ? ""    : $request['tahun'];
        
		// $data = DB::select("SELECT 
		// 		k.*,
		// 		o.nama AS nama_ormawa,
		// 		r.nama AS nama_ruangan
		// 	FROM kegiatan k
		// 	left join ormawa o
		// 		on o.id = k.ormawa_id
		// 	left join ruangan r
		// 		on r.id = k.ruangan_id
        // ");
        
        $data = []; 
        $qWaktu = '';

        if (!empty($bulan) || !empty($tahun)) {
            
            if (!empty($bulan) && !empty($tahun)) {
                $qWaktu = " AND DATE_FORMAT(k.tanggal, '%m-%Y') = '$bulan-$tahun'";
            } elseif (!empty($tahun)) {
                $qWaktu = " AND DATE_FORMAT(k.tanggal, '%Y') = '$tahun'";
            }
        }

        $data = DB::select("SELECT 
                k.*,
                o.nama AS nama_ormawa,
                r.nama AS nama_ruangan
            FROM kegiatan k
            left join ormawa o
                on o.id = k.ormawa_id
            left join ruangan r
                on r.id = k.ruangan_id
            where  o.pengguna_id = $penggunaID $qWaktu
        ");

        $ormawa = DB::table('ormawa')->where('pengguna_id', $penggunaID)->first();

        return view($this->root . '/cetak', compact(
            'data',
            'ormawa', 
            'bulan',
            'tahun'
        ));
    }
}
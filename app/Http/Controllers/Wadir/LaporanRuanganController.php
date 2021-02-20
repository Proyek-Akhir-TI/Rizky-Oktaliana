<?php

namespace App\Http\Controllers\Wadir;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LaporanRuanganController extends Controller
{
    function __construct()
    {
        $this->title  = 'Laporan Ruangan';
        $this->prefix = 'laporan_ruangan';
        $app_type     = 'wadir';

        $this->root = $app_type . '/' . $this->prefix;
    }

    public function index()
    {
		$data = DB::select("SELECT r.nama AS nama_ruangan, COUNT(r.id) AS jml_kegiatan FROM kegiatan k
                INNER JOIN ruangan r
                    ON r.id = k.ruangan_id
                GROUP BY k.ruangan_id
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
        
        if (!empty($tahun)) {
            $qWaktu = '';
            
            if (!empty($bulan) || !empty($tahun)) {
                $qWaktu = " WHERE DATE_FORMAT(k.tanggal, '%Y') = '$tahun'";
            }

            $data = DB::select("SELECT r.nama AS nama_ruangan, COUNT(r.id) AS jml_kegiatan FROM kegiatan k
            INNER JOIN ruangan r
                ON r.id = k.ruangan_id
                 $qWaktu
            GROUP BY k.ruangan_id
            ");
        }

        $ormawa = DB::table('ormawa')->get();

        $title  = $this->title;
        $prefix = $this->prefix;

        return view($this->root . '/index', compact(
            'data',
            'ormawa',
            'tahun',
            'title',
            'prefix'
        ));
    }

    public function cetak(Request $request)
    {
        $tahun = empty($request['tahun']) ? ""    : $request['tahun'];
        
        if ( !empty($tahun)) {
            $qWaktu = '';
            
            if (!empty($tahun)) {
                $qWaktu = " WHERE DATE_FORMAT(k.tanggal, '%Y') = '$tahun'";
            }

            $data = DB::select("SELECT r.nama AS nama_ruangan, COUNT(r.id) AS jml_kegiatan FROM kegiatan k
                INNER JOIN ruangan r
                    ON r.id = k.ruangan_id
                    $qWaktu
                GROUP BY k.ruangan_id
            ");
        } else {

            $data = DB::select("SELECT r.nama AS nama_ruangan, COUNT(r.id) AS jml_kegiatan FROM kegiatan k
                    INNER JOIN ruangan r
                        ON r.id = k.ruangan_id
                    GROUP BY k.ruangan_id
            ");

        }

        $title  = $this->title;
        $prefix = $this->prefix;

        return view($this->root . '/cetak', compact(
            'data',
            'tahun',
            'title',
            'prefix'
        ));
    }
}

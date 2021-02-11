<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LaporanRuanganController extends Controller
{
    function __construct()
    {
        $this->title  = 'Laporan Ruangan';
        $this->prefix = 'laporan_ruangan';
        $app_type     = 'admin';

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
        
        if (!empty($ormawa_id) || !empty($bulan) || !empty($tahun)) {
            $qWaktu = '';
            
            if (!empty($bulan) || !empty($tahun)) {
                $qWaktu = " WHERE DATE_FORMAT(k.tanggal, '%m-%Y') = '$bulan-$tahun'";
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
            'ormawa_id',
            'bulan',
            'tahun',
            'title',
            'form_action_url',
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

    public function hapus($id)
    {
        DB::table('kegiatan')
            ->where('id', $id)
            ->delete();

        $this->message("success", "Data berhasil dihapus!");
        return redirect($this->root);
    }

    public function cetak(Request $request)
    {
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
        
        if (!empty($bulan) || !empty($tahun)) {
            $qWaktu = '';
            
            if (!empty($bulan) || !empty($tahun)) {
                $qWaktu = " WHERE DATE_FORMAT(k.tanggal, '%m-%Y') = '$bulan-$tahun'";
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
            'ormawa',
            'ormawa_id',
            'bulan',
            'tahun',
            'title',
            'form_action_url',
            'prefix'
        ));
    }
}

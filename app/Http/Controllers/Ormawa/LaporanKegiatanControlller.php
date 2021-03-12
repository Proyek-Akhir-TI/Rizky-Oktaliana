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
        $penggunaID = Auth::guard('admin')->user()->id_pengguna;

		$data = DB::select("SELECT 
				k.*,
				o.nama AS nama_ormawa,
				r.nama AS nama_ruangan
			FROM kegiatan k
			left join ormawa o
				on o.id_pengguna = k.id_pengguna
			left join ruangan r
				on r.id_ruangan = k.id_ruangan
            WHERE o.id_pengguna = $penggunaID
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
        $penggunaID = Auth::guard('admin')->user()->id_pengguna;
        
		// $data = DB::select("SELECT 
		// 		k.*,
		// 		o.nama AS nama_ormawa,
		// 		r.nama AS nama_ruangan
		// 	FROM kegiatan k
		// 	left join ormawa o
		// 		on o.id_pengguna = k.id_pengguna
		// 	left join ruangan r
		// 		on r.id_ruangan = k.id_ruangan
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
                on o.id_pengguna = k.id_pengguna
            left join ruangan r
                on r.id_ruangan = k.id_ruangan
            where  o.id_pengguna = $penggunaID $qWaktu
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
				on o.id_pengguna = k.id_pengguna
			left join ruangan r
				on r.id_ruangan = k.id_ruangan
            where k.id_kegiatan = $id
        ");

        $peserta = DB::select("SELECT
                pg.name, pt.*, p.id_kegiatan
            from pemesanan p
            left join pengguna pg
                on p.id_pengguna = pg.id_pengguna
            left join peserta pt
                on pt.id_pengguna = pg.id_pengguna
            where p.id_kegiatan = $id and p.id_status = 3
        ");
        
        $jml_peserta = collect($peserta)->count();
        
        $data = collect($data)->first();

        $title           = $this->title;
        $prefix          = $this->prefix;
        $form_action_url = $this->root . '/detail/' . $id;

        return view($this->root . '/detail', compact(
            'jml_peserta',
            'peserta',
            'data',
            'title',
            'form_action_url',
            'prefix'
        ));
    }


    public function cetak(Request $request)
    {
        $penggunaID = Auth::guard('admin')->user()->id_pengguna; 

        $bulan     = empty($request['bulan']) ? ""    : $request['bulan'];
        $tahun     = empty($request['tahun']) ? ""    : $request['tahun'];
        
		// $data = DB::select("SELECT 
		// 		k.*,
		// 		o.nama AS nama_ormawa,
		// 		r.nama AS nama_ruangan
		// 	FROM kegiatan k
		// 	left join ormawa o
		// 		on o.id_pengguna = k.id_pengguna
		// 	left join ruangan r
		// 		on r.id_ruangan = k.id_ruangan
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
                on o.id_pengguna = k.id_pengguna
            left join ruangan r
                on r.id_ruangan = k.id_ruangan
            where  o.id_pengguna = $penggunaID $qWaktu
        ");

        $ormawa = DB::table('ormawa')->where('id_pengguna', $penggunaID)->first();

        return view($this->root . '/cetak', compact(
            'data',
            'ormawa', 
            'bulan',
            'tahun'
        ));
    }

    public function cetak_peserta($id)
    {
        $peserta = DB::select("SELECT
                pg.name, pt.*, p.id_kegiatan
            from pemesanan p
            left join pengguna pg
                on p.id_pengguna = pg.id_pengguna
            left join peserta pt
                on pt.id_pengguna = pg.id_pengguna
            where p.id_kegiatan = $id and p.id_status = 3
        ");

		$data = collect(DB::select("SELECT 
                k.*,
                o.nama AS nama_ormawa,
                r.nama AS nama_ruangan
            FROM kegiatan k
            left join ormawa o
                on o.id_pengguna = k.id_pengguna
            left join ruangan r
                on r.id_ruangan = k.id_ruangan
            where k.id_kegiatan = $id
        "))->first();

        $nama_kegiatan = $data->nama;

        $title           = $this->title;
        $prefix          = $this->prefix;
        $form_action_url = $this->root . '/detail/' . $id;

        return view($this->root . '/cetak_peserta', compact(
            'peserta',
            'nama_kegiatan',
            'title',
            'form_action_url',
            'prefix'
        ));
    }
}

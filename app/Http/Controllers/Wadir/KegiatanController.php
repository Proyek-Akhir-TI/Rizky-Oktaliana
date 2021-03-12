<?php

namespace App\Http\Controllers\Wadir;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class KegiatanController extends Controller
{
    function __construct()
    {
        $this->title  = 'Laporan Kegiatan';
        $this->prefix = 'kegiatan';
        $app_type     = 'wadir';

        $this->root = $app_type . '/' . $this->prefix;
    }

    public function index()
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
        $ormawa_id = empty($request['ormawa_id']) ? "": $request['ormawa_id'];
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
        
        if (!empty($ormawa_id) || !empty($bulan) || !empty($tahun)) {
            $qWaktu = '';
            
            if (!empty($bulan) && !empty($tahun)) {
                $qWaktu = " AND DATE_FORMAT(k.tanggal, '%m-%Y') = '$bulan-$tahun'";
            } elseif (!empty($tahun)) {
                $qWaktu = " AND DATE_FORMAT(k.tanggal, '%Y') = '$tahun'";
            }

            $qOrmawa = "";
            if (!empty($ormawa_id)) {
                $qOrmawa  = " o.id_ormawa = $ormawa_id";
            } else {
                $qOrmawa  = " o.id_ormawa is not null";
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
                where $qOrmawa $qWaktu
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
            'data',
            'peserta',
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

    public function cetak(Request $request)
    {
		$ormawa_id = empty($request['ormawa_id']) ? "": $request['ormawa_id'];
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
        
        $qWaktu = '';
        if (!empty($ormawa_id) || !empty($bulan) || !empty($tahun)) {
            
            if (!empty($bulan) && !empty($tahun)) {
                $qWaktu = " AND DATE_FORMAT(k.tanggal, '%m-%Y') = '$bulan-$tahun'";
            } elseif (!empty($tahun)) {
                $qWaktu = " AND DATE_FORMAT(k.tanggal, '%Y') = '$tahun'";
            }
        }

        $qOrmawa = "";
        if (!empty($ormawa_id)) {
            $qOrmawa  = " o.id_ormawa = $ormawa_id";
        } else {
            $qOrmawa  = " o.id_ormawa is not null";
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
            where $qOrmawa $qWaktu
        ");

        $ormawa = DB::table('ormawa')->where('id_ormawa', $ormawa_id)->first();

        return view($this->root . '/cetak', compact(
            'data',
            'ormawa',
            'ormawa_id',
            'bulan',
            'tahun'  
        ));
    }
}

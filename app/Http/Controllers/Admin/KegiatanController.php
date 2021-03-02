<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class KegiatanController extends Controller
{
    function __construct()
    {
        $this->title  = 'Data Kegiatan';
        $this->prefix = 'kegiatan';
        $app_type     = 'admin';

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
        $id_ormawa = '';

        return view($this->root . '/index', compact(
            'data',
            'ormawa',
            'id_ormawa',
            'bulan',
            'tahun',
            'title',
            'prefix'
        ));
    }

    public function search(Request $request)
    {
        $id_ormawa = empty($request['id_ormawa']) ? "": $request['id_ormawa'];
        $bulan     = empty($request['bulan']) ? ""    : $request['bulan'];
        $tahun     = empty($request['tahun']) ? ""    : $request['tahun'];
        
		// $data = DB::select("SELECT 
		// 		k.*,
		// 		o.nama AS nama_ormawa,
		// 		r.nama AS nama_ruangan
		// 	FROM kegiatan k
		// 	left join ormawa o
		// 		on o.id = k.id_ormawa
		// 	left join ruangan r
		// 		on r.id = k.ruangan_id
        // ");
        
        if (!empty($id_ormawa) || !empty($bulan) || !empty($tahun)) {
            $qWaktu = '';
            
            if (!empty($bulan) || !empty($tahun)) {
                $qWaktu = " DATE_FORMAT(k.tanggal, '%m-%Y') = '$bulan-$tahun'";
            }

            $qOrmawa = "";
            if (!empty($id_ormawa)) {
                $qOrmawa  = " o.id_ormawa = $id_ormawa";
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
                    where $qWaktu $qOrmawa
            ");
        }

        $ormawa = DB::table('ormawa')->get();

        $title  = $this->title;
        $prefix = $this->prefix;

        return view($this->root . '/index', compact(
            'data',
            'ormawa',
            'id_ormawa',
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
}

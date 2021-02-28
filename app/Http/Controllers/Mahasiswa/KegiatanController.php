<?php

namespace App\Http\Controllers\Mahasiswa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KegiatanController extends Controller
{
    function __construct()
    {
        $this->title  = 'Data Kegiatan';
        $this->prefix = 'kegiatan';
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
            'form_action_url',
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
		// 		on o.id = k.ormawa_id
		// 	left join ruangan r
		// 		on r.id = k.ruangan_id
        // ");
        
        if (!empty($ormawa_id) || !empty($bulan) || !empty($tahun)) {
            $qWaktu = '';
            
            if (!empty($bulan) || !empty($tahun)) {
                $qWaktu = " AND DATE_FORMAT(k.tanggal, '%m-%Y') = '$bulan-$tahun'";
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
                where o.id = $ormawa_id $qWaktu
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

    public function tambah()
    {
        $title           = $this->title;
        $prefix          = $this->prefix;
        $form_action_url = $this->root . '/tambah';
        $penggunaID      = Auth::guard('admin')->user()->id_pengguna;

        $ormawa_id = DB::table('ormawa')->where('pengguna_id', $penggunaID)->first()->id;

        $ruangan = DB::table('ruangan')->get();

        return view($this->root . '/tambah', compact(
            'data',
            'title',
            'form_action_url',
            'prefix',
            'ormawa_id',
            'ruangan'
        ));
    }

    public function prosesTambah(Request $request)
    {
        $data = $request->input();

        $request->validate([
            'poster' => 'required|max:20480',
        ]);
        
        unset($data['_token']);

        $data['waktu_mulai'] = $data['waktu_mulai'] . ':00';
        $data['waktu_akhir'] = $data['waktu_akhir'] . ':00';
        $data['jml_peserta'] = 0;
        $data['jml_kehadiran'] = 0;

        if (!empty($request->poster)) {
            $data['poster'] = time().'.'.$request->poster->extension();

            $request->poster->move(public_path('uploads'), $data['poster']);
        }
        
        DB::table('kegiatan')->insert($data);

        return redirect($this->root);
    }

    public function edit($id)
    {
        $title           = $this->title;
        $prefix          = $this->prefix;
        $form_action_url = $this->root . '/edit/' . $id;
        $penggunaID      = Auth::guard('admin')->user()->id_pengguna;

        $data = DB::table('kegiatan')->where('id', $id)->first();

        $ormawa_id = DB::table('ormawa')->where('pengguna_id', $penggunaID)->first()->id;

        $ruangan = DB::table('ruangan')->get();

        return view($this->root . '/edit', compact(
            'data',
            'title',
            'form_action_url',
            'prefix',
            'ormawa_id',
            'ruangan'
        ));
    }

    public function prosesEdit(Request $request, $id)
    {
        $data = $request->input();

        $request->validate([
            'poster' => 'max:20480',
        ]);
        
        unset($data['_token']);

        $data['waktu_mulai']   = $data['waktu_mulai'] . ':00';
        $data['waktu_akhir']   = $data['waktu_akhir'] . ':00';
        $data['jml_peserta']   = 0;
        $data['jml_kehadiran'] = 0;

        if (!empty($request->poster)) {
            $data['poster'] = time().'.'.$request->poster->extension();

            $request->poster->move(public_path('uploads'), $data['poster']);
        }
        
        DB::table('kegiatan')
            ->where('id', $id)
            ->update($data);

        return redirect($this->root);
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
}

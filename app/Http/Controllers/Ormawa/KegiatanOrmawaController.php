<?php

namespace App\Http\Controllers\Ormawa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KegiatanOrmawaController extends Controller
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
        $form_action_url = '';

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
        $penggunaID = Auth::guard('admin')->user()->id_pengguna;
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
        
        if ( !empty($bulan) || !empty($tahun)) {
            $qWaktu = '';
            
            if (!empty($tahun)) {
                $qWaktu = " AND DATE_FORMAT(k.tanggal, '%Y') = '$tahun'";
            }
            if (!empty($bulan) && !empty($tahun)) {
                $qWaktu = " AND DATE_FORMAT(k.tanggal, '%m-%Y') = '$bulan-$tahun'";
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
                where o.id_pengguna = $penggunaID $qWaktu
            ");
        }

        $ormawa = DB::table('ormawa')->get();

        $ormawa_id = $penggunaID;

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

    public function tambah()
    {
        $title           = $this->title;
        $prefix          = $this->prefix;
        $form_action_url = $this->root . '/tambah';
        $penggunaID      = Auth::guard('admin')->user()->id_pengguna;

        $ormawa_id = DB::table('ormawa')->where('id_pengguna', $penggunaID)->first()->id_ormawa;

        $ruangan = DB::table('ruangan')->get();

        return view($this->root . '/tambah', compact(
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
            'poster' => 'max:20480',
        ]);
        
        unset($data['_token']);

        $data['waktu_mulai']          = $data['waktu_mulai'];
        $data['waktu_akhir']          = $data['waktu_akhir'];
        $data['total_biaya_kegiatan'] = str_replace(',', '', $data['total_biaya_kegiatan']);
        $data['biaya_keikutsertaan']  = str_replace(',', '', $data['biaya_keikutsertaan']);
        $data['status']               = 1; // belum terlaksana

        $tanggal = $data['tanggal'];
        $tanggal_mulai = $data['waktu_mulai'];
        $tanggal_akhir = $data['waktu_akhir'];

        $check = collect(DB::select("SELECT * from kegiatan 
        where tanggal = '$tanggal'
        and (waktu_mulai between '$tanggal_mulai' and '$tanggal_akhir' OR waktu_akhir between '$tanggal_mulai' and '$tanggal_akhir')
        and id_ruangan = " . $data['id_ruangan']))->count();

        if ($check != 0) {
            $this->message("warning", "Ruangan sudah digunakan acara lain");
            return redirect('ormawa/kegiatan/tambah');
        }

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

        $data = DB::table('kegiatan')->where('id_kegiatan', $id)->first();

        $ormawa_id = DB::table('ormawa')->where('id_pengguna', $penggunaID)->first()->id_ormawa;

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

        $data['waktu_mulai']          = $data['waktu_mulai'];
        $data['waktu_akhir']          = $data['waktu_akhir'];
        $data['total_biaya_kegiatan'] = str_replace(',', '', $data['total_biaya_kegiatan']);
        $data['biaya_keikutsertaan']  = str_replace(',', '', $data['biaya_keikutsertaan']);

        // if ($data['jml_kehadiran'] > 0) {
        //     $data['status'] = 2; // Sudah terlaksana
        // }

        if (!empty($request->poster)) {
            $data['poster'] = time() . '.' . $request->poster->extension();

            $request->poster->move(public_path('uploads'), $data['poster']);
        }
        
        DB::table('kegiatan')
            ->where('id_kegiatan', $id)
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
        
        $data = collect($data)->first();

        $title           = $this->title;
        $prefix          = $this->prefix;
        $form_action_url = $this->root . '/detail/' . $id;

        return view($this->root . '/detail', compact(
            'data',
            'peserta',
            'title',
            'form_action_url',
            'prefix'
        ));
    }

    public function cetak($id)
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

        return view($this->root . '/cetak', compact(
            'peserta',
            'nama_kegiatan',
            'title',
            'form_action_url',
            'prefix'
        ));
    }

    public function hapus($id)
    {
        DB::table('kegiatan')
            ->where('id_kegiatan', $id)
            ->delete();

        $this->message("success", "Data berhasil dihapus!");
        return redirect($this->root);
    }
}

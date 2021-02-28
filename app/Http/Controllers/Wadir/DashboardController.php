<?php

namespace App\Http\Controllers\Wadir;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $this_month = date('Y-m');
        $this_month_text = month_text(date('m')) . ' ' . date('Y');
        
        $kegiatan = DB::select("SELECT 
                k.*,
                o.nama AS nama_ormawa,
                r.nama AS nama_ruangan
            FROM kegiatan k
            left join ormawa o
                on o.id_pengguna = k.id_kegiatan
            left join ruangan r
                on r.id_ruangan = k.id_kegiatan
            where date_format(k.tanggal, '%Y-%m') = '$this_month'
        ");

        $ormawa_id = "";
        $ormawa    = DB::table('ormawa')->get();

        return view('wadir/dashboard', compact(
            'kegiatan',
            'this_month_text',
            'ormawa_id',
            'ormawa' 
        ));
    }

    public function search_kegiatan(Request $request)
    {
        $this_month = date('Y-m');
        $this_month_text = month_text(date('m')) . ' ' . date('Y');

        $ormawa_id = $request->input('ormawa_id');
        
        $qOrmawa = '';
        if (!empty($ormawa_id)) {
            $qOrmawa = " AND o.id_ormawa = $ormawa_id";
        }
        
        $kegiatan = DB::select("SELECT 
                k.*,
                o.nama AS nama_ormawa,
                r.nama AS nama_ruangan
            FROM kegiatan k
            left join ormawa o
                on o.id_pengguna = k.id_pengguna
            left join ruangan r
                on r.id_ruangan = k.id_kegiatan
            where date_format(k.tanggal, '%Y-%m') = '$this_month' $qOrmawa
        ");

        $ormawa = DB::table('ormawa')->get();

        return view('wadir/dashboard', compact(
            'kegiatan',
            'this_month_text',
            'ormawa_id',
            'ormawa' 
        ));
    }

    public function getDataCalendar(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');

		$data = DB::select("SELECT 
				p.*,
				o.nama AS nama_ormawa,
				r.nama AS nama_ruangan
			FROM proker p
			left join ormawa o
				on o.id_ormawa = p.ormawa_id
			left join ruangan r
				on r.id_ruangan = p.ruangan_id
        where date_format(p.tanggal_mulai, '%Y-%m-%d') between '$start' and '$end'");

        $data = collect($data)->map(function ($val)
        {
            return [
                'description' => "[" . $val->nama_ormawa . "]",
                'start'       => $val->tanggal_mulai,
                'end'         => $val->tanggal_akhir,
                'textColor'   => "white",
                "title"       => $val->nama
            ];
        });

        return response()->json($data);
    }
}

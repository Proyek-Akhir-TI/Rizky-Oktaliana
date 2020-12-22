<?php

namespace App\Http\Controllers\Admin;

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
                on o.id = k.ormawa_id
            left join ruangan r
                on r.id = k.ruangan_id
            where date_format(k.tanggal, '%Y-%m') = '$this_month'
        ");

        return view('admin/dashboard', compact(
            'kegiatan',
            'this_month_text'
        ));
    }

    public function getDataCalendar(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        
        $kegiatan = DB::select("SELECT 
                k.*,
                o.nama AS nama_ormawa,
                r.nama AS nama_ruangan
            FROM kegiatan k
            left join ormawa o
                on o.id = k.ormawa_id
            left join ruangan r
                on r.id = k.ruangan_id
            where date_format(k.tanggal, '%Y-%m-%d') between '$start' and '$end'
        ");

        $data = collect($kegiatan)->map(function ($val)
        {
            return [
                'description' => "[" . $val->nama_ormawa . "]",
                'start' => $val->tanggal,
                'end'   => $val->tanggal,
                'textColor' => "white",
                "title" => $val->nama
            ];
        });

        return response()->json($data);
    }
}

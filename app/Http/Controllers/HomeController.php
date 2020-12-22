<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
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
            where k.tanggal >= curdate()
        ");
        
        return view('home', compact(
            'kegiatan'
        ));
    }
}

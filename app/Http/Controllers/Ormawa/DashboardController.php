<?php

namespace App\Http\Controllers\Ormawa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    function __construct()
    {
        $this->title  = 'Dashboard';
        $this->prefix = 'dashboard';
        $app_type     = 'ormawa';

        $this->root = $app_type . '/' . $this->prefix;
    }

    public function index(Request $request)
    {
        $this_month = date('Y-m');
        $this_month_text = month_text(date('m')) . ' ' . date('Y');

        $ormawa_id = $request->input('ormawa_id');
        
        $qOrmawa = '';
        if (!empty($ormawa_id)) {
            $qOrmawa = " AND o.id = $ormawa_id";
        }
        
        $kegiatan = DB::select("SELECT 
                k.*,
                o.nama AS nama_ormawa,
                r.nama AS nama_ruangan
            FROM kegiatan k
            left join ormawa o
                on o.id = k.ormawa_id
            left join ruangan r
                on r.id = k.ruangan_id
            where date_format(k.tanggal, '%Y-%m') = '$this_month' $qOrmawa
        ");
        
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
        $ormawa = DB::table('ormawa')->get();

        return view('ormawa/dashboard', compact(
            'kegiatan',
            'this_month_text',
            'ormawa',
            'ormawa_id'
        ));
    }

    public function detail_kegiatan($id)
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

        return view('ormawa/detail_kegiatan', compact(
            'data',
            'title',
            'form_action_url',
            'prefix'
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
				on o.id = p.ormawa_id
			left join ruangan r
				on r.id = p.ruangan_id
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

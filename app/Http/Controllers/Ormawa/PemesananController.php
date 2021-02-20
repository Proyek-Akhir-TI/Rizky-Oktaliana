<?php

namespace App\Http\Controllers\Ormawa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PemesananController extends Controller
{
    function __construct()
    {
        $this->title  = 'Pemesananan';
        $this->prefix = 'pemesanan';
        $app_type     = 'ormawa';

        $this->root = $app_type . '/' . $this->prefix;
    }

    public function index()
    {
        $penggunaID = Auth::guard('admin')->user()->id;

        $data = DB::select("SELECT 
                t.id_transaksi as transaksi_id, pg.name as nama_peserta, k.nama as nama_kegiatan, p.tgl_pesan, t.batas_transaksi, t.bukti_pembayaran, p.id_status
            from transaksi t
            inner join pemesanan p
                on p.id_pemesanan = t.id_pemesanan
            left join kegiatan k
                on k.id = p.id_kegiatan
            left join pengguna pg
                on pg.id = p.id_pengguna
            left join ormawa o
                on k.ormawa_id = o.id
            WHERE o.pengguna_id = $penggunaID
        ");

        $title  = $this->title;
        $prefix = $this->prefix;

        return view($this->root . '/index', compact(
            'data',
            'title',
            'prefix'
        ));
    }

    public function detail($trx_id)
    {
        $penggunaID = Auth::guard('admin')->user()->id;

        $data = DB::select("SELECT 
                t.id_transaksi as transaksi_id, pg.name as nama_peserta, k.nama as nama_kegiatan, p.tgl_pesan, t.batas_transaksi, t.bukti_pembayaran, p.id_status
            from transaksi t
            inner join pemesanan p
                on p.id_pemesanan = t.id_pemesanan
            left join kegiatan k
                on k.id = p.id_kegiatan
            left join pengguna pg
                on pg.id = p.id_pengguna
            left join ormawa o
                on k.ormawa_id = o.id
            WHERE t.id_transaksi = $trx_id
        ");

        $data = collect($data)->first();

        $title  = $this->title;
        $prefix = $this->prefix;

        return view($this->root . '/detail', compact(
            'data',
            'title',
            'prefix'
        ));
    }

    public function confirm($trx_id)
    {
        $data = DB::select("SELECT 
                t.id_transaksi as transaksi_id, pg.name as nama_peserta, k.nama as nama_kegiatan, p.tgl_pesan, t.batas_transaksi, t.bukti_pembayaran, p.id_status, p.id_pemesanan
            from transaksi t
            inner join pemesanan p
                on p.id_pemesanan = t.id_pemesanan
            left join kegiatan k
                on k.id = p.id_kegiatan
            left join pengguna pg
                on pg.id = p.id_pengguna
            left join ormawa o
                on k.ormawa_id = o.id
            WHERE t.id_transaksi = $trx_id
        ");

        $data = collect($data)->first();

        DB::table('pemesanan')
            ->where('id_pemesanan', $data->id_pemesanan)
            ->update([
                'id_status' => 3
            ]);

        $this->message("success", "Berhasil dikonfirmasi");
        return redirect('ormawa/pemesanan/detail/' . $trx_id);
    }
    public function unconfirm($trx_id)
    {
        $data = DB::select("SELECT 
                t.id_transaksi as transaksi_id, pg.name as nama_peserta, k.nama as nama_kegiatan, p.tgl_pesan, t.batas_transaksi, t.bukti_pembayaran, p.id_status, p.id_pemesanan
            from transaksi t
            inner join pemesanan p
                on p.id_pemesanan = t.id_pemesanan
            left join kegiatan k
                on k.id = p.id_kegiatan
            left join pengguna pg
                on pg.id = p.id_pengguna
            left join ormawa o
                on k.ormawa_id = o.id
            WHERE t.id_transaksi = $trx_id
        ");

        $data = collect($data)->first();

        DB::table('pemesanan')
            ->where('id_pemesanan', $data->id_pemesanan)
            ->update([
                'id_status' => 2
            ]);

        $this->message("success", "Berhasil dibatalakan");
        return redirect('ormawa/pemesanan/detail/' . $trx_id);
    }
}

<?php

namespace App\Http\Controllers\Ormawa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrmawaKetuaController extends Controller
{
    function __construct()
    {
        $this->title  = 'Ketua Ormawa';
        $this->prefix = 'ketua';
        $app_type     = 'ormawa';

        $this->root = $app_type . '/' . $this->prefix;
    }

    public function tambah()
    {
        $title           = $this->title;
        $prefix          = $this->prefix;
        $form_action_url = $this->root . '/tambah';

        return view('ormawa/pengguna/tambah_ketua', compact(
            'title',
            'form_action_url',
            'prefix'
        ));
    }

    public function prosesTambah(Request $request)
    {
        $penggunaID = Auth::guard('admin')->user()->id_pengguna;
        $data       = $request->input();

        $ormawa = DB::table('ormawa')->where('id_pengguna', $penggunaID)->first();
        $check_active_ormawa_ketua = DB::table('ormawa_ketua')
            ->where('id_ormawa', $ormawa->id_ormawa)
            ->where('status', 1)
            ->count();
        
        if ($check_active_ormawa_ketua == 0) {
            $status = 1;
        } else {
            if ($data['status'] == 1) {
                DB::table('ormawa_ketua')
                    ->update([
                        'status' => 0
                    ]);
            }

            $status = $data['status'];
        }

        $ketua_ormawa = [
            'nama_ketua'    => $data['nama_ketua'],
            'id_ormawa'     => $ormawa->id_ormawa,
            'periode'       => $data['periode'],
            'status'        => $status // aktif
        ];
        DB::table('ormawa_ketua')->insert($ketua_ormawa);

        $this->message("success", "Ketua Ormawa Berhasil Ditambahkan");
        return redirect('ormawa/pengguna/update');
    }

    public function edit($id)
    {
        $penggunaID = Auth::guard('admin')->user()->id_pengguna;

        $data = DB::table('ormawa_ketua')->where('id_ormawa_ketua', $id)->first();

        $title           = $this->title;
        $prefix          = $this->prefix;
        $form_action_url = $this->root . '/edit/' . $id;

        return view('ormawa/pengguna/update_ketua', compact(
            'data',
            'title',
            'form_action_url',
            'prefix'
        ));
    }

    public function prosesEdit($ketua_id, Request $request)
    {
        $penggunaID = Auth::guard('admin')->user()->id_pengguna;
        $data       = $request->input();

        $ormawa = DB::table('ormawa')->where('id_pengguna', $penggunaID)->first();

        $check_active_ormawa_ketua = DB::table('ormawa_ketua')
            ->where('id_ormawa', $ormawa->id_ormawa)
            ->where('status', 1)
            ->count();
        
        if ($check_active_ormawa_ketua == 0) {
            $status = 1;
        } else {
            if ($data['status'] == 1) {
                DB::table('ormawa_ketua')
                    ->update([
                        'status' => 0
                    ]);
            }

            $status = $data['status'];
        }

        $ketua_ormawa = [
            'nama_ketua'    => $data['nama_ketua'],
            'periode'       => $data['periode'],
            'status'        => $status // aktif
        ];
        DB::table('ormawa_ketua')
            ->where('id_ormawa_ketua', $ketua_id)
            ->update($ketua_ormawa);

        $this->message("success", "Perubahan berhasil disimpan!");
        return redirect('ormawa/pengguna/update');
    }

    public function prosesHapus($ketua_id)
    {
        DB::table('ormawa_ketua')
            ->where('id_ormawa_ketua', $ketua_id)
            ->delete();

        $this->message("success", "Berhasil di hapus!");
        return redirect('ormawa/pengguna/update');
    }
}

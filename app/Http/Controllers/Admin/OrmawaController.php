<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrmawaController extends Controller
{
    function __construct()
    {
        $this->title  = 'Ormawa';
        $this->prefix = 'ormawa';
        $app_type     = 'admin';

        $this->root = $app_type . '/' . $this->prefix;
    }

    public function index()
    {
        $data = DB::select("SELECT
                o.*, ok.nama_ketua, ok.periode
            FROM ormawa o
            inner join (
                select * from ormawa_ketua where status = 1
            ) ok
                on ok.ormawa_id = o.id
        ");

        $title  = $this->title;
        $prefix = $this->prefix;

        return view($this->root . '/index', compact(
            'data',
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

        return view($this->root . '/tambah', compact(
            'data',
            'title',
            'form_action_url',
            'prefix'
        ));
    }

    public function prosesTambah(Request $request)
    {
        $data = $request->input();

        unset($data['_token']);

        $data['password'] = bcrypt($data['username']);

        $periode_ketua = $data['periode_ketua'];
        $nama_ketua = $data['nama_ketua'];
        
        unset($data['nama_ketua']);
        unset($data['periode_ketua']);

        $data_pengguna = [
            'name'      => $data['nama'],
            'username'  => $data['username'],
            'password'  => bcrypt($data['username']),
            'hak_akses' => 'ormawa',
        ];
        $data['pengguna_id'] = DB::table('pengguna')->insertGetId($data_pengguna);

        $ormawa_id = DB::table('ormawa')->insertGetId($data);

        $ketua_ormawa = [
            'nama_ketua'    => $nama_ketua,
            'ormawa_id'     => $ormawa_id,
            'periode' => $periode_ketua,
            'status'        => 1 // aktif
        ];
        DB::table('ormawa_ketua')->insert($ketua_ormawa);

        $this->message("success", "Data berhasil disimpan!");
        return redirect($this->root);
    }

    public function edit($id)
    {
        $data = DB::table('ormawa')->where('id', $id)->first();

        $title           = $this->title;
        $prefix          = $this->prefix;
        $form_action_url = $this->root . '/edit/' . $id;

        return view($this->root . '/edit', compact(
            'data',
            'title',
            'form_action_url',
            'prefix'
        ));
    }

    public function prosesEdit($id, Request $request)
    {
        $data = $request->input();
        
        $data['password'] = bcrypt($data['username']);
        
        unset($data['_token']);

        $data_pengguna = [
            'name'      => $data['nama'],
            'username'  => $data['username'],
            'password'  => bcrypt($data['username']),
            'hak_akses' => 'ormawa',
        ];
        DB::table('pengguna')
            ->where('id', $data['pengguna_id'])
            ->update($data_pengguna);

        DB::table('ormawa')
            ->where('id', $id)
            ->update($data);
            
        $this->message("success", "Perubahan berhasil disimpan!");
        return redirect($this->root);
    }

    public function hapus($id)
    {
        $ormawa = DB::table('ormawa')->where('id', $id)->first();

        DB::table('ormawa')
            ->where('id', $id)
            ->delete();

        DB::table('pengguna')
            ->where('id', $ormawa->pengguna_id)
            ->delete();

        $this->message("success", "Data berhasil dihapus!");
        return redirect($this->root);
    }

    public function resetPassword($id)
    {
        $data = DB::table('ormawa')->where('id', $id)->first();

        DB::table('ormawa')
            ->where('id', $id)
            ->update([
                'password' => bcrypt($data->username)
            ]);

        $this->message("success", "Password berhasil direset!");
        return redirect($this->root);
    }

    public function detail($id, Request $request)
    {
        $data = DB::select("SELECT
                o.*, ok.nama_ketua
            FROM ormawa o
            inner join (
                select * from ormawa_ketua where status = 1
            ) ok
                on ok.ormawa_id = o.id
            where o.id = $id
        ");

        $data = collect($data)->first();
        
		$kegiatan = DB::select("SELECT 
                IF(k.tanggal > curdate(), 'Belum Terlaksana', 'Sudah Terlaksana') AS status,
				k.*,
				o.nama AS nama_ormawa,
				r.nama AS nama_ruangan
			FROM kegiatan k
			left join ormawa o
				on o.id = k.ormawa_id
			left join ruangan r
				on r.id = k.ruangan_id
            where k.ormawa_id = $id
        ");
        
        $ketuas = DB::table('ormawa_ketua')
            ->where('ormawa_id', $id);

        $tahun = empty($request->tahun) ? '' : $request->tahun;

        if (!empty($tahun)) {
            $ketuas = $ketuas->where('periode', $tahun);
        }

        $ketuas = $ketuas->get();

        $title           = $this->title;
        $prefix          = $this->prefix;
        $form_action_url = $this->root . '/edit/' . $id;

        return view($this->root . '/detail', compact(
            'data',
            'proker',
            'kegiatan',
            'ketuas',
            'tahun',
            'title',
            'form_action_url',
            'prefix'
        ));
    }
}

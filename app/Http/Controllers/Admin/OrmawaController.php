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
                on ok.id_ormawa = o.id_ormawa
        ");

        $title  = $this->title;
        $prefix = $this->prefix;

        return view($this->root . '/index', compact(
            'data',
            'title',
            'prefix'
        ));
    }

    public function tambah()
    {
        $title           = $this->title;
        $prefix          = $this->prefix;
        $form_action_url = $this->root . '/tambah';

        return view($this->root . '/tambah', compact(
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
            'password_md5'  => md5($data['username']),
            'hak_akses' => 'ormawa',
        ];
        unset($data['username']);
        unset($data['password']);

        $ormawa_id = DB::table('ormawa')->insertGetId($data);

        $data_pengguna['id_pengguna'] = $ormawa_id;
        
        $data['pengguna_id'] = DB::table('pengguna')->insertGetId($data_pengguna);

        $ketua_ormawa = [
            'nama_ketua'    => $nama_ketua,
            'id_ormawa'     => $ormawa_id,
            'periode'       => $periode_ketua,
            'status'        => 1 // aktif
        ];
        DB::table('ormawa_ketua')->insert($ketua_ormawa);

        DB::table('ormawa')
            ->where('id_ormawa', $ormawa_id)
            ->update([
                'id_pengguna' => $ormawa_id
            ]);

        $this->message("success", "Data berhasil disimpan!");
        return redirect($this->root);
    }

    public function edit($id)
    {
        $data = DB::table('ormawa')->where('id_ormawa', $id)->first();
        $pengguna = DB::table('pengguna')->where('id_pengguna', $id)->first();

        $title           = $this->title;
        $prefix          = $this->prefix;
        $form_action_url = $this->root . '/edit/' . $id;

        return view($this->root . '/edit', compact(
            'data',
            'pengguna',
            'title',
            'form_action_url',
            'prefix'
        ));
    }

    public function prosesEdit($id, Request $request)
    {
        $data = $request->input();
        
        unset($data['_token']);

        $data_pengguna = [
            'name'      => $data['nama'],
            'username'  => $data['username'],
            'password'  => bcrypt($data['username']),
            'password_md5'  => bcrypt($data['username']),
        ];

        unset($data['username']);
        unset($data['password']);

        DB::table('pengguna')
            ->where('id_pengguna', $data['id_pengguna'])
            ->update($data_pengguna);

        DB::table('ormawa')
            ->where('id_ormawa', $id)
            ->update($data);
            
        $this->message("success", "Perubahan berhasil disimpan!");
        return redirect($this->root);
    }

    public function hapus($id)
    {
        // $ormawa = DB::table('ormawa')->where('id_', $id)->first();

        DB::table('ormawa')
            ->where('id_ormawa', $id)
            ->delete();

        DB::table('pengguna')
            ->where('id_pengguna', $id)
            ->delete();

        $this->message("success", "Data berhasil dihapus!");
        return redirect($this->root);
    }

    public function resetPassword($id)
    {
        $pengguna = DB::table('pengguna')->where('id_pengguna', $id)->first();

        DB::table('pengguna')
            ->where('id_pengguna', $id)
            ->update([
                'password' => bcrypt($pengguna->username),
                'password_md5' => md5($pengguna->username),
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
                on ok.id_ormawa = o.id_ormawa
            where o.id_ormawa = $id
        ");

        $data = collect($data)->first();
        
		$kegiatan = DB::select("SELECT 
                IF(k.tanggal > curdate(), 'Belum Terlaksana', 'Sudah Terlaksana') AS status,
				k.*,
				o.nama AS nama_ormawa,
				r.nama AS nama_ruangan
			FROM kegiatan k
			left join ormawa o
				on o.id_pengguna = k.id_pengguna
			left join ruangan r
				on r.id_ruangan = k.id_ruangan
            where k.id_pengguna = $data->id_pengguna
        ");
        
        $ketuas = DB::table('ormawa_ketua')
            ->where('id_ormawa', $id);
        $pengguna = DB::table('pengguna')
            ->where('id_pengguna', $id)
            ->first();

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
            'kegiatan',
            'pengguna',
            'ketuas',
            'tahun',
            'title',
            'form_action_url',
            'prefix'
        ));
    }
}

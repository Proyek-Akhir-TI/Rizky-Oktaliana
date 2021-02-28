<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RuanganController extends Controller
{
    function __construct()
    {
        $this->title  = 'Ruangan';
        $this->prefix = 'ruangan';
        $app_type     = 'admin';

        $this->root = $app_type . '/' . $this->prefix;
    }

    public function index()
    {
        $data = DB::table('ruangan')->get();

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

        DB::table('ruangan')->insert($data);

        $this->message("success", "Data berhasil disimpan!");
        return redirect($this->root);
    }

    public function edit($id)
    {
        $data = DB::table('ruangan')->where('id_ruangan', $id)->first();

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
        
        unset($data['_token']);

        DB::table('ruangan')
            ->where('id_ruangan', $id)
            ->update($data);

        $this->message("success", "Perubahan berhasil disimpan!");
        return redirect($this->root);
    }

    public function hapus($id)
    {
        DB::table('ruangan')
            ->where('id_ruangan', $id)
            ->delete();

        $this->message("success", "Data berhasil dihapus!");
        return redirect($this->root);
    }

    public function resetPassword($id)
    {
        $data = DB::table('ruangan')->where('id', $id)->first();

        DB::table('ruangan')
            ->where('id', $id)
            ->update([
                'password' => bcrypt($data->username)
            ]);

        $this->message("success", "Password berhasil direset!");
        return redirect($this->root);
    }
}

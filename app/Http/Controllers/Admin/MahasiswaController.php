<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    function __construct()
    {
        $this->title  = 'Mahasiswa';
        $this->prefix = 'mahasiswa';
        $app_type     = 'admin';

        $this->root = $app_type . '/' . $this->prefix;
    }

    public function index()
    {
        $data = DB::table('mahasiswa')->get();

        $title  = $this->title;
        $prefix = $this->prefix;

        return view($this->root . '/index', compact(
            'data',
            'title',
            'form_action_url',
            'prefix'
        ));
    }

    public function hapus($id)
    {
        DB::table('mahasiswa')
            ->where('id', $id)
            ->delete();

        $this->message("success", "Data berhasil dihapus!");
        return redirect($this->root);
    }

    public function resetPassword($id)
    {
        $data = DB::table('mahasiswa')->where('id', $id)->first();

        DB::table('mahasiswa')
            ->where('id', $id)
            ->update([
                'password' => bcrypt($data->nim)
            ]);

        $this->message("success", "Password berhasil direset!");
        return redirect($this->root);
    }
}

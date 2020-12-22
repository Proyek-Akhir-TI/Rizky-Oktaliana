<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PenggunaController extends Controller
{
    function __construct()
    {
        $this->title  = 'Pengguna';
        $this->prefix = 'pengguna';
        $app_type     = 'admin';

        $this->root = $app_type . '/' . $this->prefix;
    }

    public function index()
    {
        $data = DB::table('pengguna')->get();

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
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
            're_password' => 'required|same:password'
        ]);

        $data = $request->input();

        $data['password'] = bcrypt($data['password']);

        unset($data['_token']);
        unset($data['re_password']);

        DB::table('pengguna')->insert($data);

        $this->message("success", "Data berhasil disimpan!");
        return redirect($this->root);
    }

    public function edit($id)
    {
        $data = DB::table('pengguna')->where('id', $id)->first();

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

        if (!empty($data['password'])) {
            $this->validate($request, [
                'username' => 'required',
                'password' => 'required',
                're_password' => 'required|same:password'
            ]);
            
            $data['password'] = bcrypt($data['password']);
            
            unset($data['re_password']);
        } else {
            unset($data['password']);
            unset($data['re_password']);
        }
        
        unset($data['_token']);

        DB::table('pengguna')
            ->where('id', $id)
            ->update($data);

        $this->message("success", "Perubahan berhasil disimpan!");
        return redirect($this->root);
    }

    public function hapus($id)
    {
        DB::table('pengguna')
            ->where('id', $id)
            ->delete();

        $this->message("success", "Data berhasil dihapus!");
        return redirect($this->root);
    }

    public function resetPassword($id)
    {
        $data = DB::table('pengguna')->where('id', $id)->first();

        DB::table('pengguna')
            ->where('id', $id)
            ->update([
                'password' => bcrypt($data->username)
            ]);

        $this->message("success", "Password berhasil direset!");
        return redirect($this->root);
    }

    public function ubah_password($id)
    {
        $data = DB::table('pengguna')->where('id', $id)->first();

        $title           = $this->title;
        $prefix          = $this->prefix;
        $form_action_url = $this->root . '/ubah_password/' . $id;

        return view($this->root . '/ubah_password', compact(
            'data',
            'title',
            'form_action_url',
            'prefix'
        ));
    }

    public function prosesUbahPassword($id, Request $request)
    {
        $data = $request->input();

        if (!empty($data['password'])) {
            $this->validate($request, [
                'password' => 'required',
                're_password' => 'required|same:password'
            ]);
            
            $data['password'] = bcrypt($data['password']);
            
            unset($data['re_password']);
        } else {
            unset($data['password']);
            unset($data['re_password']);
        }
        
        unset($data['_token']);

        DB::table('pengguna')
            ->where('id', $id)
            ->update($data);

        $this->message("success", "Perubahan berhasil disimpan!");
        return redirect('admin/dashboard');
    }
}

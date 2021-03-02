<?php

namespace App\Http\Controllers\Wadir;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PenggunaController extends Controller
{
    function __construct()
    {
        $this->title  = 'Pengguna';
        $this->prefix = 'pengguna';
        $app_type     = 'wadir';

        $this->root = $app_type . '/' . $this->prefix;
    }

    public function ubah_password($id)
    {
        $data = DB::table('pengguna')->where('id_pengguna', $id)->first();

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
            ->where('id_pengguna', $id)
            ->update($data);

        $this->message("success", "Perubahan berhasil disimpan!");
        return redirect('admin/dashboard');
    }
}

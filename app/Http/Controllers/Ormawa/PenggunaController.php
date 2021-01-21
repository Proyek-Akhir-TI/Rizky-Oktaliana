<?php

namespace App\Http\Controllers\Ormawa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenggunaController extends Controller
{
    function __construct()
    {
        $this->title  = 'Pengguna';
        $this->prefix = 'pengguna';
        $app_type     = 'ormawa';

        $this->root = $app_type . '/' . $this->prefix;
    }

    public function update()
    {
        $penggunaID = Auth::guard('admin')->user()->id;

        $data = DB::select("SELECT 
                o.*, p.username
            FROM ormawa o
            inner join pengguna p
                on p.id = o.pengguna_id
            where o.pengguna_id = $penggunaID
        ");

        $data = collect($data)->first();

        $ormawa_ketua = DB::table('ormawa_ketua')->where('ormawa_id', $data->id)->get();

        $title           = $this->title;
        $prefix          = $this->prefix;
        $form_action_url = $this->root . '/update/';

        return view($this->root . '/update', compact(
            'data',
            'ormawa_ketua',
            'title',
            'form_action_url',
            'prefix'
        ));
    }

    public function prosesUpdate(Request $request)
    {
        $penggunaID = Auth::guard('admin')->user()->id;
        $data       = $request->input();

        $request->validate([
            'foto' => 'max:20480',
        ]);

        $ormawa_data = [
            'username'   => $data['username'],
            'no_hp'   => $data['no_hp'],
        ];

        if (!empty($request->foto)) {
            $ormawa_data['foto'] = time() . '.' . $request->foto->extension();

            $request->foto->move(public_path('uploads/logo'), $ormawa_data['foto']);
        }
        DB::table('ormawa')
            ->where('pengguna_id', $penggunaID) 
            ->update($ormawa_data);

        $pengguna_data = [
            'username' => $data['username'],
        ];
        DB::table('pengguna')
            ->where('id', $penggunaID)
            ->update($pengguna_data);

        $this->message("success", "Perubahan berhasil disimpan!");
        return redirect('ormawa/pengguna/update');
    }

    public function updatePassword()
    {
        $penggunaID = Auth::guard('admin')->user()->id;
        $data = DB::table('pengguna')->where('id', $penggunaID)->first();

        $title           = $this->title;
        $prefix          = $this->prefix;
        $form_action_url = $this->root . '/update_password';

        return view($this->root . '/update_password', compact(
            'data',
            'title',
            'form_action_url',
            'prefix'
        ));
    }

    public function prosesUpdatePassword(Request $request)
    {
        $penggunaID = Auth::guard('admin')->user()->id;
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
            ->where('id', $penggunaID)
            ->update($data);

        $this->message("success", "Password berhasil direset!");
        return redirect('ormawa/pengguna/update_password');
    }
}

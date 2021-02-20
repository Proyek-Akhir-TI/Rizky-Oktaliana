<?php

namespace App\Http\Controllers\Ormawa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BankController extends Controller
{
    function __construct()
    {
        $this->title  = 'Bank';
        $this->prefix = 'bank';
        $app_type     = 'ormawa';

        $this->root = $app_type . '/' . $this->prefix;
    }

    public function index()
    {
        $penggunaID = Auth::guard('admin')->user()->id;

        $data = DB::select("SELECT 
            bu.*, b.nama_bank
            from bank_user bu
            left join bank b
                on b.id_bank = bu.`id_bank`
            WHERE bu.id_pengguna = $penggunaID
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

        $banks = DB::table('bank')->get();

        return view($this->root . '/tambah', compact(
            'banks',
            'title',
            'form_action_url',
            'prefix'
        ));
    }

    public function prosesTambah(Request $request)
    {
        $data = $request->input();
        $penggunaID = Auth::guard('admin')->user()->id;

        unset($data['_token']);

        $data['id_pengguna'] = $penggunaID;

        DB::table('bank_user')->insert($data);

        $this->message("success", "Data berhasil disimpan!");
        return redirect($this->root);
    }

    public function edit($id)
    {
        $data = DB::table('bank_user')->where('id_bankuser', $id)->first();

        $banks = DB::table('bank')->get();

        $title           = $this->title;
        $prefix          = $this->prefix;
        $form_action_url = $this->root . '/edit/' . $id;

        return view($this->root . '/edit', compact(
            'banks',
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

        DB::table('bank_user')
            ->where('id_bankuser', $id)
            ->update($data);

        $this->message("success", "Perubahan berhasil disimpan!");
        return redirect($this->root);
    }

    public function hapus($id)
    {
        DB::table('bank_user')
            ->where('id_bankuser', $id)
            ->delete();

        $this->message("success", "Data berhasil dihapus!");
        return redirect($this->root);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;  
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function getLogin()
    {
        return view('login');
    }

    public function postLogin(Request $request)
    {
        // Validate the form data
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        // Attempt to log the user in
        // Passwordnya pake bcrypt
        if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password])) {
            if (Auth::guard('admin')->user()->hak_akses == "admin") {
                return redirect()->intended('/admin/dashboard');
            } elseif (Auth::guard('admin')->user()->hak_akses == "wadir") {
                return redirect()->intended('/wadir/dashboard');
            } elseif (Auth::guard('admin')->user()->hak_akses == "mahasiswa") {
                return redirect()->intended('/mahasiswa/dashboard');
            } else {
                return redirect()->intended('/ormawa/dashboard');
            }
        }
        
        $this->message("warning", "Periksa username dan password");
        return redirect('/login');
    }

    public function register()
    {
        $data['prodi'] = DB::table('prodi')->get();

        return view('register', $data);
    }

    public function doRegister(Request $request)
    {
        $data = $this->validate($request, [
            'reenter_password' => 'required|same:password'
        ]);

        $data = $request->input();

        $data_pengguna = [
            'name'      => $data['nama'],
            'username'  => $data['nim'],
            'password'  => Hash::make($data['password']),
            'hak_akses' => 'mahasiswa',
        ];
        
        $data['pengguna_id'] = DB::table('pengguna')->insertGetId($data_pengguna);

        unset($data['_token']);
        unset($data['password']);
        unset($data['reenter_password']);

        DB::table('mahasiswa')->insert($data);
        
        $this->message("success", "Pendaftaran berhasil, silahkan login untuk memasuki aplikasi");
        return redirect('login');
    }

    public function logout()
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        return redirect('/login');
    }
}

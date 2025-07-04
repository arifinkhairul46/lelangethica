<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function register()
    {
        $role = Role::all();
        return view('auth.register', compact('role'));
    }

    public function customRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'role' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $check = $this->create($data);
        // dd($check);

        return redirect("login")->withSuccess('Registrasi Kamu Berhasil');
    }

    public function create(array $data)
    {
        try {
            return User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role_id' => $data['role'],
                'no_hp' => $data['no_hp'],
                'nama_toko' => $data['nama_toko']

            ]);
        } catch (\Exception $th) {
            // dd($th);
        }
    }

    public function customLogin(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);


            $user  = User::where('username', $request->username)->first();

            if ($user->role_id == 1 ) {
                if (Hash::check($request->password, $user->password)) {
                    $request->session()->regenerate();

                    Auth::login($user);

                    return redirect()->route('admin.index');
                } else {
                    return redirect()->route('login')->with('error', 'No Hp atau password salah');
                }
            } else {
                if (Hash::check($request->password, $user->password)) {
                    $request->session()->regenerate();

                    Auth::login($user);

                    return redirect()->route('index');
                } else {
                    return redirect()->route('login')->with('error', 'No Hp atau password salah');
                }
            }
        } catch (\Exception $th) {
            // dd($th);
            return redirect("login")->withError($th->getMessage());
        }
    }

       public function logout()
    {
        session()->flush();
        Auth::logout();
        return redirect()->route('login');
    }


}

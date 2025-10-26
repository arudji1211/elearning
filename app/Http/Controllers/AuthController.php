<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    private UserServices $user_services;

    public function __construct(UserServices $usersvc)
    {
        $this->user_services = $usersvc;
    }
    //
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        $roles = Role::all();

        return view('auth.register', compact('roles'));
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $request->session()->regenerate();

            if ($user->role->title == 'admin') {
                $data = [
                    'type' => 'login',
                    'user_id' => $user->id,
                ];
                $this->user_services->CreateuserActivity($data);
                return redirect()->intended('admin');
            }else if($user->role->title == 'student'){
                $data = [
                    'type' => 'login',
                    'user_id' => $user->id,
                ];
                $this->user_services->CreateuserActivity($data);
                return redirect()->intended('student');
            }
        }

        return back()->with('error', 'Email atau password salah!');
    }

    public function Registerme(Request $request)
    {
        $validate = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string',
            'role' => 'required|exists:roles,id',
            'password' => 'required|string',
        ]);

        try {
            // code...
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'password' => Hash::make($request->password),
                'role_id' => $request->role,
            ]);

        } catch (\Throwable $th) {
            // throw $th;
            return redirect()->back()->withErrors(['error_details' => $th->getMessage()]);

        }

        return redirect()->route('login');
    }
}

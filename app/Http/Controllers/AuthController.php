<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function index()
    {
        return view('auth.index');
    }

    /**
     * Proses login
     */
  public function login(Request $request)
{
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $user = Auth::user()->load('role.menus');
        $role = $user->role;

        session([
            'user_data' => [
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $role?->name ?? '-',
                'menus' => $role?->menus->pluck('name')->toArray() ?? [],
            ]
        ]);

        // ADMIN
        if ($role->name == 'admin') {
            return redirect()->route('dashboard');
        }

        // PETUGAS
        if ($role->name == 'petugas') {
         return redirect()->route('petugas.dashboard');
        }

        // USER / PEMINJAM (masuk ke sidebar user)
        return redirect()->route('products.index');
        // atau kalau mau langsung katalog:
        // return redirect()->route('playstation.index');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->withInput();
}



    /**
     * Tampilkan halaman register
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Proses register (FINAL UKK)
     * Role otomatis = PEMINJAM
     */
    public function store(Request $request)
{
    $request->validate([
        'name'     => 'required|string|max:100',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
    ]);

    // ambil role peminjam
    $peminjamRole = Role::where('name', 'peminjam')->firstOrFail();

    // simpan user
    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'role_id'  => $peminjamRole->id,
    ]);

    // 🔥 AUTO LOGIN
    Auth::login($user);

    // 🔥 REDIRECT KE LANDING / PRODUCTS
    return redirect()->route('products.index')
        ->with('success', 'Registrasi berhasil! Selamat datang 🎮');
}

    /**
     * Logout
     */
  public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('landing'); // 🔥 ke landing
}
}

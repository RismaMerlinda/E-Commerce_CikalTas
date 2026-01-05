<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return redirect()->route('login')->with('status', 'Pendaftaran berhasil! Silakan login.');

    }
public function showStep2()
{
    if (!Session::has('register_step1')) {
        return redirect()->route('register')->with('error', 'Selesaikan Step 1 dulu.');
    }
    return view('auth.register_alamat');
}


public function storeStep2(Request $request): RedirectResponse
{
    // Validasi alamat
    $request->validate([
        'nomor_telepon' => 'required|digits_between:8,15',
        'provinsi_kota' => 'required|string|max:255',
        'alamat_jalan' => 'required|string|max:255',
        'detail_lainnya' => 'nullable|string|max:255',
    ]);

    // Ambil user terakhir yang baru daftar (gunakan session)
    $userId = session('user_id');
    if (!$userId) {
        return redirect()->route('register')->with('error', 'Silakan daftar terlebih dahulu.');
    }

    $user = User::findOrFail($userId);

    $user->update([
        'nomor_telepon' => $request->nomor_telepon,
        'provinsi_kota' => $request->provinsi_kota,
        'alamat_jalan' => $request->alamat_jalan,
        'detail_lainnya' => $request->detail_lainnya,
    ]);

    // Hapus session sementara
    session()->forget('user_id');

    // Redirect ke login
    return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login.');
}

}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RegisterStepController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | STEP 1: TAMPILKAN FORM
    |--------------------------------------------------------------------------
    */
    public function showStep1()
    {
        return view('auth.register');
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 1: SIMPAN DATA AKUN SEMENTARA
    |--------------------------------------------------------------------------
    */
    public function step1(Request $request)
    {
        // Log untuk debugging
        Log::info('Register Step 1 called', [
            'data' => $request->all(),
            'session_id' => session()->getId(),
            'csrf_token' => $request->session()->token()
        ]);

        try {
            $request->validate([
                'nama_lengkap' => 'required|string|max:255',
                'email'        => 'required|email|unique:users,email',
                'password'     => 'required|min:6',
                'password_confirmation' => 'required|same:password',
            ]);

            // Simpan data ke session untuk step 2
            Session::put('register_step1', [
                'nama_lengkap' => $request->nama_lengkap,
                'email'        => $request->email,
                'password'     => $request->password,
            ]);

            return redirect()->route('register.step2');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Register Step 1 Error', ['error' => $e->getMessage()]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 2: TAMPILKAN FORM ALAMAT
    |--------------------------------------------------------------------------
    */
    public function showStep2()
    {
        // Pastikan data step 1 sudah ada di session
        if (!Session::has('register_step1')) {
            return redirect()->route('register')->with('error', 'Selesaikan Step 1 dulu.');
        }

        return view('auth.register_alamat');
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 2: SIMPAN ALAMAT & REGISTER USER
    |--------------------------------------------------------------------------
    */
    public function step2(Request $request)
    {
        // Log untuk debugging
        Log::info('Register Step 2 called', [
            'data' => $request->all(),
            'session_step1' => Session::get('register_step1')
        ]);

        try {
            $request->validate([
                'nomor_telepon' => 'required|string|max:20',
                'provinsi_kota' => 'required|string|max:100',
                'alamat_jalan'  => 'required|string|max:255',
                'detail_lainnya' => 'nullable|string|max:255'
            ]);

            // Ambil data step 1
            $step1 = Session::get('register_step1');

            if (!$step1) {
                return redirect()->route('register')
                    ->with('error', 'Session expired. Silakan ulangi registrasi dari awal.');
            }

            // Simpan user
            $user = User::create([
                'nama_lengkap' => $step1['nama_lengkap'],
                'email'        => $step1['email'],
                'password'     => Hash::make($step1['password']),

                // STEP 2
                'nomor_telepon' => $request->nomor_telepon,
                'provinsi_kota' => $request->provinsi_kota,
                'alamat_jalan'  => $request->alamat_jalan,
                'detail_lainnya' => $request->detail_lainnya,
            ]);

            // Hapus session step 1
            Session::forget('register_step1');

            // TIDAK auto-login lagi, redirect ke halaman login
            // Auth::login($user);

            Log::info('Register completed successfully', ['user_id' => $user->id]);

            return redirect()->route('login')
                ->with('success', 'Pendaftaran berhasil! Silakan login untuk melanjutkan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Register Step 2 Error', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'role' => 'required|in:programmer,umkm,course',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
        ];

        $messages = [
            'name.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'password.min' => 'Password minimal 6 karakter',
            'ktp_number.required' => 'Nomor KTP wajib diisi',
            'ktp_number.numeric' => 'Nomor KTP harus berupa angka',
            'ktp_number.digits' => 'Nomor KTP harus tepat 16 digit',
            'ktp_photo.required' => 'Foto KTP wajib diunggah',
            'ktp_photo.image' => 'Foto KTP harus berupa gambar (jpeg, png, jpg)',
            'ktp_photo.max' => 'Ukuran foto KTP maksimal 2MB',
            'business_photo.required' => 'Foto bukti tempat usaha wajib diunggah',
            'business_photo.image' => 'Foto tempat usaha harus berupa gambar (jpeg, png, jpg)',
            'business_photo.max' => 'Ukuran foto tempat usaha maksimal 2MB',
            'cv_file.required' => 'Dokumen CV (Curriculum Vitae) wajib diunggah',
            'cv_file.mimes' => 'Dokumen CV harus berformat PDF, DOC, atau DOCX',
            'cv_file.max' => 'Ukuran dokumen CV maksimal 3MB',
            'certificate_file.required' => 'Sertifikat Pertama wajib diunggah',
            'certificate_file.mimes' => 'Sertifikat Pertama harus berformat PDF atau Gambar (jpg, jpeg, png)',
            'certificate_file.max' => 'Ukuran file sertifikat pertama maksimal 3MB',
            'certificate_name.required' => 'Nama Sertifikat Pertama wajib diisi',
            'certificate_issuer.required' => 'Penerbit Sertifikat wajib diisi',
            'certificate_date.required' => 'Tanggal Terbit Sertifikat wajib diisi',
            'certificate_date.date' => 'Format Tanggal Terbit Sertifikat tidak valid',
            'bio.required' => 'Bio / Deskripsi Diri wajib diisi',
            'bio.min' => 'Bio / Deskripsi Diri minimal 20 karakter',
            'expertise.required' => 'Keahlian wajib diisi',
        ];

        if ($request->role === 'umkm') {
            $rules['business_name'] = 'required|string|max:255';
            $rules['ktp_number'] = 'required|numeric|digits:16';
            $rules['ktp_photo'] = 'required|image|max:2048';
            $rules['business_photo'] = 'required|image|max:2048';
        }

        if ($request->role === 'programmer') {
            $rules['ktp_number'] = 'required|numeric|digits:16';
            $rules['ktp_photo'] = 'required|image|max:2048';
            $rules['cv_file'] = 'required|mimes:pdf,doc,docx|max:3072';
            $rules['certificate_file'] = 'required|mimes:pdf,jpg,jpeg,png|max:3072';
            $rules['certificate_name'] = 'required|string|max:255';
            $rules['certificate_issuer'] = 'required|string|max:255';
            $rules['certificate_date'] = 'required|date';
            $rules['bio'] = 'required|string|min:20';
            $rules['expertise'] = 'required|string|max:255';
        }

        $request->validate($rules, $messages);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'city' => $request->city,
        ];

        if ($request->role === 'umkm') {
            $userData['business_name'] = $request->business_name;
            $userData['business_type'] = $request->business_type;
            $userData['ktp_number'] = $request->ktp_number;
            
            if ($request->hasFile('ktp_photo')) {
                $userData['ktp_photo'] = $request->file('ktp_photo')->store('verification/ktp', 'public');
            }
            if ($request->hasFile('business_photo')) {
                $userData['business_photo'] = $request->file('business_photo')->store('verification/business', 'public');
            }
        }

        if ($request->role === 'programmer') {
            $userData['ktp_number'] = $request->ktp_number;
            $userData['bio'] = $request->bio;
            $userData['expertise'] = $request->expertise;
            
            if ($request->hasFile('ktp_photo')) {
                $userData['ktp_photo'] = $request->file('ktp_photo')->store('verification/ktp', 'public');
            }
            if ($request->hasFile('cv_file')) {
                $userData['cv_file'] = $request->file('cv_file')->store('verification/cv', 'public');
            }
        }

        if ($request->role === 'course') {
            $userData['expertise'] = $request->expertise;
        }

        $user = User::create($userData);

        if ($user->role === 'programmer' && $request->hasFile('certificate_file')) {
            $path = $request->file('certificate_file')->store('verification/certificates', 'public');
            \App\Models\Certificate::create([
                'programmer_id' => $user->id,
                'name' => $request->certificate_name,
                'issuer' => $request->certificate_issuer,
                'issue_date' => $request->certificate_date,
                'certificate_file' => $path,
                'status' => 'pending',
            ]);
        }

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Akun berhasil dibuat! Selamat bergabung di BuilderHub.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Anda telah berhasil keluar.');
    }

    public function dashboard()
    {
        $user = Auth::user();
        return match($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'programmer' => redirect()->route('programmer.dashboard'),
            'umkm' => redirect()->route('umkm.dashboard'),
            'course' => redirect()->route('course.dashboard'),
            default => redirect()->route('home'),
        };
    }
}

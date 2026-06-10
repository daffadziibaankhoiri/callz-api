<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use App\Http\Requests\Auth\MitraRegisterRequest;
use App\Http\Requests\Auth\MitraLoginRequest;
use App\Http\Resources\MitraResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;      
use Illuminate\Support\Facades\Storage;

class MitraAuthController extends Controller
{
    public function register(MitraRegisterRequest $request)
    {
        $mitra = Mitra::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => Hash::make($request->password),
        ]);

        $token = auth('mitra')->login($mitra);

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil',
            'token'   => $token,
            'mitra'   => new MitraResource($mitra),
        ], 201);
    }

    public function login(MitraLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth('mitra')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'token'   => $token,
            'mitra'   => new MitraResource(auth('mitra')->user()), // Menggunakan user() bawaan guard
        ]);
    }

    public function logout()
    {
        auth('mitra')->logout();
        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ]);
    }

    public function me()
    {
        return response()->json([
            'success' => true,
            'mitra'   => new MitraResource(auth('mitra')->user()), // Menggunakan user() bawaan guard
        ]);
    }
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $mitra = auth('mitra')->user();

        if ($mitra->avatar && Storage::disk('public')->exists($mitra->avatar)) {
            Storage::disk('public')->delete($mitra->avatar);
        }

        $path = $request->file('avatar')->store('avatars/mitras', 'public');

        $mitra->update(['avatar' => $path]);

        return response()->json([
            'success' => true,
            'message' => 'Foto profil berhasil diperbarui',
            'avatar'  => asset('storage/' . $path),
        ]);
    }
    public function updateLocation(Request $request)
    {
        $request->validate([
            'latitude'  => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $mitra = auth('mitra')->user();

        $mitra->update([
            'latitude'  => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Lokasi berhasil diperbarui',
            'latitude'  => $mitra->latitude,
            'longitude' => $mitra->longitude,
        ]);
    }
}
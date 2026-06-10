<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Http\Requests\Auth\AdminRegisterRequest;
use App\Http\Requests\Auth\AdminLoginRequest;
use App\Http\Resources\AdminResource;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function register(AdminRegisterRequest $request)
    {
        // Pastikan di file AdminRegisterRequest sudah diganti menjadi 'unique:admins,email'
        $admin = Admin::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => Hash::make($request->password),
        ]);

        $token = auth('admin')->login($admin);

        return response()->json([
            'success' => true,
            'message' => 'Registrasi Admin berhasil',
            'token'   => $token,
            'admin'   => new AdminResource($admin),
        ], 201);
    }

    public function login(AdminLoginRequest $request)
    {
        // Mengambil email dan password dari input yang divalidasi
        $credentials = $request->only('email', 'password');

        // Melakukan autentikasi menggunakan guard 'admin'
        if (!$token = auth('admin')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password Admin salah',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login Admin berhasil',
            'token'   => $token,
            'admin'   => new AdminResource(auth('admin')->user()),
        ]);
    }
    public function logout()
    {
        auth('admin')->logout();
        return response()->json([
            'success' => true,
            'message' => 'Admin berhasil logout',
        ]);
    }

    public function me()
    {
        return response()->json([
            'success' => true,
            'admin'   => new AdminResource(auth('admin')->user()),
        ]);
    }
}
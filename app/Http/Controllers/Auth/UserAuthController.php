<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Auth\UpdateUserProfileRequest;

class UserAuthController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => Hash::make($request->password),
        ]);

        $token = auth('user')->login($user);

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil',
            'token'   => $token,
            'user'    => new UserResource($user),
        ], 201);
    }

    public function login(UserLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth('user')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'token'   => $token,
            'user'    => new UserResource(auth('user')->user()),
        ]);
    }

    public function logout()
    {
        auth('user')->logout();
        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ]);
    }

    public function me()
    {
        return response()->json([
            'success' => true,
            'user'    => new UserResource(auth('user')->user()),
        ]);
    }
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = auth('user')->user();

        // Hapus avatar lama kalau bukan default
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Simpan avatar baru
        $path = $request->file('avatar')->store('avatars/users', 'public');

        $user->update(['avatar' => $path]);

        return response()->json([
            'success' => true,
            'message' => 'Foto profil berhasil diperbarui',
            'avatar'  => asset('storage/' . $path),
        ]);
    }
    public function update(UpdateUserProfileRequest $request)
    {
        // Mengambil data user yang sedang login dari token session
        $user = auth('user')->user();

        // Hanya memperbarui field yang lolos validasi di Request
        $user->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
            'user'    => new UserResource($user), // Mengembalikan data user terbaru yang sudah rapi
        ]);
    }
    public function updateLocation(Request $request)
    {
        $request->validate([
            'latitude'  => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $user = auth('user')->user();

        $user->update([
            'latitude'  => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Lokasi berhasil diperbarui',
            'latitude'  => $user->latitude,
            'longitude' => $user->longitude,
        ]);
    }
}
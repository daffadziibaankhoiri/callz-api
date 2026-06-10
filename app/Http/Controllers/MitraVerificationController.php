<?php

namespace App\Http\Controllers;

use App\Models\MitraVerification;
use App\Http\Requests\MitraVerificationRequest;
use App\Http\Resources\MitraVerificationResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MitraVerificationController extends Controller
{
    // [MITRA] Submit dokumen verifikasi
    // Kalau sudah pernah submit, update dokumennya (kasus resubmit setelah REJECTED)
    public function store(MitraVerificationRequest $request)
    {
        $mitra = auth('mitra')->user();

        $existing = MitraVerification::where('mitra_id', $mitra->id)->first();

        // Mitra yang sudah APPROVED tidak boleh submit ulang
        if ($existing && $existing->status === 'APPROVED') {
            return response()->json([
                'success' => false,
                'message' => 'Verifikasi kamu sudah disetujui, tidak perlu submit ulang.',
            ], 400);
        }

        // Hapus file lama kalau resubmit
        if ($existing) {
            Storage::disk('public')->delete($existing->foto_ktp);
            Storage::disk('public')->delete($existing->foto_sim);
        }

        $ktpPath = $request->file('foto_ktp')->store('verifications/ktp', 'public');
        $simPath = $request->file('foto_sim')->store('verifications/sim', 'public');

        $verification = MitraVerification::updateOrCreate(
            ['mitra_id' => $mitra->id],
            [
                'foto_ktp'       => $ktpPath,
                'foto_sim'       => $simPath,
                'status'         => 'PENDING',
                'rejection_note' => null, // Reset catatan rejection lama
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Dokumen verifikasi berhasil dikirim. Mohon tunggu proses review dari admin.',
            'data'    => new MitraVerificationResource($verification->load('mitra')),
        ], 201);
    }

    // [MITRA] Cek status verifikasi miliknya sendiri
    public function myStatus()
    {
        $verification = MitraVerification::where('mitra_id', auth('mitra')->id())
            ->first();

        if (!$verification) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu belum pernah mengajukan verifikasi.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => new MitraVerificationResource($verification),
        ]);
    }

    // [ADMIN] Get semua pengajuan verifikasi
    public function index(Request $request)
    {
        $query = MitraVerification::with('mitra');

        if ($request->has('status')) {
            $query->where('status', strtoupper($request->status));
        }

        $verifications = $query->latest()->get();

        return response()->json([
            'success' => true,
            'data'    => MitraVerificationResource::collection($verifications),
        ]);
    }

    // [ADMIN] Get detail satu pengajuan
    public function show(string $id)
    {
        $verification = MitraVerification::with('mitra')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => new MitraVerificationResource($verification),
        ]);
    }

    // [ADMIN] Update status verifikasi (APPROVED / REJECTED)
    public function updateStatus(Request $request, string $id)
    {
        $request->validate([
            'status'         => 'required|in:APPROVED,REJECTED',
            'rejection_note' => 'required_if:status,REJECTED|nullable|string|max:500',
        ]);

        $verification = MitraVerification::findOrFail($id);

        if ($verification->status === 'APPROVED') {
            return response()->json([
                'success' => false,
                'message' => 'Verifikasi ini sudah disetujui sebelumnya.',
            ], 400);
        }

        $verification->update([
            'status'         => $request->status,
            'rejection_note' => $request->status === 'REJECTED' ? $request->rejection_note : null,
        ]);

        $message = $request->status === 'APPROVED'
            ? 'Verifikasi mitra berhasil disetujui.'
            : 'Verifikasi mitra ditolak.';

        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => new MitraVerificationResource($verification->load('mitra')),
        ]);
    }
}
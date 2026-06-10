<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskRating;
use App\Models\Mitra;
use App\Models\User;
use App\Http\Requests\StoreRatingRequest;
use Illuminate\Http\Request;

class TaskRatingController extends Controller
{
    // 1. Fitur: User memberikan rating kepada Mitra
    public function rateMitra(StoreRatingRequest $request, string $taskId)
    {
        $task = Task::where('user_id', auth('user')->id())
                    ->where('status', 'COMPLETED')
                    ->findOrFail($taskId);

        $rating = TaskRating::updateOrCreate(
            ['task_id' => $task->id],
            [
                'user_id'     => $task->user_id,
                'mitra_id'    => $task->mitra_id,
                'user_rating' => $request->rating,
                'user_review' => $request->review,
            ]
        );

        // Recalculate dan update average rating mitra
        $this->updateMitraRating($task->mitra_id);

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih, ulasan untuk mitra berhasil disimpan!',
            'data'    => $rating
        ]);
    }

    // 2. Fitur: Mitra memberikan rating kepada User
    public function rateUser(StoreRatingRequest $request, string $taskId)
    {
        $task = Task::where('mitra_id', auth('mitra')->id())
                    ->where('status', 'COMPLETED')
                    ->findOrFail($taskId);

        $rating = TaskRating::updateOrCreate(
            ['task_id' => $task->id],
            [
                'user_id'      => $task->user_id,
                'mitra_id'     => $task->mitra_id,
                'mitra_rating' => $request->rating,
                'mitra_review' => $request->review,
            ]
        );

        // Recalculate dan update average rating user
        $this->updateUserRating($task->user_id);

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih, ulasan untuk pelanggan berhasil disimpan!',
            'data'    => $rating
        ]);
    }

    // 3. Fitur: Menampilkan data review/rating dari suatu tugas
    public function showRating(string $taskId)
    {
        $rating = TaskRating::with(['user', 'mitra'])
            ->where('task_id', $taskId)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data'    => $rating
        ]);
    }

    // ==========================================
    // PRIVATE HELPERS — Average Rating Calculator
    // ==========================================

    // Hitung ulang rata-rata user_rating untuk mitra tertentu
    // lalu simpan hasilnya ke kolom rating di tabel mitras
    private function updateMitraRating(int $mitraId): void
    {
        // avg() otomatis mengabaikan baris yang nilai user_rating-nya NULL
        // jadi mitra yang belum pernah dirating tidak akan terhitung
        $average = TaskRating::where('mitra_id', $mitraId)
            ->whereNotNull('user_rating')
            ->avg('user_rating');

        Mitra::where('id', $mitraId)->update([
            'rating' => $average ? round($average, 2) : null
        ]);
    }

    // Hitung ulang rata-rata mitra_rating untuk user tertentu
    // lalu simpan hasilnya ke kolom rating di tabel users
    private function updateUserRating(int $userId): void
    {
        $average = TaskRating::where('user_id', $userId)
            ->whereNotNull('mitra_rating')
            ->avg('mitra_rating');

        User::where('id', $userId)->update([
            'rating' => $average ? round($average, 2) : null
        ]);
    }
}
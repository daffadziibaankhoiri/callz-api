<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    // 1. Index
    public function index(Request $request)
    {
        $tasks = Task::with(['packageCategory', 'user', 'mitra']);

        if (auth('user')->check()) {
            $tasks->where('user_id', auth('user')->id());
        } elseif (auth('mitra')->check()) {
            $tasks->whereIn('status', ['PENDING', 'SEARCHING']);
        }

        return TaskResource::collection($tasks->latest()->get());
    }

    // 1a. Riwayat User
    public function userHistory(Request $request)
    {
        $tasks = Task::with(['packageCategory', 'user', 'mitra', 'rating'])
            ->where('user_id', auth('user')->id())
            ->latest()
            ->get();

        return TaskResource::collection($tasks);
    }

    // 1b. Riwayat Mitra
    public function mitraHistory(Request $request)
    {
        $tasks = Task::with(['packageCategory', 'user', 'mitra'])
            ->where('mitra_id', auth('mitra')->id())
            ->latest()
            ->get();

        return TaskResource::collection($tasks);
    }

    // 2. Store (User)
    public function store(TaskRequest $request)
    {
        $task = Task::create([
            'user_id'               => auth('user')->id(),
            'package_category_id'   => $request->package_category_id,
            'job_category_id'       => $request->job_category_id,      // ini yang kurang
            'pickup_address'        => $request->pickup_address,
            'pickup_latitude'       => $request->pickup_latitude,
            'pickup_longitude'      => $request->pickup_longitude,
            'destination_address'   => $request->destination_address,
            'destination_latitude'  => $request->destination_latitude,
            'destination_longitude' => $request->destination_longitude,
            'location_notes'        => $request->location_notes,
            'title'                 => $request->title,
            'instruction_detail'    => $request->instruction_detail,
            'receiver_name'         => $request->receiver_name,
            'receiver_phone'        => $request->receiver_phone,
            'base_fee'              => $request->base_fee,
            'job_category_fee'      => $request->job_category_fee,
            'distance_km'           => $request->distance_km,
            'distance_fee'          => $request->distance_fee,
            'tips_fee'              => $request->tips_fee,
            'discount'              => $request->discount,
            'total_estimated_fee'   => $request->total_estimated_fee,
            'status'                => 'PENDING',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil dibuat',
            'data'    => new TaskResource($task->load(['packageCategory', 'user']))
        ], 201);
    }
    // 3. Show
    public function show(string $id)
    {
        $task = Task::with(['packageCategory', 'user', 'mitra'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => new TaskResource($task)
        ]);
    }

    // 4. Update (User, hanya saat PENDING)
    public function update(TaskRequest $request, string $id)
    {
        $task = Task::where('user_id', auth('user')->id())->findOrFail($id);

        if ($task->status !== 'PENDING') {
            return response()->json([
                'success' => false,
                'message' => 'Tugas tidak dapat diubah karena sudah diproses oleh Mitra.'
            ], 400);
        }

        $task->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil diperbarui',
            'data'    => new TaskResource($task->load('packageCategory'))
        ]);
    }

    // 5. Destroy (User, hanya saat PENDING)
    public function destroy(string $id)
    {
        $task = Task::where('user_id', auth('user')->id())->findOrFail($id);

        if ($task->status !== 'PENDING' && $task->status !== 'SEARCHING' ) {
            return response()->json([
                'success' => false,
                'message' => 'Tugas tidak dapat dihapus karena sudah berjalan.'
            ], 400);
        }

        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil dihapus'
        ]);
    }

    // 6. Mitra ambil tugas
    public function acceptTask(string $id)
    {
        $task = Task::findOrFail($id);

        if ($task->status !== 'PENDING') {
            return response()->json([
                'success' => false,
                'message' => 'Maaf, tugas ini sudah diambil oleh mitra lain.'
            ], 400);
        }

        $task->update([
            'mitra_id' => auth('mitra')->id(),
            'status'   => 'ACCEPTED'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kamu berhasil mengambil tugas ini!',
            'data'    => new TaskResource($task->load(['packageCategory', 'user', 'mitra']))
        ]);
    }

    // 7. Mitra submit bukti pekerjaan
    public function submitProofOfWork(Request $request, string $id)
    {
        $request->validate([
            'proof_of_work' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $task = Task::findOrFail($id);

        // Hanya mitra yang mengerjakan task ini yang boleh submit
        if ($task->mitra_id !== auth('mitra')->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu tidak memiliki akses untuk menyelesaikan tugas ini.'
            ], 403);
        }

        // Hanya boleh submit saat status ACCEPTED atau PICKED_UP
        if (!in_array($task->status, ['ACCEPTED', 'PICKED_UP'])) {
            return response()->json([
                'success' => false,
                'message' => 'Bukti tidak dapat dikirim. Status tugas saat ini: ' . $task->status
            ], 400);
        }

        // Hapus foto bukti lama jika ada (kasus mitra upload ulang setelah di-reject)
        if ($task->proof_of_work) {
            Storage::disk('public')->delete($task->proof_of_work);
        }

        $path = $request->file('proof_of_work')->store('proof-of-work', 'public');

        $task->update([
            'proof_of_work' => $path,
            'status'        => 'PROOF_SUBMITTED',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bukti pekerjaan berhasil dikirim. Menunggu konfirmasi dari user.',
            'data'    => new TaskResource($task->load(['packageCategory', 'user', 'mitra']))
        ]);
    }

    // 8. User konfirmasi pekerjaan selesai
    public function confirmTask(string $id)
    {
        $task = Task::where('user_id', auth('user')->id())->findOrFail($id);

        if ($task->status !== 'PROOF_SUBMITTED') {
            return response()->json([
                'success' => false,
                'message' => 'Tugas belum memiliki bukti pekerjaan yang menunggu konfirmasi.'
            ], 400);
        }

        $task->update(['status' => 'COMPLETED']);

        return response()->json([
            'success' => true,
            'message' => 'Pekerjaan telah dikonfirmasi selesai. Terima kasih!',
            'data'    => new TaskResource($task->load(['packageCategory', 'user', 'mitra']))
        ]);
    }

    // 9. User reject bukti — mitra harus upload ulang
    public function rejectProof(string $id)
    {
        $task = Task::where('user_id', auth('user')->id())->findOrFail($id);

        if ($task->status !== 'PROOF_SUBMITTED') {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada bukti pekerjaan yang bisa ditolak saat ini.'
            ], 400);
        }

        // Hapus file bukti lama dari storage agar mitra upload yang baru
        if ($task->proof_of_work) {
            Storage::disk('public')->delete($task->proof_of_work);
        }

        $task->update([
            'proof_of_work' => null,
            'status'        => 'ACCEPTED', // Balik ke ACCEPTED, mitra upload ulang
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bukti pekerjaan ditolak. Mitra akan diminta mengirim ulang.',
            'data'    => new TaskResource($task->load(['packageCategory', 'user', 'mitra']))
        ]);
    }
}
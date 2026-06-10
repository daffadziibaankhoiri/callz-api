<?php

namespace App\Http\Controllers;

use App\Models\JobCategory;
use Illuminate\Http\Request;

class JobCategoryController extends Controller
{
    // 1. Tampilkan semua kategori pekerjaan (Bisa diakses Publik, User, & Mitra)
    public function index()
    {
        $categories = JobCategory::latest()->get();

        return response()->json([
            'success' => true,
            'data'    => $categories
        ]);
    }

    // 2. Tampilkan detail satu kategori pekerjaan (Bisa diakses Publik, User, & Mitra)
    public function show(string $id)
    {
        $category = JobCategory::findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $category
        ]);
    }

    // 3. Simpan kategori pekerjaan baru (Khusus Admin)
    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:100|unique:job_categories,name',
            'additional_price' => 'required|integer|min:0',
        ]);

        $category = JobCategory::create([
            'name'             => $request->name,
            'additional_price' => $request->additional_price,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori pekerjaan berhasil ditambahkan',
            'data'    => $category
        ], 201);
    }

    // 4. Perbarui data ulasan kategori pekerjaan (Khusus Admin)
    public function update(Request $request, string $id)
    {
        $category = JobCategory::findOrFail($id);

        $request->validate([
            'name'             => 'required|string|max:100|unique:job_categories,name,' . $id,
            'additional_price' => 'required|integer|min:0',
        ]);

        $category->update([
            'name'             => $request->name,
            'additional_price' => $request->additional_price,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori pekerjaan berhasil diperbarui',
            'data'    => $category
        ]);
    }

    // 5. Hapus kategori pekerjaan (Khusus Admin)
    public function destroy(string $id)
    {
        $category = JobCategory::findOrFail($id);
        
        // Memanfaatkan proteksi restrict dari foreign key database agar tidak error jika id sedang dipakai di tabel tasks
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori pekerjaan berhasil dihapus'
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\PackageCategory;
use App\Http\Requests\PackageCategoryRequest;
use App\Http\Resources\PackageCategoryResource;

class PackageCategoryController extends Controller
{
    // 1. Tampilkan semua kategori (Bisa diakses publik / user saat mau milih jenis paket)
    public function index()
    {
        $categories = PackageCategory::latest()->get();
        return PackageCategoryResource::collection($categories);
    }

    // 2. Simpan kategori baru (Biasanya hanya untuk admin)
    public function store(PackageCategoryRequest $request)
    {
        $category = PackageCategory::create([
            'name'             => $request->name,
            'price'            => $request->price,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori paket berhasil ditambahkan',
            'data'    => new PackageCategoryResource($category)
        ], 201);
    }

    // 3. Tampilkan detail satu kategori
    public function show(string $id)
    {
        $category = PackageCategory::findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => new PackageCategoryResource($category)
        ]);
    }

    // 4. Update data kategori
    public function update(PackageCategoryRequest $request, string $id)
    {
        $category = PackageCategory::findOrFail($id);
        
        $category->update([
            'name'             => $request->name,
            'price'            => $request->price,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori paket berhasil diperbarui',
            'data'    => new PackageCategoryResource($category)
        ]);
    }

    // 5. Hapus kategori
    public function destroy(string $id)
    {
        $category = PackageCategory::findOrFail($id);
        
        // Laravel otomatis memblokir hapus (restrict) jika id ini sedang dipakai di tabel tasks
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori paket berhasil dihapus'
        ]);
    }
}
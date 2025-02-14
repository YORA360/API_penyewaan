<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = kategori::all();
        return response()->json([
            'success' => true,
            'message' => 'kategor retrieved successfully.',
            'data' => $kategori,
        ], 200);
    }

    public function show(int $kategori_id)
    {
        $kategori = kategori::with('alat')->find($kategori_id);

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'kategori not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'kategori retrieved successfully.',
            'data' => $kategori,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_nama' => 'required|string|max:100',
        
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 400);
        }

        $kategori = kategori::create($request->all());
        return response()->json([
            'success' => true,
            'message' => 'kategori created successfully.',
            'data' => $kategori,
        ], 201);
    }

    public function update(Request $request, int $id)
    {
        $kategori = kategori::find($id);

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'kategori not found.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'kategori_nama' => 'required|string|max:100',
            
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 400);
        }

        $kategori->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'kategori updated successfully.',
            'data' => $kategori,
        ], 200);
    }

    public function destroy(int $kategori_id)
    {
        $kategori = kategori::find($kategori_id);

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'kategori not found.',
            ], 404);
        }

        $kategori->delete();
        return response()->json([
            'success' => true,
            'message' => 'kategori deleted successfully.',
        ], 200);
    }
}

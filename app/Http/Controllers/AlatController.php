<?php

namespace App\Http\Controllers;

use App\Models\alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AlatController extends Controller
{
    public function index()
    {
        $alat = alat::all();
        return response()->json([
            'success' => true,
            'message' => 'Alat retrieved successfully.',
            'data' => $alat,
        ], 200);
    }

    public function show(int $alat_id)
    {
        $alat = alat::with('penyewaan_detail')->find($alat_id);

        if (!$alat) {
            return response()->json([
                'success' => false,
                'message' => 'alat not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'alat retrieved successfully.',
            'data' => $alat,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'alat_nama' => 'required|string|max:100',
            'alat_deskripsi' => 'required|string|max:255',
            'alat_hargaPerhari' => 'required|integer',
            'alat_stok' => 'required|integer' ,
            'alat_kategori_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 400);
        }

        $alat = alat::create($request->all());
        return response()->json([
            'success' => true,
            'message' => 'alat created successfully.',
            'data' => $alat,
        ], 201);
    }

    public function update(Request $request, int $id)
    {
        $alat = alat::find($id);

        if (!$alat) {
            return response()->json([
                'success' => false,
                'message' => 'alat not found.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'alat_nama' => 'required|string|max:100',
            'alat_deskripsi' => 'required|string|max:255',
            'alat_hargaPerhari' => 'required|integer',
            'alat_stok' => 'required|integer' ,
            'alat_kategori_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 400);
        }

        $alat->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'alat updated successfully.',
            'data' => $alat,
        ], 200);
    }

    public function destroy(int $alat_id)
    {
        $alat = alat::find($alat_id);

        if (!$alat) {
            return response()->json([
                'success' => false,
                'message' => 'alat not found.',
            ], 404);
        }

        $alat->delete();
        return response()->json([
            'success' => true,
            'message' => 'alat deleted successfully.',
        ], 200);
    }
}

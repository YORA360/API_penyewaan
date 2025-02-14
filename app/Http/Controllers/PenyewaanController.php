<?php

namespace App\Http\Controllers;

use App\Models\penyewaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenyewaanController extends Controller
{
    public function index()
    {
        $penyewaan = penyewaan::all();
        return response()->json([
            'success' => true,
            'message' => 'penyewaan retrieved successfully.',
            'data' => $penyewaan,
        ], 200);
    }

    public function show(int $penyewaan_id)
    {
        $penyewaan = penyewaan::with('penyewaan_detail')->find($penyewaan_id);

        if (!$penyewaan) {
            return response()->json([
                'success' => false,
                'message' => 'penyewaan not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'penyewaan retrieved successfully.',
            'data' => $penyewaan,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'penyewaan_pelanggan_id' => 'required|integer',
            'penyewaan_tglSewa' => 'required|date',
            'penyewaan_tglKembali' => 'required|date',
            'status_Pembayaran'=> 'required|string',
            'status_Pengembalian' => 'required|string',
            'penyewaan_totalHarga' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 400);
        }

        $penyewaan = penyewaan::create($request->all());
        return response()->json([
            'success' => true,
            'message' => 'penyewaan created successfully.',
            'data' => $penyewaan,
        ], 201);
    }

    public function update(Request $request, int $penyewaan_id)
    {
        // Cari data penyewaan berdasarkan ID
        $penyewaan = penyewaan::find($penyewaan_id);
    
        // Jika tidak ditemukan, kembalikan respons error
        if (!$penyewaan) {
            return response()->json([
                'success' => false,
                'message' => 'Penyewaan not found.',
            ], 404);
        }
    
        // Validasi request
        $validator = Validator::make($request->all(), [
            'penyewaan_pelanggan_id' => 'required|integer',
            'penyewaan_tglSewa' => 'required|date',
            'penyewaan_tglKembali' => 'required|date',
            'status_Pembayaran' => 'required|string',
            'status_Pengembalian' => 'required|string',
            'penyewaan_totalHarga' => 'required|integer',
        ]);
    
        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 400);
        }
    
        // Perbarui data penyewaan
        $penyewaan->update($request->only([
            'penyewaan_pelanggan_id',
            'penyewaan_tglSewa',
            'penyewaan_tglKembali',
            'status_Pembayaran',
            'status_Pengembalian',
            'penyewaan_totalHarga'
        ]));
    
        return response()->json([
            'success' => true,
            'message' => 'Penyewaan updated successfully.',
            'data' => $penyewaan,
        ], 200);
    }
    

    public function destroy(int $penyewaan_id)
    {
        $penyewaan = penyewaan::find($penyewaan_id);

        if (!$penyewaan) {
            return response()->json([
                'success' => false,
                'message' => 'penyewaan not found.',
            ], 404);
        }

        $penyewaan->delete();
        return response()->json([
            'success' => true,
            'message' => 'penyewaan deleted successfully.',
        ], 200);
    }
}

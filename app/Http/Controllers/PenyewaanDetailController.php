<?php

namespace App\Http\Controllers;

use App\Models\penyewaan_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenyewaanDetailController extends Controller
{
    public function index()
    {
        $penyewaanDetail = penyewaan_detail::all();
        return response()->json([
            'success' => true,
            'message' => 'penyewaanDetail retrieved successfully.',
            'data' => $penyewaanDetail,
        ], 200);
    }

    public function show(int $penyewaan_detail_id)
    {
        $penyewaanDetail = penyewaan_detail::find($penyewaan_detail_id);

        if (!$penyewaanDetail) {
            return response()->json([
                'success' => false,
                'message' => 'penyewaanDetail not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'penyewaanDetail retrieved successfully.',
            'data' => $penyewaanDetail,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'penyewaan_detail_penyewaan_id' => 'required|string|',
            'penyewaan_detail_alat_id' => 'required|integer',
            'penyewaan_detail_jumlah' => 'required|integer',
            'penyewaan_detail_subHarga' => 'required|integer'
        
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 400);
        }

        $penyewaanDetail = penyewaan_detail::create($request->all());
        return response()->json([
            'success' => true,
            'message' => 'penyewaanDetail created successfully.',
            'data' => $penyewaanDetail,
        ], 201);
    }

    public function update(Request $request, int $penyewaan_detail_id)
    {
        $penyewaanDetail = penyewaan_detail::find($penyewaan_detail_id);

        if (!$penyewaanDetail) {
            return response()->json([
                'success' => false,
                'message' => 'penyewaanDetail not found.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'penyewaan_detail_penyewaan_id' => 'required|string|',
            'penyewaan_detail_alat_id' => 'required|integer',
            'penyewaan_detail_jumlah' => 'required|integer',
            'penyewaan_detail_subHarga' => 'required|integer'
        
            
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 400);
        }

        $penyewaanDetail->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'penyewaanDetail updated successfully.',
            'data' => $penyewaanDetail,
        ], 200);
    }

    public function destroy(int $penyewaan_detail_id)
    {
        $penyewaanDetail = penyewaan_detail::find($penyewaan_detail_id);

        if (!$penyewaanDetail) {
            return response()->json([
                'success' => false,
                'message' => 'penyewaanDetail not found.',
            ], 404);
        }

        $penyewaanDetail->delete();
        return response()->json([
            'success' => true,
            'message' => 'penyewaanDetail deleted successfully.',
        ], 200);
    }
}

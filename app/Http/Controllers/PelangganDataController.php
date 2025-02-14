<?php

namespace App\Http\Controllers;

use App\Models\pelanggan_data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PelangganDataController extends Controller
{
    public function index()
    {
        $pelangganData = pelanggan_data::all();
        return response()->json([
            'success' => true,
            'message' => 'pelangganData retrieved successfully.',
            'data' => $pelangganData,
        ], 200);
    }

    public function show(int $pelanggan_data_id)
    {
        $pelangganData = pelanggan_data::find($pelanggan_data_id);

        if (!$pelangganData) {
            return response()->json([
                'success' => false,
                'message' => 'pelangganData not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'pelangganData retrieved successfully.',
            'data' => $pelangganData,
        ], 200);
    }

    public function store(Request $request)
{
    // Cek apakah pelanggan_data_pelanggan_id sudah ada di database
    $existingData = pelanggan_data::where('pelanggan_data_pelanggan_id', $request->pelanggan_data_pelanggan_id)->first();

    if ($existingData) {
        return response()->json([
            'success' => false,
            'message' => 'pelanggan_data_pelanggan_id sudah terdaftar. Tidak dapat memasukkan data yang sama.',
        ], 400);
    }

    // Validasi input
    $validator = Validator::make($request->all(), [
        'pelanggan_data_pelanggan_id' => 'required|string',
        'pelanggan_data_jenis' => 'required|in:KTP,SIM',
        'pelanggan_data_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed.',
            'errors' => $validator->errors(),
        ], 400);
    }

    // Proses upload file
    if ($request->hasFile('pelanggan_data_file')) {
        $file = $request->file('pelanggan_data_file');
        $fileName = time() . '_' . $file->getClientOriginalName(); 
        $filePath = $file->storeAs('uploads', $fileName, 'public');
    }

    // Simpan data ke database
    $pelangganData = pelanggan_data::create([
        'pelanggan_data_pelanggan_id' => $request->pelanggan_data_pelanggan_id,
        'pelanggan_data_jenis' => $request->pelanggan_data_jenis,
        'pelanggan_data_file' => $filePath,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Pelanggan Data Created Successfully.',
        'data' => $pelangganData,
    ], 201);
}


    public function update(Request $request, int $pelanggan_data_id)
    {
        $pelangganData = pelanggan_data::find($pelanggan_data_id);

        if (!$pelangganData) {
            return response()->json([
                'success' => false,
                'message' => 'pelangganData not found.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'pelanggan_data_pelanggan_id' => 'required|string',
            'pelanggan_data_jenis' => 'required|in:KTP,SIM',
           'pelanggan_data_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240'
            
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 400);
        }

        $pelangganData->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'pelangganData updated successfully.',
            'data' => $pelangganData,
        ], 200);
    }

    public function destroy(int $pelanggan_data_id)
    {
        $pelangganData = pelanggan_data::find($pelanggan_data_id);

        if (!$pelangganData) {
            return response()->json([
                'success' => false,
                'message' => 'pelangganData not found.',
            ], 404);
        }

        if ($pelangganData->pelanggan_data_file) {
            $filePath = storage_path('app/public/' . $pelangganData->pelanggan_data_file);
            if (file_exists($filePath)) {
                unlink($filePath); // Hapus file dari storage
            }
        }
    
        // **Hapus data dari database**
        $pelangganData->delete();

        $pelangganData->delete();
        return response()->json([
            'success' => true,
            'message' => 'pelangganData deleted successfully.',
        ], 200);
    }
}

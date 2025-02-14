<?php

namespace App\Http\Controllers;

use App\Models\pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = pelanggan::all();
        return response()->json([
            'success' => true,
            'message' => 'pelanggan retrieved successfully.',
            'data' => $pelanggan,
        ], 200);
    }

    public function show(int $pelanggan_id)
    {
        $pelanggan = pelanggan::with('pelanggan_data')->find($pelanggan_id);

        if (!$pelanggan) {
            return response()->json([
                'success' => false,
                'message' => 'pelanggan not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'pelanggan retrieved successfully.',
            'data' => $pelanggan,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pelanggan_nama' => 'required|string',
            'pelanggan_alamat' => 'required|string',
            'pelanggan_noTelp' => 'required|digits_between:10,15',
            'pelanggan_email' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 400);
        }

        $pelanggan = pelanggan::create($request->all());
        return response()->json([
            'success' => true,
            'message' => 'pelanggan created successfully.',
            'data' => $pelanggan,
        ], 201);
    }

    public function update(Request $request, int $id)
    {
        $pelanggan = pelanggan::find($id);

        if (!$pelanggan) {
            return response()->json([
                'success' => false,
                'message' => 'pelanggan not found.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'pelanggan_nama' => 'required|string|max:100',
            'pelanggan_nama' => 'required|string',
            'pelanggan_alamat' => 'required|string',
            'pelanggan_noTelp' => 'required|char',
            'pelanggan_email' => 'required|string',
            
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 400);
        }

        $pelanggan->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'pelanggan updated successfully.',
            'data' => $pelanggan,
        ], 200);
    }

    public function destroy(int $pelanggan_id)
    {
        $pelanggan = pelanggan::find($pelanggan_id);

        if (!$pelanggan) {
            return response()->json([
                'success' => false,
                'message' => 'pelanggan not found.',
            ], 404);
        }

        $pelanggan->delete();
        return response()->json([
            'success' => true,
            'message' => 'pelanggan deleted successfully.',
        ], 200);
    }
}

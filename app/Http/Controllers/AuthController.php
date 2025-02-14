<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    public function register (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $response = array(
                'success' => false,
                'message' => 'Failed to register. Please check your input data',
                'data' => null,
                'errors' => $validator->errors()
            );

            return response()->json($response, 400);
        }

        $user = User::create($validator->validated());
        $response = array(
            'success' => true,
            'message' => 'Successfully register.',
            'data' => $user
        );

        return response()->json($response, 201);
    }

    public function login(Request $request)
    {
        if ($request->isMethod('get')) {
            return response()->json(['message' => 'Use POST method to login'], 405);
        }
    
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

           if ($validator->fails()) {
            $response = array(
                'success' => false,
                'message' => 'Failed to login. Please check your input data',
                'data' => null,
                'errors' => $validator->errors()
            );

            return response()->json($response, 400);
        }
    
        $credentials = $request->only('email', 'password');
        if (!$token = auth("api")->attempt($credentials)) {
            return response()->json(['success' => false, 'message' => 'Invalid credentials'], 400);
        }
    
        return response()->json(['success' => true, 'access_token' => $token], 200);
    }

    public function forgotPassword(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email|exists:users,email',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    // Buat token baru
    $token = Str::random(60);

    // Simpan token di database (table: password_resets)
    DB::table('password_resets')->updateOrInsert(
        ['email' => $request->email],
        ['token' => $token, 'created_at' => now()]
    );

    // Kirim email dengan token langsung
  Mail::raw("Gunakan token berikut untuk mereset password Anda: $token", function ($message) use ($request) {
        $message->to($request->email)
                ->subject('Reset Password Token');
    });

    return response()->json(['message' => 'Token reset password telah dikirim ke email Anda', 'token' => $token]);
}
public function resetPassword(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email|exists:users,email',
        'token' => 'required',
        'password' => 'required|min:6|confirmed',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    // Verifikasi token
    $reset = DB::table('password_resets')->where([
        ['email', '=', $request->email],
        ['token', '=', $request->token],
    ])->first();

    if (!$reset) {
        return response()->json(['error' => 'Token tidak valid atau sudah kedaluwarsa'], 400);
    }

    // Reset password
    $user = User::where('email', $request->email)->first();
    $user->password = bcrypt($request->password);
    $user->save();

    // Hapus token setelah digunakan
    DB::table('password_resets')->where('email', $request->email)->delete();

    return response()->json(['message' => 'Password berhasil direset']);
}

    public function refreshToken()
{
    return response()->json([
        'success' => true,
        'access_token' => auth('api')->refresh(),
        'message' => 'Token refreshed successfully'
    ]);
}

public function logout()
{
    auth('api')->logout();
    return response()->json([
        'success' => true,
        'message' => 'Successfully logged out'
    ]);
}

}
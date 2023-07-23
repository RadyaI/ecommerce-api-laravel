<?php

namespace App\Http\Controllers;

use App\Models\karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class authController extends Controller
{
    function login(Request $req)
    {
        $req->validate([
            'email' => 'required|email',
            'password' => 'required',
            // 'device_name' => 'required',
        ]);

        $check = karyawan::where('email', $req->email)->first();
        $getRole = karyawan::where('email',$req->email)->select('nama_karyawan')->first();
        // dd($check);
        if (!$check || !Hash::check($req->password, $check->password)) {
            throw ValidationException::withMessages([
                'email' => ['Salah kayaknya'],
                'password' => ['Ini juga'],
            ]);
        }
        return $check->createToken($getRole)->plainTextToken;
    }

    function logout(Request $req) {
        $req->user()->currentAccessToken()->delete();
        return response()->json(['msg' => 'Logout Success']);
    }
}

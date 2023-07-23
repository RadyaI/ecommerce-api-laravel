<?php

namespace App\Http\Controllers;

use App\Models\karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class karyawanController extends Controller
{
    function getKaryawan()
    {
        $get = karyawan::get();
        return response()->json($get);
    }

    function selectKaryawan($id)
    {
        $get = karyawan::where('id_karyawan', $id)->first();
        if ($get === null) {
            return response()->json(['msg' => 'Data tidak di temukan'], 404);
        }
        return response()->json($get);
    }

    function createKaryawan(Request $req)
    {
        $validate = Validator::make($req->all(), [
            'nama_karyawan' => 'required',
            'email' => 'required|unique:karyawan|email',
            'gender' => 'required',
            'umur' => 'required',
            'role' => 'required',
            'password' => 'required|min:3|max:10'
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors()->toJson());
        }
        $create = karyawan::create([
            'nama_karyawan' => $req->nama_karyawan,
            'email' => $req->email,
            'gender' => $req->gender,
            'umur' => $req->umur,
            'role' => $req->role,
            'password' => Hash::make($req->password),
        ]);
        if ($create) {
            return response()->json(['msg' => 'success', 'result' => $create], 200);
        }

        return response()->json(['msg' => 'Failed Create Data'], 500);
    }

    function updateKaryawan(Request $req, $id)
    {
        $validate = Validator::make($req->all(), [
            'nama_karyawan' => 'required',
            'email' => 'required|unique:karyawan|email',
            'gender' => 'required',
            'umur' => 'required',
            'role' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors()->toJson());
        }

        $update = karyawan::where('id_karyawan', $id)->update([
            'nama_karyawan' => $req->nama_karyawan,
            'email' => $req->email,
            'gender' => $req->gender,
            'umur' => $req->umur,
            'role' => $req->role,
            // 'password' => Hash::make($req->password), 
        ]);

        if ($update) {
            return response()->json(['msg' => 'Success Update Karyawan', 'result' => $update], 200);
        }
        return response()->json(['msg' => 'Failed Update Karyawan'], 500);
    }

    function deleteKaryawan($id)
    {
        $delete = karyawan::where('id_karyawan', $id)->delete();
        if ($delete) {
            return response()->json(['msg' => 'Success delete karyawan'], 200);
        }
        return response()->json(['msg' => 'Failed Delete Karyawan'], 404);
    }
}

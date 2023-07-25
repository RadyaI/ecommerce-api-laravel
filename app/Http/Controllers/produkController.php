<?php

namespace App\Http\Controllers;

// use App\Models\Karyawan;
use App\Models\produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class produkController extends Controller
{
    function getProduk()
    {
        $get = produk::get();
        return response()->json($get);
    }

    function createProduk(Request $req)
    {
        $validate = Validator::make($req->all(), [
            'nama_produk' => 'required',
            'deskripsi' => 'required',
            'foto' => 'required',
            'harga' => 'required',
            // 'stok' => 'required',
            // 'total_beli' => 'required',
            // 'rating' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors());
        }

        if ($req->foto) {
            $random = Str::random('10');
            $fileName = $random . '.' . $req->foto->extension();
            $req->foto->move(public_path('images'), $fileName);
        }

        $insert = produk::create([
            'nama_produk' => $req->nama_produk,
            'deskripsi' => $req->deskripsi,
            'foto' => $fileName,
            'harga' => $req->harga,
            'stok' => 0,
            'total_beli' => 0,
            'rating' => null,
        ]);

        if ($insert) {
            return response()->json(['msg' => 'Success Create Produk', 'result' => $insert], 200);
        }

        return response()->json(['msg' => 'Failed Create Produk'], 500);
    }

    function updateProduk(Request $req, $id)
    {
        $validate = Validator::make($req->all(), [
            'nama_produk' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors());
        }

        $update = produk::where('id_produk', $id)->update([
            'nama_produk' => $req->nama_produk,
            'deskripsi' => $req->deskripsi,
            'harga' => $req->harga,
            'stok' => $req->stok,
        ]);

        if ($update) {
            return response()->json([
                'msg' => 'Success Update Produk'
            ], 200);
        }   

        return response()->json([
            'msg' => 'Failed Update Produk'
        ], 500);
    }

    function deleteProduk($id)
    {
        $delete = produk::where('id_produk', $id)->delete();
        if ($delete) {
            return response()->json(['msg' => 'Berhasil Delete Produk']);
        }
            return response()->json(['msg' => 'Gagal Delete Produk']);
    }
}

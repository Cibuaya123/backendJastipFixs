<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Produk;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::all();

        return response()->json([
            'message' => 'Success',
            'produk' => $produk
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_kategori' => 'required',
            'nama_produk' => 'required',
            'gambar' => 'required',
            'deskripsi' => 'required',
            'harga_jual' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $produk = Produk::create([
            'id_kategori' => $request->id_kategori,
            'nama_produk' => $request->nama_produk,
            'gambar' => $request->gambar,
            'deskripsi' => $request->deskripsi,
            'harga_jual' => $request->harga_jual,
        ]);

        return response()->json([
            'message' => 'Product created successfully.',
            'produk' => $produk
        ], 201);
    }

    public function show($id)
    {
        $produk = Produk::find($id);

        if (!$produk) {
            return response()->json([
                'message' => 'Product not found.'
            ], 404);
        }

        return response()->json([
            'message' => 'Success',
            'produk' => $produk
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_kategori' => 'required',
            'nama_produk' => 'required',
            'gambar' => 'required',
            'deskripsi' => 'required',
            'harga_jual' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $produk = Produk::find($id);

        if (!$produk) {
            return response()->json([
                'message' => 'Product not found.'
            ], 404);
        }

        $produk->id_kategori = $request->id_kategori;
        $produk->nama_produk = $request->nama_produk;
        $produk->gambar = $request->gambar;
        $produk->deskripsi = $request->deskripsi;
        $produk->harga_jual = $request->harga_jual;
        $produk->save();

        return response()->json([
            'message' => 'Product updated successfully.',
            'produk' => $produk
        ], 200);
    }

    public function destroy($id)
    {
        $produk = Produk::find($id);

        if (!$produk) {
            return response()->json([
                'message' => 'Product not found.'
            ], 404);
        }

        $produk->delete();

        return response()->json([
            'message' => 'Product deleted successfully.'
        ], 200);
    }
}

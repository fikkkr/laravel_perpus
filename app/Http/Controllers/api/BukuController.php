<?php

namespace App\Http\Controllers\api;

use App\Models\Buku;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buku = Buku::select('id', 'judul', 'pengarang', 'jml_halaman')->get();
        return response()->json([
            'message' => 'succes',
            'data' => $buku,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
                $validated = $request->validate(
            [
                'judul'=>'required',
                'pengarang'=>'required',
                'jml_halaman'=>'required|numeric'
            ],
            [
                'judul.required'=> 'judul harus diisi',
                'pengarang.required'=> 'pengarang harus diisi',
                'jml_halaman.required'=> 'jumlah halaman harus diisi',
                'jml_halaman.numeric'=> 'jumlah halaman harus berupa angka'
            ]
            );
        $buku = Buku::create($validated);
        return response()->json([
            "message" => 'data berhasil disimpan',
            'data' => $buku
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $buku = Buku::find($id);
        if (!$buku) {
            return response()-> json([
                'message'=>'buku tidak ditemukan '
            ], 404);
        } else {
            return response()->json([
                'message' => 'succes',
                'data' => $buku
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate(
            [
                'judul'=>'somtimes',
                'pengarang'=>'somtimes',
                'jml_halaman'=>'somtimes'
            ]
            );
        $buku = Buku::findorfail($id);
        $buku -> update($validated);
        return response()->json([
            'message' => 'data berhasil di update',
            'data' => $buku
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku = Buku::find($id);
        if (!$buku) {
            return response()->json([
                'message' => 'data tidak ditemukan'
            ], 404);
        } else{
            $buku->delete();
            return response()->json([
                'message'=>'data buku dihapus'
            ]);
        }
    }
}

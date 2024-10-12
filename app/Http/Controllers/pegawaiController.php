<?php

namespace App\Http\Controllers;

use App\Models\pegawai;
use Illuminate\Http\Request;

class pegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return pegawai::with('ruangan')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:200',
            'alamat' => 'required|string|max:200',
            'tgl_lahir' => 'required|date',
            'id_ruangan' => 'required|integer|exists:ruangans,id_ruangan',
        ]);

        $pegawai = new Pegawai();
        $pegawai->nama = $validatedData['nama'];
        $pegawai->alamat = $validatedData['alamat'];
        $pegawai->tgl_lahir = $validatedData['tgl_lahir'];
        $pegawai->id_ruangan = $validatedData['id_ruangan'];
        $pegawai->save();

        return response()->json($pegawai, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pegawai $pegawai)
    {
        return response()->json($pegawai->load('ruangan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:200',
            'alamat' => 'required|string|max:200',
            'tgl_lahir' => 'required|date',
            'id_ruangan' => 'required|integer|exists:ruangans,id_ruangan',
        ]);

        $pegawai->update($validatedData);

        return response()->json($pegawai);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();
        return response()->json(null, 204);
    }
}

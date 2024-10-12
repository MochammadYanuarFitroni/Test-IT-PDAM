<?php

namespace App\Http\Controllers;

use App\Models\ruangan;
use Illuminate\Http\Request;

class ruanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(ruangan::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'keterangan' => 'required|string|max:200',
        ]);

        $ruangan = new ruangan();
        $ruangan->keterangan = $validatedData['keterangan'];
        $ruangan->save();

        return response()->json($ruangan, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id_ruangan)
    {
        $ruangan = ruangan::with('pegawais')->findOrFail($id_ruangan);
        return response()->json($ruangan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_ruangan)
    {
        $ruangan = ruangan::findOrFail($id_ruangan);

        $validatedData = $request->validate([
            'keterangan' => 'required|string|max:200',
        ]);

        $ruangan->update($validatedData);

        return response()->json($ruangan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_ruangan)
    {
        $ruangan = ruangan::findOrFail($id_ruangan);
        $ruangan->delete();
        return response()->json(null, 204);
    }
}

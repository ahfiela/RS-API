<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HospitalController extends Controller
{
    // ==========================================
    // [WEB] PANEL MANAGEMENT (CRUD) - Tetap Aman
    // ==========================================
    public function index()
    {
        $hospitals = Hospital::latest()->paginate(10);
        return view('dashboard', compact('hospitals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_rs' => 'required|alpha_num|unique:hospitals,kode_rs',
            'nama_rs' => 'required|string|max:255',
            'status_rs' => 'required|in:Aktif,Non-Aktif',
            'alamat_rs' => 'required|string',
        ]);

        Hospital::create($request->all());
        return redirect()->back()->with('success', 'Rumah Sakit berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $hospital = Hospital::findOrFail($id);

        $request->validate([
            'kode_rs' => 'required|alpha_num|unique:hospitals,kode_rs,' . $id,
            'nama_rs' => 'required|string|max:255',
            'status_rs' => 'required|in:Aktif,Non-Aktif',
            'alamat_rs' => 'required|string',
        ]);

        $hospital->update($request->all());
        return redirect()->back()->with('success', 'Data Rumah Sakit berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $hospital = Hospital::findOrFail($id);
        $hospital->delete();
        return redirect()->back()->with('success', 'Rumah Sakit berhasil dihapus!');
    }

    // ==========================================
    // [API] ENDPOINT UNTUK SERVER UTAMA (REVISI)
    // ==========================================
    public function validateApi(Request $request)
    {
        // Menggunakan Validator manual agar response error formatnya rapi (JSON)
        $validator = Validator::make($request->all(), [
            'kode_rs' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Format request tidak valid, kode_rs wajib diisi.',
                'errors'  => $validator->errors()
            ], 400);
        }

        // Cari RS berdasarkan kode_rs
        $hospital = Hospital::where('kode_rs', $request->kode_rs)->first();

        if (!$hospital) {
            return response()->json([
                'status'  => 'not_found',
                'message' => 'Kode RS tidak terdaftar di server validasi pusat.'
            ], 404);
        }

        if ($hospital->status_rs !== 'Aktif') {
            return response()->json([
                'status'  => 'inactive',
                'message' => 'Kode RS terdaftar, tetapi status RS sedang Non-Aktif.'
            ], 403);
        }

        // Response distandarkan, mengembalikan data snake_case sesuai DB asli
        return response()->json([
            'status'   => 'success',
            'message'  => 'Validasi berhasil. Rumah sakit aktif.',
            'resource' => [
                'kode_rs'     => $hospital->kode_rs,
                'nama_rs'     => $hospital->nama_rs,
                'alamat_rs'   => $hospital->alamat_rs,
                'verified_at' => now()->toIso8601String()
            ]
        ], 200);
    }
}
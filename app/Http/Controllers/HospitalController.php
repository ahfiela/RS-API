<?php
namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    // ==========================================
    // [WEB] PANEL MANAGEMENT (CRUD)
    // ==========================================

    // List & Halaman Utama
    public function index()
    {
        $hospitals = Hospital::latest()->paginate(10);
        return view('dashboard', compact('hospitals'));
    }

    // CREATE: Simpan RS Baru
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

    // UPDATE: Update Data RS
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

    // DELETE: Hapus RS dari sistem
    public function destroy($id)
    {
        $hospital = Hospital::findOrFail($id);
        $hospital->delete();

        return redirect()->back()->with('success', 'Rumah Sakit berhasil dihapus dari sistem validation!');
    }

    // ==========================================
    // [API] ENDPOINT UNTUK SERVER EKSTERNAL
    // ==========================================
    public function validateApi(Request $request)
    {
        // Server lain wajib mengirimkan kode_rs
        $request->validate([
            'kode_rs' => 'required|string'
        ]);

        // Cari RS berdasarkan kode_rs dan pastikan statusnya "Aktif"
        $hospital = Hospital::where('kode_rs', $request->kode_rs)->first();

        if (!$hospital) {
            return response()->json([
                'isValid' => false,
                'message' => 'Kode RS tidak terdaftar di server validasi pusat.'
            ], 404);
        }

        if ($hospital->status_rs !== 'Aktif') {
            return response()->json([
                'isValid' => false,
                'message' => 'Kode RS terdaftar, tetapi status RS sedang Non-Aktif.'
            ], 403);
        }

        // Jika ada dan aktif, kirim balikan data lengkapnya
        return response()->json([
            'isValid'  => true,
            'message'  => 'Validasi berhasil. Data ditemukan.',
            'resource' => [
                'kode_rs'  => $hospital->kode_rs,
                'namaRs'   => $hospital->nama_rs,
                'alamatRs' => $hospital->alamat_rs,
                'statusRs' => $hospital->status_rs,
                'verified_at' => now()->toIso8601String()
            ]
        ], 200);
    }
}
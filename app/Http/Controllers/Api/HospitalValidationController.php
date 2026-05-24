<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HospitalValidationController extends Controller
{
    public function validateHospital(Request $request)
    {
        // 1. Validasi input request dari server eksternal
        $validator = Validator::make($request->all(), [
            'kode_rs' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Format request tidak valid.',
                'errors'  => $validator->errors()
            ], 400);
        }

        // 2. Cari kode_rs di database
        $hospital = Hospital::where('kode_rs', $request->kode_rs)->first();

        // 3. Jika tidak ditemukan
        if (!$hospital) {
            return response()->json([
                'status'  => 'not_found',
                'message' => 'Rumah sakit dengan kode tersebut tidak terdaftar.'
            ], 404);
        }

        // 4. Jika ditemukan, kembalikan data lengkap
        return response()->json([
            'status' => 'success',
            'message' => 'Rumah sakit valid dan terdaftar.',
            'data' => [
                'kode_rs'   => $hospital->kode_rs,
                'namaRs'    => $hospital->nama_rs,
                'alamatRs'  => $hospital->alamat_rs,
                'statusRs'  => $hospital->status_rs
            ]
        ], 200);
    }
}
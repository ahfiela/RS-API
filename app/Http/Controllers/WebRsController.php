<?php

namespace App\Http\Controllers;

use App\Models\BpjsPasien;
use Illuminate\Http\Request;

class WebRsController extends Controller
{
    public function index()
    {
        $pasiens = RsKode::orderBy('created_at', 'desc')->get();
        return view('rs.index', compact('rs'));
    }

    public function create()
    {
        return view('rs.create');
    }

    public function edit($kode_rs)
    {
        $rs = RsKode::where('no_bpjs', $kode_rs)->firstOrFail();
        return view('rs.edit', compact('rs'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DataController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Admin melihat semua data, user biasa hanya melihat data miliknya
        if ($user->role === 'admin') {
            $nasabahList = Nasabah::all();
        } else {
            $nasabahList = Nasabah::where('user_id', $user->id)->get();
        }

        return Inertia::render('Dashboard', [
            'nasabahList' => $nasabahList
        ]);
    }


    public function store(Request $request)
    {
        // Tambahkan user_id dari user yang sedang login ke data nasabah
        $nasabahData = $request->only('nama', 'nik', 'alamat', 'pekerjaan', 'jenis_usaha');
        $nasabahData['user_id'] = auth()->id();  // Menambahkan user_id

        // Simpan data ke tabel nasabah terlebih dahulu
        $nasabah = Nasabah::create($nasabahData);

        // Simpan data ke tabel pengajuan dengan nasabah_id
        $pengajuanData = $request->only('slik', 'pendapatan_utama', 'pendapatan_lain', 'modal', 'aset', 'tanggungan', 'biaya_lain', 'jenis_jaminan', 'harga');
        $pengajuanData['nasabah_id'] = $nasabah->id;  // Menghubungkan nasabah_id ke pengajuan

        Pengajuan::create($pengajuanData);

        return redirect()->route('data.get')->with('success', 'Data berhasil disimpan!');

    }
}

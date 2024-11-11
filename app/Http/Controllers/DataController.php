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
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:20',
            'alamat' => 'required|string',
            'pekerjaan' => 'required|string|max:100',
            'jenis_usaha' => 'required|string|max:100',
            'slik' => 'required|string',
            'pendapatan_utama' => 'required|numeric',
            'pendapatan_lain' => 'nullable|numeric',
            'modal' => 'nullable|numeric',
            'aset' => 'nullable|numeric',
            'tanggungan' => 'nullable|numeric',
            'biaya_lain' => 'nullable|numeric',
            'jenis_jaminan' => 'required|string',
            'harga' => 'required|numeric',
        ]);

        $nasabahData = $request->only('nama', 'nik', 'alamat', 'pekerjaan', 'jenis_usaha');
        $nasabahData['user_id'] = auth()->id();

        $nasabah = Nasabah::create($nasabahData);

        $pengajuanData = $request->only('slik', 'pendapatan_utama', 'pendapatan_lain', 'modal', 'aset', 'tanggungan', 'biaya_lain', 'jenis_jaminan', 'harga');
        $pengajuanData['nasabah_id'] = $nasabah->id;

        Pengajuan::create($pengajuanData);

        return redirect()->route('data.get')->with('success', 'Data berhasil disimpan!');
    }

    public function edit($id)
    {
        $user = auth()->user();
        $nasabah = Nasabah::with('pengajuan')->findOrFail($id);

        // Pastikan hanya admin atau pemilik data yang dapat mengedit
        if ($user->role !== 'admin' && $nasabah->user_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        return Inertia::render('NasabahEdit', [
            'nasabah' => $nasabah,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $nasabah = Nasabah::findOrFail($id);

        // Validasi kepemilikan data
        if ($user->role !== 'admin' && $nasabah->user_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:20',
            'alamat' => 'required|string',
            'pekerjaan' => 'required|string|max:100',
            'jenis_usaha' => 'required|string|max:100',
            'slik' => 'required|string',
            'pendapatan_utama' => 'required|numeric',
            'pendapatan_lain' => 'nullable|numeric',
            'modal' => 'nullable|numeric',
            'aset' => 'nullable|numeric',
            'tanggungan' => 'nullable|numeric',
            'biaya_lain' => 'nullable|numeric',
            'jenis_jaminan' => 'required|string',
            'harga' => 'required|numeric',
        ]);

        // Update data nasabah
        $nasabahData = $request->only('nama', 'nik', 'alamat', 'pekerjaan', 'jenis_usaha');
        $nasabah->update($nasabahData);

        // Update data pengajuan
        $pengajuanData = $request->only('slik', 'pendapatan_utama', 'pendapatan_lain', 'modal', 'aset', 'tanggungan', 'biaya_lain', 'jenis_jaminan', 'harga');
        $nasabah->pengajuan->update($pengajuanData);

        return redirect()->route('data.get')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $nasabah = Nasabah::findOrFail($id);
        $nasabah->delete();

        return redirect()->route('data.get')->with('success', 'Nasabah berhasil dihapus.');
    }

}

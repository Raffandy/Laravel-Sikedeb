<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfilStandar;
use Inertia\Inertia;

class ProfilStandarController extends Controller
{
    public function index()
    {
        $profilStandar = ProfilStandar::first();
        return Inertia::render('Admin/ProfilStandar', [
            'profil_standar' => $profilStandar,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'slik' => 'required|integer|min:1|max:5',
            'pendapatan_utama' => 'required|integer|min:1|max:5',
            'pendapatan_lain' => 'required|integer|min:1|max:5',
            'modal' => 'required|integer|min:1|max:5',
            'aset' => 'required|integer|min:1|max:5',
            'tanggungan' => 'required|integer|min:1|max:5',
            'biaya_lain' => 'required|integer|min:1|max:5',
            'bpkb' => 'required|integer|min:1|max:5',
            'shm' => 'required|integer|min:1|max:5',
        ]);

        // Menghitung nilai_minimum berdasarkan formula
        $nilai_minimum = (
            $request->slik +
            $request->pendapatan_utama +
            $request->pendapatan_lain +
            $request->modal +
            $request->aset
        ) / 5;

        $profilStandar = ProfilStandar::first();
        // $profilStandar->update($request->all());
        $profilStandar->update([
            ...$request->all(),
            'nilai_minimum' => $nilai_minimum // Menyertakan nilai_minimum dalam update
        ]);

        return redirect()->back()->with('success', 'Profil standar berhasil diperbarui !');
    }
}

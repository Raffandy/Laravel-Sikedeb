<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nasabah;
use App\Models\Pengajuan;
use App\Models\ProfilStandar;

class PerhitunganController extends Controller
{
    // Tampilkan form input nasabah
    public function create()
    {
        return view('nasabah.create');
    }

    // Simpan data nasabah dan pengajuan
    public function store(Request $request, $id)
    {
        // Cari data nasabah berdasarkan ID
    $nasabah = Nasabah::findOrFail($id);

    // Ambil atau buat data pengajuan berdasarkan ID nasabah
    $pengajuan = Pengajuan::firstOrNew(['nasabah_id' => $nasabah->id]);

    // Ambil data profil standar
    $profilStandar = ProfilStandar::First();

    // Dapatkan input dari request atau default ke nilai sebelumnya di database
    $pengajuan->slik = $request->input('slik', $pengajuan->slik);
    $pengajuan->pendapatan_utama = $request->input('pendapatan_utama', $pengajuan->pendapatan_utama);
    $pengajuan->pendapatan_lain = $request->input('pendapatan_lain', $pengajuan->pendapatan_lain);
    $pengajuan->modal = $request->input('modal', $pengajuan->modal);
    $pengajuan->aset = $request->input('aset', $pengajuan->aset);
    $pengajuan->tanggungan = $request->input('tanggungan', $pengajuan->tanggungan);
    $pengajuan->biaya_lain = $request->input('biaya_lain', $pengajuan->biaya_lain);
    $pengajuan->jenis_jaminan = $request->input('jenis_jaminan', $pengajuan->jenis_jaminan);
    $pengajuan->harga = $request->input('harga_jaminan', $pengajuan->harga);

    // Lakukan perhitungan yang sama seperti di contoh sebelumnya
    $nilai_slik = $this->calculateSlik($pengajuan->slik);
    $nilai_pendapatan_utama = $this->calculatePendapatan($pengajuan->pendapatan_utama);
    $nilai_pendapatan_lain = $this->calculatePendapatanLain($pengajuan->pendapatan_lain);
    $nilai_modal = $this->calculateModal($pengajuan->modal);
    $nilai_aset = $this->calculateAset($pengajuan->aset);
    $nilai_tanggungan = $this->calculateTanggungan($pengajuan->tanggungan);
    $nilai_biaya_lain = $this->calculateBiayaLain($pengajuan->biaya_lain);
    $nilai_bpkb = $this->calculateBpkb($pengajuan->jenis_jaminan, $pengajuan->harga);

        // Profil standar dari database
        $profil_standar = [
            'c1' => $profilStandar->slik,
            'c2' => $profilStandar->pendapatan_utama,
            'c3' => $profilStandar->pendapatan_lain,
            'c4' => $profilStandar->modal,
            'c5' => $profilStandar->aset,
            'c6' => $profilStandar->tanggungan,
            'c7' => $profilStandar->biaya_lain,
            'c8' => $profilStandar->bpkb,
            'nilai_minimum' => $profilStandar->nilai_minimum,
        ];

        // Hitung gap
        $gaps = [
            'slik' => $this->calculateGap($nilai_slik - $profil_standar['c1']),
            'pendapatan_utama' => $this->calculateGap($nilai_pendapatan_utama - $profil_standar['c2']),
            'pendapatan_lain' => $this->calculateGap($nilai_pendapatan_lain - $profil_standar['c3']),
            'modal' => $this->calculateGap($nilai_modal - $profil_standar['c4']),
            'aset' => $this->calculateGap($nilai_aset - $profil_standar['c5']),
            'tanggungan' => $this->calculateGap($nilai_tanggungan - $profil_standar['c6']),
            'biaya_lain' => $this->calculateGap($nilai_biaya_lain - $profil_standar['c7']),
            'bpkb' => $this->calculateGap($nilai_bpkb - $profil_standar['c8']),
        ];

        // Hitung core dan secondary factor
        $core_factor = ($gaps['slik'] + $gaps['pendapatan_utama'] + $gaps['pendapatan_lain'] + $gaps['modal'] + $gaps['aset']) / 5;
        $secondary_factor = ($gaps['tanggungan'] + $gaps['biaya_lain'] + $gaps['bpkb']) / 3;

        // Hitung total nilai
        $total_nilai = (0.6 * $core_factor) + (0.4 * $secondary_factor);
        $nasabah->nilai = $total_nilai;

        // Tentukan kelayakan berdasarkan nilai
        $nasabah->status = $total_nilai >= $profil_standar['nilai_minimum'] ? 'layak' : 'tidak layak';

        // Simpan pengajuan ke database
        // $pengajuan->save();
        $nasabah->save();

        $nasabah = Nasabah::with('pengajuan')->findOrFail($id);

        return redirect()->route('data.get')->with([
            'success' => 'Data nasabah berhasil dihitung.',
            'selectedNasabah' => $nasabah,
        ]);
        // return redirect()->route('data.get')->with('success', 'Data nasabah berhasil disimpan.');
    }

    // Fungsi-fungsi perhitungan nilai
    private function calculateSlik($slik)
    {
        return match ($slik) {
            1 => 5,
            2 => 4,
            3 => 3,
            4 => 2,
            5 => 1,
            default => 0,
        };
    }

    private function calculatePendapatan($pendapatan)
    {
        return match (true) {
            $pendapatan >= 15000000 => 5,
            $pendapatan >= 10000000 => 4,
            $pendapatan >= 5000000 => 3,
            $pendapatan >= 1500000 => 2,
            default => 1,
        };
    }

    private function calculatePendapatanLain($pendapatan)
    {
        return match (true) {
            $pendapatan >= 15000000 => 5,
            $pendapatan >= 10000000 => 4,
            $pendapatan >= 5000000 => 3,
            $pendapatan >= 1500000 => 2,
            default => 1,
        };
    }

    private function calculateModal($modal)
    {
        return match (true) {
            $modal >= 100000000 => 5,
            $modal >= 75000000 => 4,
            $modal >= 50000000 => 3,
            $modal >= 25000000 => 2,
            default => 1,
        };
    }

    private function calculateAset($aset)
    {
        return match (true) {
            $aset >= 100000000 => 5,
            $aset >= 75000000 => 4,
            $aset >= 50000000 => 3,
            $aset >= 25000000 => 2,
            default => 1,
        };
    }

    private function calculateTanggungan($tanggungan)
    {
        return match (true) {
        $tanggungan > 7 => 1, // Sangat Kurang
        $tanggungan >= 6 => 2, // Kurang
        $tanggungan >= 4 => 3, // Cukup
        $tanggungan >= 2 => 4, // Baik
        default => 5, // Sangat Baik
    };
    }

    private function calculateBiayaLain($biaya)
    {
        return match (true) {
            $biaya >= 4000000 => 1,
            $biaya >= 3000000 => 2,
            $biaya >= 2000000 => 3,
            $biaya >= 1000000 => 4,
            default => 5,
        };
    }

    private function calculateBpkb($jenis, $bpkb)
    {
        if ($jenis == "BPKB"){
            return match (true) {
                $bpkb >= 50000000 => 5,
                $bpkb >= 25000000 => 4,
                $bpkb >= 15000000 => 3,
                $bpkb >= 5000000 => 2,
                default => 1,
            };
        } if ($jenis == "SHM") {
            return match (true) {
                $bpkb >= 200000000 => 5,
                $bpkb >= 150000000 => 4,
                $bpkb >= 100000000 => 3,
                $bpkb >= 50000000 => 2,
                default => 1,
            };
        }
    }

    // Fungsi perhitungan gap
    private function calculateGap($nilai_gap)
    {
        return match ($nilai_gap) {
            5 => 0.5,
            4 => 1.5,
            3 => 2.5,
            2 => 3.5,
            1 => 4.5,
            0 => 5,
            -1 => 4,
            -2 => 3,
            -3 => 2,
            -4 => 1,
            -5 => 0,
            default => 0,
        };
    }
}

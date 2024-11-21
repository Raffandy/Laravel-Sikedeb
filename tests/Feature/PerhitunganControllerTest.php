<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Nasabah;
use App\Models\Pengajuan;

class PerhitunganControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_calculates_eligibility_correctly()
    {
        // Buat data pengguna
        $user = User::create([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => bcrypt('password'),
        ]);

        // Buat data nasabah yang terkait dengan pengguna
        $nasabah = Nasabah::create([
            'user_id' => $user->id,
            'nama' => 'Nasabah Test',
            'nik' => '1234567890123456',
            'alamat' => 'Jl. Test Alamat',
            'pekerjaan' => 'Karyawan',
            'jenis_usaha' => 'Retail',
            'status' => null, // Status awal null
        ]);

        // Data input untuk simulasi pengajuan
        $data = [
            'slik' => 1,
            'pendapatan_utama' => 20000000,
            'pendapatan_lain' => 5000000,
            'modal' => 100000000,
            'aset' => 150000000,
            'tanggungan' => 1,
            'biaya_lain' => 1000000,
            'jenis_jaminan' => 'bpkb',
            'harga_jaminan' => 100000000,
        ];

        // Kirim permintaan POST untuk menghitung kelayakan
        $response = $this->actingAs($user)->post(route('nasabah.hitung', $nasabah->id), $data);

        // Pastikan pengalihan berhasil ke rute yang benar
        $response->assertRedirect(route('data.get'));

        // Verifikasi bahwa status kelayakan telah dihitung dan disimpan
        $this->assertDatabaseHas('nasabah', [
            'id' => $nasabah->id,
            'status' => 'layak',
        ]);

        // Verifikasi data total_nilai disimpan dengan benar di tabel pengajuan
        $pengajuan = Pengajuan::where('nasabah_id', $nasabah->id)->first();
        $this->assertNotNull($pengajuan);
        $this->assertGreaterThanOrEqual(3.4, $pengajuan->total_nilai);
    }

    public function test_store_denies_access_for_unauthorized_user()
    {
        // Buat data pengguna yang tidak memiliki hubungan dengan nasabah
        $unauthorizedUser = User::create([
            'name' => 'Unauthorized User',
            'email' => 'unauthorized@example.com',
            'password' => bcrypt('password'),
        ]);

        // Buat data nasabah
        $nasabah = Nasabah::create([
            'user_id' => null, // Nasabah tidak terkait dengan pengguna
            'nama' => 'Nasabah Test',
            'nik' => '1234567890123456',
            'alamat' => 'Jl. Test Alamat',
            'pekerjaan' => 'Karyawan',
            'jenis_usaha' => 'Retail',
            'status' => null, // Status awal null
        ]);

        // Data input untuk simulasi pengajuan
        $data = [
            'slik' => 1,
            'pendapatan_utama' => 20000000,
            'pendapatan_lain' => 5000000,
            'modal' => 100000000,
            'aset' => 150000000,
            'tanggungan' => 1,
            'biaya_lain' => 1000000,
            'jenis_jaminan' => 'bpkb',
            'harga_jaminan' => 100000000,
        ];

        // Kirim permintaan POST sebagai pengguna yang tidak berwenang
        $response = $this->actingAs($unauthorizedUser)->post(route('nasabah.hitung', $nasabah->id), $data);

        // Pastikan permintaan ditolak dengan kode status 403
        $response->assertStatus(403);
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Nasabah;
use App\Models\Pengajuan;
use App\Models\ProfilStandar;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_access_other_users_data()
    {
        // Buat dua user dengan role 'user'
        $user1 = User::create([
            'name' => 'User 1',
            'email' => 'user1@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $user2 = User::create([
            'name' => 'User 2',
            'email' => 'user2@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $admin = User::create([
            'name' => 'User admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Login sebagai User 1 dan buat data Nasabah dan Pengajuan
        $this->actingAs($user1);

        $nasabah = Nasabah::create([
            'user_id' => $user1->id,
            'nama' => 'Nasabah User 1',
            'nik' => '123456789',
            'alamat' => 'Alamat User 1',
            'pekerjaan' => 'Pekerjaan User 1',
            'jenis_usaha' => 'Usaha User 1',
        ]);

        Pengajuan::create([
            'nasabah_id' => $nasabah->id,
            'slik' => 4,
            'pendapatan_utama' => 5000000,
            'pendapatan_lain' => 1000000,
            'modal' => 2000000,
            'aset' => 10000000,
            'tanggungan' => 1,
            'biaya_lain' => 500000,
            'jenis_jaminan' => 'BPKB',
            'harga' => 15000000,
        ]);

        ProfilStandar::create([
            'slik' => 4,
            'pendapatan_utama' => 4,
            'pendapatan_lain' => 4,
            'modal' => 3,
            'aset' => 5,
            'tanggungan' => 3,
            'biaya_lain' => 3,
            'bpkb' => 4,
            'shm' => 5,
            'nilai_minimum' => 4.0,
        ]);

        // Pastikan User 1 dapat melihat datanya sendiri
        $response = $this->get('/dashboard/data');
        $response->assertStatus(200);
        $response->assertSee('Nasabah User 1');

        // Logout dan login sebagai User 2
        $this->actingAs($user2);

        // Pastikan User 2 tidak dapat melihat data User 1
        $response = $this->get('/dashboard/data');
        $response->assertStatus(200);
        $response->assertDontSee('Nasabah User 1');

        // Logout dan login sebagai admin
        $this->actingAs($admin);

        // Pastikan admin dapat melihat data User 1
        $response = $this->get('/dashboard/data');
        $response->assertStatus(200);
        $response->assertSee('Nasabah User 1');
    }

    public function test_it_displays_profil_standar_for_admin()
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        ProfilStandar::create([
            'nilai_minimum' => 70,
            'slik' => 5,
            'pendapatan_utama' => 5,
            'pendapatan_lain' => 4,
            'modal' => 4,
            'aset' => 4,
            'tanggungan' => 2,
            'biaya_lain' => 2,
            'bpkb' => 4,
            'shm' => 5,
        ]);

        $this->actingAs($admin);

        $response = $this->get('/profil-standar');

        $response->assertStatus(200);
        $response->assertSee('ProfilStandar');
    }

    public function test_it_updates_profil_standar()
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $profilStandar = ProfilStandar::create([
            'nilai_minimum' => 70,
            'slik' => 5,
            'pendapatan_utama' => 5,
            'pendapatan_lain' => 4,
            'modal' => 4,
            'aset' => 4,
            'tanggungan' => 2,
            'biaya_lain' => 2,
            'bpkb' => 4,
            'shm' => 5,
        ]);

        $this->actingAs($admin);

        $data = [
            'slik' => 4,
            'pendapatan_utama' => 4,
            'pendapatan_lain' => 3,
            'modal' => 3,
            'aset' => 3,
            'tanggungan' => 1,
            'biaya_lain' => 2,
            'bpkb' => 3,
            'shm' => 4,
        ];

        $response = $this->put('/profil-standar/update', $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('profil_standar', ['nilai_minimum' => 3.4]);
    }

    public function test_integration_nasabah_profilstandar_and_perhitungan()
    {
        // Step 1: Simulate a logged-in user
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);

        // Step 2: Create a Nasabah and associated Pengajuan
        $nasabahData = [
            'nama' => 'John Doe',
            'nik' => '1234567890123456',
            'alamat' => '123 Main Street',
            'pekerjaan' => 'Developer',
            'jenis_usaha' => 'IT Services',
        ];
        $responseNasabah = $this->post(route('data.store'), array_merge($nasabahData, [
            'slik' => 4,
            'pendapatan_utama' => 10000,
            'pendapatan_lain' => 2000,
            'modal' => 5000,
            'aset' => 15000,
            'tanggungan' => 2,
            'biaya_lain' => 1000,
            'jenis_jaminan' => 'BPKB',
            'harga' => 5000,
        ]));
        $responseNasabah->assertRedirect(route('data.get'));
        $this->assertDatabaseHas('nasabah', $nasabahData);

        $nasabah = Nasabah::first();

        // Step 3: Create or update ProfilStandar
        ProfilStandar::create([
            'slik' => 4,
            'pendapatan_utama' => 4,
            'pendapatan_lain' => 4,
            'modal' => 3,
            'aset' => 5,
            'tanggungan' => 3,
            'biaya_lain' => 3,
            'bpkb' => 4,
            'shm' => 5,
            'nilai_minimum' => 4.0,
        ]);

        $profilStandar = ProfilStandar::first();
        $this->assertNotNull($profilStandar);
        $this->assertEquals(4.0, $profilStandar->nilai_minimum);

        // Step 4: Run calculations using PerhitunganController
        $perhitunganResponse = $this->post(route('nasabah.hitung', ['id' => $nasabah->id]), [
            'slik' => 4,
            'pendapatan_utama' => 10000,
            'pendapatan_lain' => 2000,
            'modal' => 5000,
            'aset' => 15000,
            'tanggungan' => 2,
            'biaya_lain' => 1000,
            'jenis_jaminan' => 'BPKB',
            'harga_jaminan' => 5000,
        ]);

        $perhitunganResponse->assertRedirect(route('data.get'));
        $nasabah->refresh();
        $this->assertNotNull($nasabah->pengajuan);
        $this->assertEquals('tidak layak', $nasabah->status);

        // Verify status was updated
        $this->assertDatabaseHas('nasabah', ['id' => $nasabah->id, 'status' => 'tidak layak']);
    }
}

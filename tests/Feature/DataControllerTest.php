<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Nasabah;
use App\Models\Pengajuan;


class DataControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_see_all_nasabah()
    {
        // Create admin user
        $admin = User::factory()->create(['role' => 'admin']);

        // Create some nasabah
        Nasabah::factory()->count(3)->create();

        // Act as admin and hit the index route
        $response = $this->actingAs($admin)->get(route('data.get'));

        $response->assertStatus(200)
                 ->assertSee(Nasabah::first()->nama);
    }

    public function test_user_can_only_see_their_nasabah()
    {
        // Create a regular user and a nasabah owned by them
        $user = User::factory()->create(['role' => 'user']);
        $nasabah = Nasabah::factory()->create(['user_id' => $user->id]);

        // Create another nasabah for a different user
        Nasabah::factory()->create();

        $response = $this->actingAs($user)->get(route('data.get'));

        $response->assertStatus(200)
                 ->assertSee($nasabah->nama)
                 ->assertDontSee(Nasabah::where('user_id', '!=', $user->id)->first()->nama);
    }

    public function test_store_creates_nasabah_and_pengajuan()
    {
        $user = User::factory()->create();

        $data = [
            'nama' => 'Test Nasabah',
            'nik' => '123456789',
            'alamat' => 'Test Address',
            'pekerjaan' => 'Engineer',
            'jenis_usaha' => 'Technology',
            'slik' => 3,
            'pendapatan_utama' => 15000000,
            'pendapatan_lain' => 5000000,
            'modal' => 50000000,
            'aset' => 75000000,
            'tanggungan' => 2,
            'biaya_lain' => 2000000,
            'jenis_jaminan' => 'bpkb',
            'harga' => 50000000,
        ];

        $response = $this->actingAs($user)->post(route('data.store'), $data);

        $response->assertRedirect(route('data.get'));
        $this->assertDatabaseHas('nasabah', ['nama' => 'Test Nasabah']);
        $this->assertDatabaseHas('pengajuan', ['slik' => 3]);
    }
}

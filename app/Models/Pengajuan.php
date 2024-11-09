<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    // Menentukan nama tabel
    protected $table = 'pengajuan';

    // Menentukan kolom yang dapat diisi secara massal
    protected $fillable = [
        'nasabah_id',
        'slik',
        'pendapatan_utama',
        'pendapatan_lain',
        'modal',
        'aset',
        'tanggungan',
        'biaya_lain',
        'jenis_jaminan',
        'harga',
    ];

    // Definisikan relasi ke model Nasabah
    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }
}

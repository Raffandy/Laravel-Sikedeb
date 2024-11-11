<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    use HasFactory;
    
    protected $table = 'nasabah';

    protected $fillable = [
        'user_id',
        'nama',
        'nik',
        'alamat',
        'pekerjaan',
        'jenis_usaha',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pengajuan()
    {
        return $this->hasOne(Pengajuan::class, 'nasabah_id');
    }


}

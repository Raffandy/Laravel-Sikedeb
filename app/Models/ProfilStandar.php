<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilStandar extends Model
{
    use HasFactory;

    protected $table = 'profil_standar';

    protected $fillable = [
        'slik', 
        'pendapatan_utama', 
        'pendapatan_lain', 
        'modal', 
        'aset', 
        'tanggungan', 
        'biaya_lain', 
        'bpkb', 
        'shm',
    ];
}

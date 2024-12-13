<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPelatihan extends Model
{
    use HasFactory;

    protected $guarded = [];

    // public function riwayat_pelatihan_nip()
    // {
    //     return $this->hasOne(Pegawai::class, 'nip','nip');
    // }
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nip', 'nip');
    }
}
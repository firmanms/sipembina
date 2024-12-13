<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatJabatan extends Model
{
    use HasFactory;

    protected $guarded = [];

    // public function riwayat_jabatan_nip()
    // {
    //     return $this->hasOne(Pegawai::class, 'nip','nip');
    // }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nip', 'nip');
    }

    public function pembinaan()
    {
        return $this->belongsTo(Pembinaankarir::class, 'nip', 'nip');
    }

}

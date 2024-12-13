<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutputKinerja extends Model
{
    use HasFactory;

    protected $guarded = [];

    // public function output_kinerja_nip()
    // {
    //     return $this->hasOne(Pegawai::class, 'nip','nip');
    // }
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nip', 'nip');
    }
}

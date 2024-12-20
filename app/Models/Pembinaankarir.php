<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembinaankarir extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pegawais()
    {
        return $this->belongsTo(Pegawai::class, 'pegawais_id');
    }

    public function riwayat_jabatan_nip()
    {
        return $this->hasMany(RiwayatJabatan::class, 'nip','nip');
    }
}

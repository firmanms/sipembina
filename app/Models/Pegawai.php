<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pegawai extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function nip_pegawais(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nip','nip');
    }

    public function bagians()
    {
        return $this->belongsTo(Refbagian::class, 'refbagians_id');
    }

    public function jabatans()
    {
        return $this->belongsTo(Refjabatan::class, 'refjabatans_id');
    }

    public function pembinas()
    {
    return $this->hasMany(Pembinaankarir::class, 'pegawais_id');
    }

    public function riwayat_pendidikan_nip()
    {
        return $this->hasMany(RiwayatPendidikan::class, 'nip','nip');
    }

    public function riwayat_jabatan_nip()
    {
        return $this->hasMany(RiwayatJabatan::class, 'nip','nip');
    }

    public function riwayat_pelatihan_nip()
    {
        return $this->hasMany(RiwayatPelatihan::class, 'nip','nip');
    }

    public function output_kinerja_nip()
    {
        return $this->hasMany(OutputKinerja::class, 'nip','nip');
    }
}

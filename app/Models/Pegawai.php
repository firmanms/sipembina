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
}

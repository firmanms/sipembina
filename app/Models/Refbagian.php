<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refbagian extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pegawais()
    {
    return $this->hasMany(Pegawai::class, 'refbagians_id');
    }
}

<?php

namespace App\Filament\Resources\PembinaankarirResource\Pages;

use App\Filament\Resources\PembinaankarirResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditPembinaankarir extends EditRecord
{
    protected static string $resource = PembinaankarirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function beforeFill()
{
    // Mengambil daftar peran pengguna yang sedang login
    $roles = Auth::user()->roles->pluck('name'); // Sesuaikan jika cara akses role berbeda
    $roleNames = $roles->implode(', '); // Menggabungkan nama peran menjadi string

    // Mendapatkan ID pengguna yang sedang login
    $userId = Auth::id();

    // Mendapatkan record yang sedang di-edit
    $usulan = $this->record;

    // Periksa apakah pengguna memiliki peran yang diizinkan dan memiliki hak akses untuk mengedit usulan
    // Hanya peran tertentu yang diperbolehkan mengedit (misalnya, super_admin, kabid, subag, sekdis, kadis)
    if ((!$roles->intersect(['super_admin', 'Kabid', 'Subag', 'Sekdis', 'Kadis'])->isNotEmpty())) {
        abort(403, 'Unauthorized action.');
    }
}
}

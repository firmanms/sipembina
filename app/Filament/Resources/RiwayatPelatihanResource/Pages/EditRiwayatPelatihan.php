<?php

namespace App\Filament\Resources\RiwayatPelatihanResource\Pages;

use App\Filament\Resources\RiwayatPelatihanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRiwayatPelatihan extends EditRecord
{
    protected static string $resource = RiwayatPelatihanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

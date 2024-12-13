<?php

namespace App\Filament\Resources\RiwayatPendidikanResource\Pages;

use App\Filament\Resources\RiwayatPendidikanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRiwayatPendidikan extends EditRecord
{
    protected static string $resource = RiwayatPendidikanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

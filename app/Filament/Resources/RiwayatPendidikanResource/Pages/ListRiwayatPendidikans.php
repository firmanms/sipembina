<?php

namespace App\Filament\Resources\RiwayatPendidikanResource\Pages;

use App\Filament\Resources\RiwayatPendidikanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRiwayatPendidikans extends ListRecords
{
    protected static string $resource = RiwayatPendidikanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

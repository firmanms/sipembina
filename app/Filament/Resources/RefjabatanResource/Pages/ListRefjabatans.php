<?php

namespace App\Filament\Resources\RefjabatanResource\Pages;

use App\Filament\Resources\RefjabatanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRefjabatans extends ListRecords
{
    protected static string $resource = RefjabatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

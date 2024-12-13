<?php

namespace App\Filament\Resources\OutputKinerjaResource\Pages;

use App\Filament\Resources\OutputKinerjaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOutputKinerjas extends ListRecords
{
    protected static string $resource = OutputKinerjaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

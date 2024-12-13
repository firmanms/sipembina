<?php

namespace App\Filament\Resources\OutputKinerjaResource\Pages;

use App\Filament\Resources\OutputKinerjaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOutputKinerja extends EditRecord
{
    protected static string $resource = OutputKinerjaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

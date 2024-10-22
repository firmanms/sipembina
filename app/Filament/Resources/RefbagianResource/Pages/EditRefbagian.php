<?php

namespace App\Filament\Resources\RefbagianResource\Pages;

use App\Filament\Resources\RefbagianResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRefbagian extends EditRecord
{
    protected static string $resource = RefbagianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\RefjabatanResource\Pages;

use App\Filament\Resources\RefjabatanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRefjabatan extends EditRecord
{
    protected static string $resource = RefjabatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

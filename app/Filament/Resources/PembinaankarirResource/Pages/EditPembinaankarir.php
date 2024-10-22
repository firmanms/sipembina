<?php

namespace App\Filament\Resources\PembinaankarirResource\Pages;

use App\Filament\Resources\PembinaankarirResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPembinaankarir extends EditRecord
{
    protected static string $resource = PembinaankarirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

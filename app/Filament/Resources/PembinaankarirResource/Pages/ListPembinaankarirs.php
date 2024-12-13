<?php

namespace App\Filament\Resources\PembinaankarirResource\Pages;

use App\Filament\Resources\PembinaankarirResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPembinaankarirs extends ListRecords
{
    protected static string $resource = PembinaankarirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->visible(fn () => auth()->user()->hasAnyRole(['super_admin', 'subag'])),
        ];
    }
}

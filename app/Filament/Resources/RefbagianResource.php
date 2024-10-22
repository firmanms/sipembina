<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RefbagianResource\Pages;
use App\Filament\Resources\RefbagianResource\RelationManagers;
use App\Models\Refbagian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RefbagianResource extends Resource
{
    protected static ?string $model = Refbagian::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Referensi';

    protected static ?string $navigationLabel = 'Bagian';

    protected static ?string $modelLabel = 'Bagian';

    protected static ?string $pluralLabel = 'Bagian';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRefbagians::route('/'),
            'create' => Pages\CreateRefbagian::route('/create'),
            'edit' => Pages\EditRefbagian::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembinaankarirResource\Pages;
use App\Filament\Resources\PembinaankarirResource\RelationManagers;
use App\Models\Pegawai;
use App\Models\Pembinaankarir;
use Filament\Forms;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PembinaankarirResource extends Resource
{
    protected static ?string $model = Pembinaankarir::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Pembinaan Karir';

    protected static ?string $modelLabel = 'Pembinaan Karir';

    protected static ?string $pluralLabel = 'Pembinaan Karir';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Informasi')
                                ->schema([
                                    Forms\Components\Hidden::make('user_id')
                                        ->default(Auth::user()->id),
                                    Forms\Components\Select::make('pegawais_id')
                                        ->label('Pegawai')
                                        ->options(function () {

                                        return Pegawai::all()->pluck('nama', 'id');
                                        })
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->reactive()
                                        ->afterStateUpdated(function ($state, callable $set) {
                                            $pegawai = Pegawai::find($state);
                                            if ($pegawai) {
                                                $set('pangkat_gol', $pegawai->pangkat_gol);
                                                $set('pendidikan', $pegawai->pendidikan);
                                                $set('jurusan', $pegawai->jurusan);
                                                $set('komptensi', $pegawai->komptensi);
                                                $set('riwayat_jabatan', $pegawai->riwayat_jabatan);
                                                $set('riwayat_pelatihan', $pegawai->riwayat_pelatihan);
                                                $set('output_kinerja', $pegawai->output_kinerja);
                                            } else {
                                                $set('pangkat_gol', null);
                                                $set('pendidikan', null);
                                                $set('jurusan', null);
                                                $set('komptensi', null);
                                                $set('riwayat_jabatan', null);
                                                $set('riwayat_pelatihan', null);
                                                $set('output_kinerja', null);
                                            }
                                        }),
                                    ]),
                        Tabs\Tab::make('Pemetaan Karir')
                                ->schema([
                                    Forms\Components\TextInput::make('pangkat_gol')
                                        ->label('Pangkat Sekarang')
                                        ->disabled()
                                        ->readOnly(),
                                    Forms\Components\Select::make('naik_pangkat_gol')
                                        ->required()
                                        ->label('Pangkat Selanjutnya')
                                        ->options([
                                            'Pembina Utama IV e' => 'Pembina Utama IV e',
                                            'Pembina Utama Madya IV d' => 'Pembina Utama Madya IV d',
                                            'Pembina Utama Muda IV c' => 'Pembina Utama Muda IV c',
                                            'Pembina Tingkat I IV b' => 'Pembina Tingkat I IV b',
                                            'Pembina IV a' => 'Pembina IV a',
                                            'Penata Tingkat I III d' => 'Penata Tingkat I III d',
                                            'Penata III c' => 'Penata III c',
                                            'Penata Muda Tingkat I III b' => 'Penata Muda Tingkat I III b',
                                            'Penata Muda III a' => 'Penata Muda III a',
                                            'Pengatur Tingkat I II d' => 'Pengatur Tingkat I II d',
                                            'Pengatur II c' => 'Pengatur II c',
                                            'Pengatur Muda Tingkat I II b' => 'Pengatur Muda Tingkat I II b',
                                            'Pengatur Muda II a' => 'Pengatur Muda II a',
                                            'Juru Tingkat I I d' => 'Juru Tingkat I I d',
                                            'Juru I c' => 'Juru I c',
                                            'Juru Muda Tingkat I I b' => 'Juru Muda Tingkat I I b',
                                            'Juru Muda I a' => 'Juru Muda I a',
                                        ]),
                                    Forms\Components\RichEditor::make('catatan_naik')
                                        ->required()
                                        ->label('Catatan Naik Pangkat')
                                        ->columnSpanFull(),
                                    Forms\Components\RichEditor::make('catatan_jabatan')
                                        ->required()
                                        ->label('Catatan Jabatan Apabila di Pangkat Tersebut')
                                        ->columnSpanFull(),
                                                    ]),
                        Tabs\Tab::make('Pelatihan Pengembangan')
                                ->schema([
                                    Forms\Components\TextInput::make('pendidikan')
                                        ->label('Pendidikan Terakhir')
                                        ->disabled()
                                        ->readOnly(),
                                    Forms\Components\TextInput::make('jurusan')
                                        ->disabled()
                                        ->label('Jurusan')
                                        ->readOnly(),
                                    Forms\Components\RichEditor::make('catatan_pendidikan')
                                        ->required()
                                        ->columnSpanFull(),
                                    Forms\Components\RichEditor::make('komptensi')
                                        ->label('Kompetensi Sekarang')
                                        ->disabled()
                                        ->columnSpanFull(),
                                    Forms\Components\RichEditor::make('kompetensi_dibutuhkan')
                                        ->required()
                                        ->columnSpanFull(),
                                    Forms\Components\RichEditor::make('riwayat_pelatihan')
                                        ->label('Riwayat Pelatihan')
                                        ->disabled()
                                        ->columnSpanFull(),
                                    Forms\Components\RichEditor::make('usulan_pelatihan')
                                        ->required()
                                        ->columnSpanFull(),
                                ]),
                        Tabs\Tab::make('Penilaian Kinerja')
                                ->schema([
                                    Forms\Components\RichEditor::make('output_kinerja')
                                        ->label('Output Kinerja')
                                        ->disabled()
                                        ->columnSpanFull(),
                                    Forms\Components\RichEditor::make('realisasi_kinerja')
                                        ->required()
                                        ->columnSpanFull(),
                                ]),
                        Tabs\Tab::make('Rotasi Mutasi')
                                ->schema([
                                    Forms\Components\Select::make('rotasi_mutasi')
                                        ->required()
                                        ->options([
                                            'Rotasi' => 'Rotasi',
                                            'Mutasi' => 'Mutasi',
                                        ]),
                                    Forms\Components\RichEditor::make('catatan_rotasi_mutasi')
                                        ->required()
                                        ->columnSpanFull(),
                                ]),
                        ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('user.name')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('pegawais.nama')
                    ->label('Nama Pegawai')
                    ->sortable(),
                Tables\Columns\TextColumn::make('rotasi_mutasi')
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
                Action::make('custom_button')
                ->label('Resume')
                ->icon('heroicon-o-document-text')
                ->url(fn ($record) => route('resume', $record->id)) // Mengarahkan ke route
                ->openUrlInNewTab(),
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
            'index' => Pages\ListPembinaankarirs::route('/'),
            'create' => Pages\CreatePembinaankarir::route('/create'),
            'edit' => Pages\EditPembinaankarir::route('/{record}/edit'),
        ];
    }
}

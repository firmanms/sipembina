<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PegawaiResource\Pages;
use App\Filament\Resources\PegawaiResource\RelationManagers;
use App\Models\Pegawai;
use App\Models\Refbagian;
use App\Models\Refjabatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PegawaiResource extends Resource
{
    protected static ?string $model = Pegawai::class;

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Pegawai';

    protected static ?string $navigationGroup = 'Master';

    protected static ?string $modelLabel = 'Pegawai';

    protected static ?string $pluralLabel = 'Pegawai';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(Auth::user()->id),
                Forms\Components\Select::make('refbagians_id')
                    ->label('Bagian')
                    ->options(function () {

                        return Refbagian::all()->pluck('nama', 'id');
                    })
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('refjabatans_id')
                    ->label('Jabatan')
                    ->options(function () {

                        return Refjabatan::all()->pluck('nama', 'id');
                    })
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\DatePicker::make('tgl_awal_jabatan')
                    ->required(),
                Forms\Components\RichEditor::make('tupoksi')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('tgl_bergabung')
                    ->required(),
                Forms\Components\TextInput::make('nip')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tgl_lahir')
                    ->required(),
                Forms\Components\DatePicker::make('masa_kerja')
                    ->label('Masa Kerja PNS'),
                Forms\Components\Select::make('pangkat_gol')
                    ->required()
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
                Forms\Components\DatePicker::make('tgl_pangkat')
                    ->required(),
                Forms\Components\Select::make('eselon')
                    ->required()
                    ->options([
                        'IA' => 'IA',
                        'IB' => 'IB',
                        'IIA' => 'IIA',
                        'IIB' => 'IIB',
                        'IIIA' => 'IIIA',
                        'IIIB' => 'IIIB',
                        'IVA' => 'IVA',
                        'IVB' => 'IVB',
                        'V' => 'V',
                        'NON ESELON' => 'NON ESELON',
                    ]),
                Forms\Components\Select::make('pendidikan')
                    ->required()
                    ->options([
                        'Belum Tamat SD/Sederajat' => 'Belum Tamat SD/Sederajat',
                        'Tamat SD/sederajat' => 'Tamat SD/sederajat',
                        'SLTP/sederajat' => 'SLTP/sederajat',
                        'SLTA/sederajat' => 'SLTA/sederajat',
                        'Diploma I/II' => 'Diploma I/II',
                        'Akademi/Diploma III/S.Muda' => 'Akademi/Diploma III/S.Muda',
                        'Diploma IV/Strata I' => 'Diploma IV/Strata I',
                        'Strata II' => 'Strata II',
                        'Strata III' => 'Strata III',
                    ]),
                Forms\Components\TextInput::make('jurusan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('komptensi')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Hidden::make('riwayat_jabatan')
                    ->required()
                    ->default('-'),
                Forms\Components\Hidden::make('riwayat_pelatihan')
                    ->required()
                    ->default('-'),
                Forms\Components\Hidden::make('output_kinerja')
                    ->required()
                    ->default('-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('user.name')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('nip')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bagians.nama')
                    ->label('Bagian')
                    ->sortable(),
                Tables\Columns\TextColumn::make('jabatans.nama')
                    ->label('Jabatan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('pangkat_gol')
                    ->searchable(),
                Tables\Columns\TextColumn::make('eselon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pendidikan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jurusan')
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
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('nip')->label('NIP'),
        TextEntry::make('nama')->label('Nama Pegawai'),
        TextEntry::make('bagians.nama')->label('Bagian'),
        TextEntry::make('jabatans.nama')->label('Jabatan'),
        TextEntry::make('pangkat_gol')->label('Pangkat Golongan'),
        TextEntry::make('eselon')->label('Eselon'),
        TextEntry::make('pendidikan')->label('Pendidikan'),
        TextEntry::make('jurusan')->label('Jurusan'),
        TextEntry::make('tgl_bergabung')
            ->label('Tanggal Bergabung')
            ->dateTime('d/m/Y'),
        RepeatableEntry::make('riwayat_jabatan_nip')
            ->label('Riwayat Jabatan')
            // ->relationship('riwayat_jabatan_nip') // Nama relasi di model
            ->schema([
                TextEntry::make('nama_jabatan')->label('Nama Jabatan'),
                TextEntry::make('tmt_jabatan')->label('Tanggal Mulai')->dateTime('d/m/Y'),
                // TextEntry::make('tgl_selesai')->label('Tanggal Selesai')->dateTime('d/m/Y'),
            ])
            ->grid(2)
            ->columnSpanFull(),
        RepeatableEntry::make('riwayat_pendidikan_nip')
            ->label('Riwayat Pendidikan')
            // ->relationship('riwayat_jabatan_nip') // Nama relasi di model
            ->schema([
                TextEntry::make('tingkat_pendidikan')->label('Tingkat Pendidikan'),
                TextEntry::make('nama_sekolah')->label('Nama Sekolah'),
                // TextEntry::make('tgl_selesai')->label('Tanggal Selesai')->dateTime('d/m/Y'),
            ])
            ->grid(2)
            ->columnSpanFull(),
        RepeatableEntry::make('riwayat_pelatihan_nip')
            ->label('Riwayat Pelatihan')
            // ->relationship('riwayat_jabatan_nip') // Nama relasi di model
            ->schema([
                TextEntry::make('nama_pelatihan')->label('Nama Pelatihan'),
                // TextEntry::make('nama_sekolah')->label('Nama Sekolah'),
                // TextEntry::make('tgl_selesai')->label('Tanggal Selesai')->dateTime('d/m/Y'),
            ])
            ->grid(2)
            ->columnSpanFull(),

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
            'index' => Pages\ListPegawais::route('/'),
            'create' => Pages\CreatePegawai::route('/create'),
            'edit' => Pages\EditPegawai::route('/{record}/edit'),
        ];
    }
}

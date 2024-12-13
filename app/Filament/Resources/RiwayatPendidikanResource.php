<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RiwayatPendidikanResource\Pages;
use App\Filament\Resources\RiwayatPendidikanResource\RelationManagers;
use App\Models\RiwayatPendidikan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class RiwayatPendidikanResource extends Resource
{
    protected static ?string $model = RiwayatPendidikan::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Riwayat Pendidikan';

    protected static ?string $navigationGroup = 'Profil';

    protected static ?string $modelLabel = 'Riwayat Pendidikan';

    protected static ?string $pluralLabel = 'Riwayat Pendidikan';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nip')
                    ->maxLength(255)
                    ->readOnly()
                    ->default(Auth::user()->nip),
                Forms\Components\Select::make('tingkat_pendidikan')
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
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('nama_sekolah')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('no_ijazah')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DatePicker::make('tgl_ijazah'),
                Forms\Components\TextInput::make('nilai')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Toggle::make('pendidikan_pns')
                    ->label('Pendidikan diangkat PNS')
                    ->required(),
                Forms\Components\Toggle::make('terakhir')
                    ->label('Pendidikan Terakhir')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->required()
                    ->visible(fn () => auth()->user()->hasRole('super_admin')) // Hanya tampil untuk super_admin
                    ->options([
                        'Menunggu' => 'Menunggu',
                        'Disetujui' => 'Disetujui',
                        'Ditolak' => 'Ditolak',
                    ])
                    ->default('Menunggu'), // Nilai default
                Forms\Components\FileUpload::make('lampiran')
                    ->label('lampiran .PDF  Maks 2 Mb')
                    ->acceptedFileTypes(['application/pdf'])
                    ->directory('pendidikan/'.Auth::user()->nip)
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return now()->timestamp . '-' . $file->getClientOriginalName(); // Gabungkan timestamp dengan nama file asli
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nip')
                    ->label('NIP')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pegawai.nama')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tingkat_pendidikan')
                ->label('Tingkat Pendidikan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jurusan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_sekolah')
                    ->label('Nama Sekolah/Kampus')
                    ->searchable(),
                Tables\Columns\IconColumn::make('pendidikan_pns')
                    ->label('Pendidikan diangkat PNS')
                    ->boolean(),
                Tables\Columns\IconColumn::make('terakhir')
                    ->label('Pendidikan Terakhir')
                    ->boolean(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Disetujui' => 'success',  // Warna hijau untuk published
                        'Ditolak' => 'danger',    // Warna merah untuk rejected
                        default => 'gray',      // Warna default
                    })
                    ->icon(fn (string $state) => match ($state) {
                        'Disetujui' => 'heroicon-o-check-circle', // Ikon check-circle untuk published
                        'Ditolak' => 'heroicon-o-x-circle',     // Ikon x-circle untuk rejected
                        default => 'heroicon-o-clock',            // Ikon default untuk status lainnya
                    })
                    ->getStateUsing(fn ($record) => $record->status)  // Mengambil status untuk kolom
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
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $userId = Auth::user()->nip;
                // dd($userId);
                // Asumsikan bahwa pengguna memiliki metode atau properti untuk mendapatkan role
                $userRole = auth()->user()->role;

                $roles = Auth::user()->roles->pluck('name'); // Atau metode lain jika berbeda

                $roleNames = $roles->implode(', ');
                // dd($roleNames);
                // Cek apakah pengguna memiliki salah satu dari peran yang diizinkan
                if ($roles->contains('super_admin')) {
                    // Jika pengguna memiliki peran 'super_admin', kembalikan semua data
                    return $query;
                } elseif ($roles->contains('subag')) {
                    // Jika pengguna memiliki peran 'subag', kembalikan data sesuai aturan tertentu
                    return $query->where('nip', $userId);
                } else {
                    // Jika pengguna tidak memiliki peran yang sesuai
                    return $query->where('nip', $userId); // Contoh kondisi tambahan
                }
            });
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
            'index' => Pages\ListRiwayatPendidikans::route('/'),
            'create' => Pages\CreateRiwayatPendidikan::route('/create'),
            'edit' => Pages\EditRiwayatPendidikan::route('/{record}/edit'),
        ];
    }
}

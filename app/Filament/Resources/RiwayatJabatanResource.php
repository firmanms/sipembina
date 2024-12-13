<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RiwayatJabatanResource\Pages;
use App\Filament\Resources\RiwayatJabatanResource\RelationManagers;
use App\Models\RiwayatJabatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class RiwayatJabatanResource extends Resource
{
    protected static ?string $model = RiwayatJabatan::class;

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Riwayat Jabatan';

    protected static ?string $navigationGroup = 'Profil';

    protected static ?string $modelLabel = 'Riwayat Jabatan';

    protected static ?string $pluralLabel = 'Riwayat Jabatan';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nip')
                    ->maxLength(255)
                    ->readOnly()
                    ->default(Auth::user()->nip),
                Forms\Components\Select::make('jenis_jabatan')
                    ->required()
                    ->options([
                        'Pelaksana' => 'Pelaksana',
                        'Pelaksana Klerek' => 'Pelaksan Klerek',
                        'Pelaksana Teknisi' => 'Pelaksana Teknisi',
                        'Jabatan Pimpinan Tinggi Pratama' => 'Jabatan Pimpinan Tinggi Pratama',
                        'Jabatan Pimpinan Tinggi Madya' => 'Jabatan Pimpinan Tinggi Madya',
                        'Jabatan Pimpinan Tinggi Utama' => 'Jabatan Pimpinan Tinggi Utama'
                    ]),
                Forms\Components\TextInput::make('jenjang_jabatan')
                    ->maxLength(255)
                    ->default(null),
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
                Forms\Components\TextInput::make('nama_jabatan')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('unit_kerja')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('satuan_kerja')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DatePicker::make('tmt_jabatan')
                    ->label('TMT Jabatan'),
                Forms\Components\TextInput::make('no_sk')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DatePicker::make('tgl_sk')
                    ->label('Tanggal SK'),
                Forms\Components\TextInput::make('pjb_menetapkan')
                    ->label('Pejabat Penetapan')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DatePicker::make('akhir_jabatan')
                    ->label('Akhir Jabatan'),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->required()
                    ->visible(fn () => auth()->user()->hasRole('super_admin')) // Hanya tampil untuk super_admin
                    ->options([
                        'Menunggu' => 'Menunggu',
                        'Disetujui' => 'Disetujui',
                        'Ditolak' => 'Ditolak',
                    ])
                    ->default('Menunggu'),
                Forms\Components\FileUpload::make('lampiran')
                    ->label('lampiran .PDF  Maks 2 Mb')
                    ->acceptedFileTypes(['application/pdf'])
                    ->directory('jabatan/'.Auth::user()->nip)
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
                    ->searchable(),
                Tables\Columns\TextColumn::make('pegawai.nama')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_jabatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_jabatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('satuan_kerja')
                    ->searchable(),
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
            'index' => Pages\ListRiwayatJabatans::route('/'),
            'create' => Pages\CreateRiwayatJabatan::route('/create'),
            'edit' => Pages\EditRiwayatJabatan::route('/{record}/edit'),
        ];
    }
}

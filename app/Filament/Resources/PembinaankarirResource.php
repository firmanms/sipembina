<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembinaankarirResource\Pages;
use App\Filament\Resources\PembinaankarirResource\RelationManagers;
use App\Models\OutputKinerja;
use App\Models\Pegawai;
use App\Models\Pembinaankarir;
use App\Models\Refbagian;
use App\Models\Refjabatan;
use App\Models\RiwayatJabatan;
use App\Models\RiwayatPelatihan;
use App\Models\RiwayatPendidikan;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;

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
                                    // Forms\Components\Select::make('pegawais_id')
                                    //     ->label('Pegawai')
                                    //     ->options(function () {

                                    //     return Pegawai::all()->pluck('nama', 'id');
                                    //     })
                                    //     ->searchable()
                                    //     ->preload()
                                    //     ->required()
                                    //     ->reactive()
                                    //     ->afterStateUpdated(function ($state, callable $set) {
                                    //         $pegawai = Pegawai::find($state);
                                    //         if ($pegawai) {
                                    //             $set('pangkat_gol', $pegawai->pangkat_gol);
                                    //             $set('pendidikan', $pegawai->pendidikan);
                                    //             $set('jurusan', $pegawai->jurusan);
                                    //             $set('komptensi', $pegawai->komptensi);
                                    //             $set('riwayat_jabatan', $pegawai->riwayat_jabatan);
                                    //             $set('riwayat_pelatihan', $pegawai->riwayat_pelatihan);
                                    //             $set('output_kinerja', $pegawai->output_kinerja);
                                    //         } else {
                                    //             $set('pangkat_gol', null);
                                    //             $set('pendidikan', null);
                                    //             $set('jurusan', null);
                                    //             $set('komptensi', null);
                                    //             $set('riwayat_jabatan', null);
                                    //             $set('riwayat_pelatihan', null);
                                    //             $set('output_kinerja', null);
                                    //         }
                                    //     })
                                    //     ->default($pegawai->id),
                                    // ]),
                                    Forms\Components\DatePicker::make('tgl_pengajuan')
                                        ->label('Tanggal Pengajuan')
                                        ->required(),

                                    Forms\Components\Select::make('nip')
                                        ->label('Pegawai')
                                        ->options(function () {
                                            // return Pegawai::all()->pluck('nama', 'id');
                                            return Pegawai::all()->pluck('nama', 'nip');
                                        })
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->reactive()
                                        ->default(function (?Model $record) {
                                            // Pastikan `record` terisi untuk menentukan nilai default (edit mode)
                                            return $record ? $record->nip : null;
                                        })
                                        ->afterStateHydrated(function ($state, callable $set) {
                                            // Ambil data pegawai saat form dimuat
                                            // $pegawai = Pegawai::find($state);
                                            // Mengambil data pegawai saat form pertama kali dimuat
                                            $pegawai = Pegawai::where('nip', $state)->first();

                                            if ($pegawai) {
                                                $bagian = Refbagian::where('id',$pegawai->refbagians_id)->first();
                                                $jabatan = Refjabatan::where('id',$pegawai->refjabatans_id)->first();
                                                $riwayat = RiwayatJabatan::where('nip', $state)->get();
                                                $riwayatp = RiwayatPendidikan::where('nip', $state)->get();
                                                $riwayatpe = RiwayatPelatihan::where('nip', $state)->get();
                                                $riwayato = OutputKinerja::where('nip', $state)->get();

                                                $set('pegawais_id', $pegawai->id);
                                                $set('bagian', $bagian->nama);
                                                $set('jabatan', $jabatan->nama);
                                                $set('masa_kerja', $pegawai->masa_kerja);
                                                $set('tgl_awal_jabatan', $pegawai->tgl_awal_jabatan);
                                                $set('pangkat_gol', $pegawai->pangkat_gol);
                                                $set('pendidikan', $pegawai->pendidikan);
                                                $set('jurusan', $pegawai->jurusan);
                                                $set('komptensi', $pegawai->komptensi);
                                                $set('riwayat_jabatan', $pegawai->riwayat_jabatan);
                                                $set('riwayat_pelatihan', $pegawai->riwayat_pelatihan);
                                                $set('output_kinerja', $pegawai->output_kinerja);
                                                $set('riwayat_jabatana',$riwayat->toArray());
                                                $set('riwayat_pendidikan',$riwayatp->toArray());
                                                $set('riwayat_pelatihana',$riwayatpe->toArray());
                                                $set('riwayat_output',$riwayato->toArray());
                                            } else {
                                                $set('pegawais_id', null);
                                                $set('bagian', null);
                                                $set('jabatan', null);
                                                $set('masa_kerja', null);
                                                $set('tgl_awal_jabatan', null);
                                                $set('pangkat_gol', null);
                                                $set('pendidikan', null);
                                                $set('jurusan', null);
                                                $set('komptensi', null);
                                                $set('riwayat_jabatan', null);
                                                $set('riwayat_pelatihan', null);
                                                $set('output_kinerja', null);
                                                $set('riwayat_jabatana', null);
                                                $set('riwayat_pendidikan', null);
                                                $set('riwayat_pelatihana', null);
                                                $set('riwayat_output', null);
                                            }
                                        })
                                        ->afterStateUpdated(function ($state, callable $set) {
                                            // Reaktif ketika pegawai dipilih
                                            // $pegawai = Pegawai::find($state);
                                            // Mengambil data pegawai saat form pertama kali dimuat
                                            $pegawai = Pegawai::where('nip', $state)->first();

                                            if ($pegawai) {
                                                $bagian = Refbagian::where('id',$pegawai->refbagians_id)->first();
                                                $jabatan = Refjabatan::where('id',$pegawai->refjabatans_id)->first();
                                                $riwayat = RiwayatJabatan::where('nip', $state)->get();
                                                $riwayatp = RiwayatPendidikan::where('nip', $state)->get();
                                                $riwayatpe = RiwayatPelatihan::where('nip', $state)->get();
                                                $riwayato = OutputKinerja::where('nip', $state)->get();

                                                $set('pegawais_id', $pegawai->id);
                                                $set('bagian', $bagian->nama);
                                                $set('jabatan', $jabatan->nama);
                                                $set('masa_kerja', $pegawai->masa_kerja);
                                                $set('tgl_awal_jabatan', $pegawai->tgl_awal_jabatan);
                                                $set('pangkat_gol', $pegawai->pangkat_gol);
                                                $set('pendidikan', $pegawai->pendidikan);
                                                $set('jurusan', $pegawai->jurusan);
                                                $set('komptensi', $pegawai->komptensi);
                                                $set('riwayat_jabatan', $pegawai->riwayat_jabatan);
                                                $set('riwayat_pelatihan', $pegawai->riwayat_pelatihan);
                                                $set('output_kinerja', $pegawai->output_kinerja);
                                                $set('riwayat_jabatana',$riwayat->toArray());
                                                $set('riwayat_pendidikan',$riwayatp->toArray());
                                                $set('riwayat_pelatihana',$riwayatpe->toArray());
                                                $set('riwayat_output',$riwayato->toArray());

                                            } else {
                                                $set('pegawais_id', null);
                                                $set('bagian', null);
                                                $set('jabatan', null);
                                                $set('masa_kerja', null);
                                                $set('tgl_awal_jabatan', null);
                                                $set('pangkat_gol', null);
                                                $set('pendidikan', null);
                                                $set('jurusan', null);
                                                $set('komptensi', null);
                                                $set('riwayat_jabatan', null);
                                                $set('riwayat_pelatihan', null);
                                                $set('output_kinerja', null);
                                                $set('riwayat_jabatana', null);
                                                $set('riwayat_pendidikan', null);
                                                $set('riwayat_pelatihana', null);
                                                $set('riwayat_output', null);
                                            }
                                        }),
                                    Forms\Components\TextInput::make('bagian')
                                        ->label('Bagian')
                                        ->disabled()
                                        ->readOnly(),
                                    Forms\Components\TextInput::make('jabatan')
                                        ->label('Jabatan')
                                        ->disabled()
                                        ->readOnly(),
                                    Forms\Components\DatePicker::make('tgl_awal_jabatan')
                                        ->label('TMT Jabatan')
                                        ->disabled()
                                        ->readOnly(),
                                    Forms\Components\DatePicker::make('masa_kerja')
                                        ->label('Masa Kerja PNS')
                                        ->disabled()
                                        ->reactive()
                                        ->afterStateHydrated(fn ($state, callable $set, callable $get) =>
                                            static::calculateDuration($get, $set)
                                        )
                                        ->afterStateUpdated(fn ($state, callable $set, callable $get) =>
                                            static::calculateDuration($get, $set)
                                        ),

                                    Forms\Components\TextInput::make('masa_kerja_terkini')
                                    ->label('Total Masa Kerja')
                                    ->disabled(),
                                    Forms\Components\Hidden::make('pegawais_id')
                                        ->label('id'),
                                    ]),

                        Tabs\Tab::make('Pemetaan Karir')
                                ->schema([
                                    Forms\Components\Section::make('Riwayat Jabatan')
                                        ->schema([
                                            Forms\Components\Repeater::make('riwayat_jabatana')
                                                ->label('Riwayat Jabatan')
                                                ->disabled()
                                                ->schema([
                                                    Forms\Components\TextInput::make('nama_jabatan')
                                                        ->label('Nama Jabatan')
                                                        ->disabled(), // Tidak dapat diubah
                                                    Forms\Components\TextInput::make('unit_kerja')
                                                        ->label('Unit Kerja')
                                                        ->disabled(), // Tidak dapat diubah
                                                    Forms\Components\TextInput::make('satuan_kerja')
                                                        ->label('Satuan Kerja')
                                                        ->disabled(), // Tidak dapat diubah
                                                    Forms\Components\TextInput::make('tmt_jabatan')
                                                        ->label('TMT Jabatan')
                                                        ->disabled() // Tidak dapat diubah
                                                        ->reactive()
                                                        ->afterStateHydrated(fn ($state, callable $set, callable $get) =>
                                                            static::calculateDuration($get, $set)
                                                        ),
                                                    Forms\Components\TextInput::make('akhir_jabatan')
                                                        ->label('Akhir Jabatan')
                                                        ->disabled() // Tidak dapat diubah
                                                        ->reactive()
                                                        ->afterStateHydrated(fn ($state, callable $set, callable $get) =>
                                                            static::calculateDuration($get, $set)
                                                        ),
                                                    Forms\Components\TextInput::make('tahun_jabatan')
                                                        ->label('Lama Jabatan (Tahun & Bulan)')
                                                        ->disabled(),
                                                ])
                                                ->disableItemCreation() // Mencegah penambahan item baru
                                                ->disableItemDeletion() // Mencegah penghapusan item
                                                ->columns(3),
                                        ]),
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



                                ]),
                        Tabs\Tab::make('Pelatihan Pengembangan')
                                ->schema([
                                    Forms\Components\Section::make('Riwayat Pendidikan')
                                        ->schema([
                                            Forms\Components\Repeater::make('riwayat_pendidikan')
                                                ->label('Riwayat Pendidikan')
                                                ->disabled()
                                                ->schema([
                                                    Forms\Components\TextInput::make('tingkat_pendidikan')
                                                        ->label('Tingkat Pendidikan')
                                                        ->disabled(), // Tidak dapat diubah
                                                    Forms\Components\TextInput::make('jurusan')
                                                        ->label('Jurusan')
                                                        ->disabled(), // Tidak dapat diubah
                                                    Forms\Components\TextInput::make('nama_sekolah')
                                                        ->label('Nama Sekolah')
                                                        ->disabled(), // Tidak dapat diubah
                                                    Forms\Components\Toggle::make('pendidikan_pns')
                                                        ->label('Pendidikan Awal PNS')
                                                        ->disabled(), // Tidak dapat diubah
                                                    Forms\Components\Toggle::make('terakhir')
                                                        ->label('Pendidikan Terakhir')
                                                        ->disabled(), // Tidak dapat diubah
                                                ])
                                                ->disableItemCreation() // Mencegah penambahan item baru
                                                ->disableItemDeletion() // Mencegah penghapusan item
                                                ->columns(3),
                                        ]),
                                    Forms\Components\Hidden::make('pendidikan')
                                        ->disabled()
                                        ->label('Pendidikan Terakhir'),
                                    Forms\Components\Hidden::make('jurusan')
                                        ->disabled()
                                        ->label('Jurusan'),
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
                                    Forms\Components\Hidden::make('riwayat_pelatihan')
                                        ->label('Riwayat Pelatihan')
                                        ->disabled()
                                        ->columnSpanFull(),
                                    Forms\Components\Section::make('Riwayat Pelatihan')
                                        ->schema([
                                            Forms\Components\Repeater::make('riwayat_pelatihana')
                                                ->label('Riwayat Pendidikan')
                                                ->disabled()
                                                ->schema([
                                                    Forms\Components\TextInput::make('nama_pelatihan')
                                                        ->label('Nama Pelatihan')
                                                        ->disabled(), // Tidak dapat diubah
                                                    Forms\Components\TextInput::make('jenis')
                                                        ->label('Jenis')
                                                        ->disabled(), // Tidak dapat diubah
                                                    Forms\Components\TextInput::make('jml_jam')
                                                        ->label('Jumlah Jam')
                                                        ->disabled(), // Tidak dapat diubah
                                                ])
                                                ->disableItemCreation() // Mencegah penambahan item baru
                                                ->disableItemDeletion() // Mencegah penghapusan item
                                                ->columns(3),
                                        ]),
                                    Forms\Components\RichEditor::make('usulan_pelatihan')
                                        ->required()
                                        ->columnSpanFull(),
                                ]),
                        Tabs\Tab::make('Penilaian Kinerja')
                                ->schema([
                                    Forms\Components\Section::make('Riwayat Output')
                                        ->schema([
                                            Forms\Components\Repeater::make('riwayat_output')
                                                ->label('Riwayat Output')
                                                ->schema([
                                                    Forms\Components\RichEditor::make('catatan')
                                                        ->label('Catatan')
                                                        ->disabled(), // Tidak dapat diubah
                                                    Forms\Components\Toggle::make('terakhir')
                                                        ->label('SKP terakhir')
                                                        ->disabled(), // Tidak dapat diubah
                                                    // PdfViewerField::make('lampiran')
                                                    //     ->label('Lampiran')
                                                    //     ->disabled(),
                                                        // ->minHeight('40svh'),
                                                ])
                                                ->disabled()
                                                ->disableItemCreation() // Mencegah penambahan item baru
                                                ->disableItemDeletion() // Mencegah penghapusan item
                                                ->columns(3),
                                        ]),
                                    Forms\Components\Hidden::make('output_kinerja')
                                        ->label('Output Kinerja')
                                        ->disabled()
                                        ->columnSpanFull(),
                                    Forms\Components\RichEditor::make('realisasi_kinerja')
                                        ->required()
                                        ->columnSpanFull(),
                                ]),
                        Tabs\Tab::make('Usulan')
                                ->schema([
                                    Forms\Components\Select::make('rotasi_mutasi')
                                        ->label('Usulan')
                                        ->required()
                                        ->options([
                                            'Promosi' => 'Promosi',
                                            'Rotasi' => 'Rotasi',
                                            'Mutasi' => 'Mutasi',
                                        ]),
                                    Forms\Components\RichEditor::make('catatan_rotasi_mutasi')
                                        ->label('Jabatan Usulan')
                                        ->required()
                                        ->columnSpanFull(),
                                    Forms\Components\RichEditor::make('catatan_jabatan')
                                        ->required()
                                        ->label('Catatan Jabatan Usulan')
                                        ->columnSpanFull(),

                                ]),
                        Tabs\Tab::make('Validator')
                                ->schema([
                                    Forms\Components\Select::make('nip_kabid')
                                        ->label('Atasan Langsung')
                                        ->options(function () {
                                            // return Pegawai::all()->pluck('nama', 'id');
                                            return Pegawai::all()->pluck('nama', 'nip');
                                        })
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->default(fn () => Pegawai::first()?->nip),
                                    Forms\Components\Select::make('nip_subag')
                                        ->label('Kasubag')
                                        ->options(function () {
                                            // return Pegawai::all()->pluck('nama', 'id');
                                            return Pegawai::all()->pluck('nama', 'nip');
                                        })
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->default(fn () => Pegawai::first()?->nip),
                                    Forms\Components\Select::make('nip_sekdis')
                                        ->label('Sekdis')
                                        ->options(function () {
                                            // return Pegawai::all()->pluck('nama', 'id');
                                            return Pegawai::all()->pluck('nama', 'nip');
                                        })
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->default(fn () => Pegawai::first()?->nip),
                                    Forms\Components\Select::make('nip_kadis')
                                        ->label('Kadis')
                                        ->options(function () {
                                            // return Pegawai::all()->pluck('nama', 'id');
                                            return Pegawai::all()->pluck('nama', 'nip');
                                        })
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->default(fn () => Pegawai::first()?->nip),
                                ]),
                                Tabs\Tab::make('Validasiphp')
                                ->schema([
                                    Forms\Components\Select::make('aksi_kabid')
                                        ->label('Evaluasi Atasan Langsung')
                                        ->options([
                                            0 => 'Dibatalkan Atasan Langsung', // Value 0 dengan label 'Dibatalkan Kabid'
                                            1 => 'Disetujui Atasan Langsung',  // Value 1 dengan label 'Disetujui Kabid'
                                        ])
                                        ->visible(fn ($record) =>
                                            // Jika nip_kabid belum diinput (null atau kosong), gunakan Auth::user()->nip
                                            ($record?->nip_kabid ?: Auth::user()->nip) === Auth::user()->nip &&
                                            // Periksa apakah status pada record adalah "Proses"
                                            ($record?->status ?? '') === 'Proses'
                                        )
                                            ->reactive() // Pastikan Select bersifat reaktif
                                            ->afterStateUpdated(function ($state, $set) {
                                                // Tentukan status baru berdasarkan pilihan Select
                                                $newStatus = $state == 1 ? 'Disetujui Atasan Langsung' : 'Dibatalkan Atasan Langsung';

                                                // Perbarui tampilan TextInput 'status'
                                                $set('status', $newStatus);
                                            }),
                                    Forms\Components\Textarea::make('alasan_kabid')
                                        ->label('Alasan Atasan Langsung')
                                        ->visible(fn ($record) =>
                                            // Jika nip_kabid belum diinput (null atau kosong), gunakan Auth::user()->nip
                                            ($record?->nip_kabid ?: Auth::user()->nip) === Auth::user()->nip &&
                                            // Periksa apakah status pada record adalah "Proses"
                                            $record?->status === 'Proses'
                                        ),
                                    Forms\Components\DatePicker::make('tgl_aksi_kabid')
                                        ->label('Tanggal Evaluasi Atasan Langsung')
                                        ->visible(fn ($record) =>
                                            // Jika nip_kabid belum diinput (null atau kosong), gunakan Auth::user()->nip
                                            ($record?->nip_kabid ?: Auth::user()->nip) === Auth::user()->nip &&
                                            // Periksa apakah status pada record adalah "Proses"
                                            $record?->status === 'Proses'
                                        ),
                                    Forms\Components\Select::make('aksi_subag')
                                            ->label('Evaluasi Subag')
                                            ->options([
                                                0 => 'Dibatalkan Subag', // Value 0 dengan label 'Dibatalkan Kabid'
                                                1 => 'Disetujui Subag',  // Value 1 dengan label 'Disetujui Kabid'
                                            ])
                                            ->visible(fn ($record) =>
                                                // Jika nip_kabid belum diinput (null atau kosong), gunakan Auth::user()->nip
                                                ($record?->nip_subag ?: Auth::user()->nip) === Auth::user()->nip &&
                                                // Periksa apakah status pada record adalah "Proses"
                                                ($record?->status ?? '') === 'Disetujui Atasan Langsung')
                                                ->reactive() // Pastikan Select bersifat reaktif
                                                ->afterStateUpdated(function ($state, $set) {
                                                    // Tentukan status baru berdasarkan pilihan Select
                                                    $newStatus = $state == 1 ? 'Disetujui Subag' : 'Dibatalkan Subag';

                                                    // Perbarui tampilan TextInput 'status'
                                                    $set('status', $newStatus);
                                                }),

                                    Forms\Components\Textarea::make('alasan_subag')
                                        ->label('Alasan Subag')
                                        ->visible(fn ($record) =>
                                                // Jika nip_kabid belum diinput (null atau kosong), gunakan Auth::user()->nip
                                            ($record?->nip_subag ?: Auth::user()->nip) === Auth::user()->nip &&
                                                // Periksa apakah status pada record adalah "Proses"
                                                ($record?->status ?? '') === 'Disetujui Atasan Langsung'),
                                    Forms\Components\DatePicker::make('tgl_aksi_subag')
                                        ->label('Tanggal Evaluasi Subag')
                                        ->visible(fn ($record) =>
                                                // Jika nip_kabid belum diinput (null atau kosong), gunakan Auth::user()->nip
                                            ($record?->nip_subag ?: Auth::user()->nip) === Auth::user()->nip &&
                                                // Periksa apakah status pada record adalah "Proses"
                                                ($record?->status ?? '') === 'Disetujui Atasan Langsung'),
                                    Forms\Components\Select::make('aksi_sekdis')
                                                ->label('Evaluasi Sekdis')
                                                ->options([
                                                    0 => 'Dibatalkan Sekdis', // Value 0 dengan label 'Dibatalkan Kabid'
                                                    1 => 'Disetujui Sekdis',  // Value 1 dengan label 'Disetujui Kabid'
                                                ])
                                                ->visible(fn ($record) =>
                                                    // Jika nip_kabid belum diinput (null atau kosong), gunakan Auth::user()->nip
                                            ($record?->nip_sekdis?: Auth::user()->nip) === Auth::user()->nip &&
                                                    // Periksa apakah status pada record adalah "Proses"
                                                    ($record?->status ?? '') === 'Disetujui Subag')
                                                    ->reactive() // Pastikan Select bersifat reaktif
                                                    ->afterStateUpdated(function ($state, $set) {
                                                        // Tentukan status baru berdasarkan pilihan Select
                                                        $newStatus = $state == 1 ? 'Disetujui Sekdis' : 'Dibatalkan Sekdis';

                                                        // Perbarui tampilan TextInput 'status'
                                                        $set('status', $newStatus);
                                                    }),
                                    Forms\Components\Textarea::make('alasan_sekdis')
                                        ->label('Alasan Sekdis')
                                        ->visible(fn ($record) =>
                                                // Jika nip_kabid belum diinput (null atau kosong), gunakan Auth::user()->nip
                                            ($record?->nip_sekdis ?: Auth::user()->nip) === Auth::user()->nip &&
                                                // Periksa apakah status pada record adalah "Proses"
                                                ($record?->status ?? '') === 'Disetujui Subag'),
                                    Forms\Components\DatePicker::make('tgl_aksi_sekdis')
                                        ->label('Tanggal Evaluasi Sekdis')
                                        ->visible(fn ($record) =>
                                                // Jika nip_kabid belum diinput (null atau kosong), gunakan Auth::user()->nip
                                            ($record?->nip_sekdis ?: Auth::user()->nip) === Auth::user()->nip &&
                                                // Periksa apakah status pada record adalah "Proses"
                                                ($record?->status ?? '') === 'Disetujui Subag'),
                                    Forms\Components\Select::make('aksi_kadis')
                                        ->label('Evaluasi Kadis')
                                        ->options([
                                            0 => 'Dibatalkan Kadis', // Value 0 dengan label 'Dibatalkan Kabid'
                                            1 => 'Dikirim ke BKPSDM',  // Value 1 dengan label 'Disetujui Kabid'
                                        ])
                                        ->visible(fn ($record) =>
                                            // Periksa apakah NIP pada record pembinaan sama dengan NIP user yang sedang login
                                            ($record?->nip_kadis ?: Auth::user()->nip) === Auth::user()->nip &&
                                            // Periksa apakah status pada record adalah "Proses"
                                            ($record?->status ?? '') === 'Disetujui Sekdis')
                                            ->reactive() // Pastikan Select bersifat reaktif
                                            ->afterStateUpdated(function ($state, $set) {
                                                // Tentukan status baru berdasarkan pilihan Select
                                                $newStatus = $state == 1 ? 'Dikirim ke BKPSDM' : 'Dibatalkan Kadis';

                                                // Perbarui tampilan TextInput 'status'
                                                $set('status', $newStatus);
                                            }),
                                    Forms\Components\Textarea::make('alasan_kadis')
                                        ->label('Alasan Kadis')
                                        ->visible(fn ($record) =>
                                                // Periksa apakah NIP pada record pembinaan sama dengan NIP user yang sedang login
                                                ($record?->nip_kadis ?: Auth::user()->nip) === Auth::user()->nip &&
                                                // Periksa apakah status pada record adalah "Proses"
                                                ($record?->status ?? '') === 'Disetujui Sekdis'),
                                    Forms\Components\DatePicker::make('tgl_aksi_kadis')
                                        ->label('Tanggal Evaluasi Kadis')
                                        ->visible(fn ($record) =>
                                                // Periksa apakah NIP pada record pembinaan sama dengan NIP user yang sedang login
                                                ($record?->nip_kadis ?: Auth::user()->nip) === Auth::user()->nip &&
                                                // Periksa apakah status pada record adalah "Proses"
                                                ($record?->status ?? '') === 'Disetujui Sekdis'),
                                    Forms\Components\TextInput::make('status')
                                        ->label('Status Terbaru')
                                        ->readOnly()
                                        ->default('Baru')
                                        ->reactive(), // Pastikan bisa diperbarui berdasarkan Select
                                ]),


                        Tabs\Tab::make('Log Evalusi')
                                ->schema([


                                ]),
                        ])->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tgl_pengajuan')
                    ->label('Pengajuan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pegawais.nama')
                    ->label('Nama Pegawai')
                    ->sortable(),
                Tables\Columns\TextColumn::make('rotasi_mutasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->sortable(),
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


                Tables\Actions\EditAction::make()
                ->visible(fn () =>
    collect(auth()->user()->roles->pluck('name')->toArray())
        ->intersect(['Subag', 'Kabid', 'Sekdis', 'Kadis'])
        ->isNotEmpty()
),
                Tables\Actions\ViewAction::make(),
                Action::make('usulkan')
                ->label('Usulkan')
                ->icon('heroicon-o-arrow-right-circle')
                ->visible(fn ($record) => $record->status === 'Baru')
                ->action(function ($record) {
                    $record->status = 'Proses';
                    $record->save();
                    Notification::make()
                        ->title('Status berhasil diubah')
                        ->body('Status telah diubah menjadi Proses.')
                        ->success()
                        ->send();
                }),
                Action::make('custom_button')
                ->label('Cetak Usulan')
                ->visible(fn ($record) => $record->status === 'Dikirim ke BKPSDM')
                ->icon('heroicon-o-document-text')
                ->url(fn ($record) => route('resume', $record->id)) // Mengarahkan ke route
                ->openUrlInNewTab(),

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
                } elseif ($roles->contains('Subag')) {
                    // Jika pengguna memiliki peran 'subag', kembalikan data sesuai aturan tertentu
                    return $query->where('status', 'Disetujui Atasan Langsung')
                    ->orwhere('status', 'Dikirim ke BKPSDM')
                    ->orwhere('nip', $userId);
                } elseif ($roles->contains('Kabid')) {
                    // Jika pengguna memiliki peran 'subag', kembalikan data sesuai aturan tertentu
                    return $query->where('status', 'Proses')
                    ->orwhere('nip', $userId);
                } elseif ($roles->contains('Sekdis')) {
                    // Jika pengguna memiliki peran 'subag', kembalikan data sesuai aturan tertentu
                    return $query->where('status', 'Disetujui Subag')
                    ->orwhere('status', 'Dikirim ke BKPSDM')
                    ->orwhere('nip', $userId);;
                } elseif ($roles->contains('Kadis')) {
                        // Jika pengguna memiliki peran 'subag', kembalikan data sesuai aturan tertentu
                        return $query->where('status', 'Disetujui Sekdis')
                                        ->orwhere('status', 'Dikirim ke BKPSDM')
                                        ->orwhere('nip', $userId);
                } else {
                    // Jika pengguna tidak memiliki peran yang sesuai
                    return $query->where('nip', $userId); // Contoh kondisi tambahan
                }
            })
            ;
    }

    private function canTakeAction(Pembinaankarir $record, $action): bool
    {
        $userRole = auth()->user()->role;

        return match ($action) {
            'approve' => (
                ($userRole === 'Kabid' && $record->status === 'Usulkan') ||
                ($userRole === 'Subag' && $record->status === 'Approved by Kabid') ||
                ($userRole === 'Kepala Dinas' && $record->status === 'Approved by Subag')
            ),
            'reject' => (
                ($userRole === 'Kabid' && $record->status === 'Usulkan') ||
                ($userRole === 'Subag' && $record->status === 'Approved by Kabid') ||
                ($userRole === 'Kepala Dinas' && $record->status === 'Approved by Subag')
            ),
            default => false,
        };
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    protected static function calculateDuration(callable $get, callable $set)
{
    $tmtJabatan = $get('tmt_jabatan');
    $akhirJabatan = $get('akhir_jabatan');
    $masaKerja = $get('masa_kerja');

    if ($tmtJabatan && $akhirJabatan) {
        // Menggunakan Carbon untuk menghitung durasi
        $start = Carbon::parse($tmtJabatan);
        $end = Carbon::parse($akhirJabatan);

        // Hitung total bulan
        $totalMonths = $start->diffInMonths($end);

        // Konversi ke tahun dan bulan
        $years = intdiv($totalMonths, 12); // Total tahun
        $months = $totalMonths % 12; // Sisa bulan

        // Format output
        $duration = "{$years} tahun, {$months} bulan";

        // Set nilai ke field 'tahun_jabatan'
        $set('tahun_jabatan', $duration);
    } else {
        // Kosongkan nilai jika salah satu tanggal belum diisi
        $set('tahun_jabatan', null);
    }

    if ($masaKerja) {
        // Hitung masa kerja dari hari ini dikurangi masa kerja sebelumnya
        $masaKerjaStart = Carbon::parse($masaKerja);
        $today = Carbon::now();

        $totalMasaKerjaMonths = $masaKerjaStart->diffInMonths($today);
        $masaKerjaYears = intdiv($totalMasaKerjaMonths, 12);
        $masaKerjaMonths = $totalMasaKerjaMonths % 12;

        // Format output untuk masa kerja
        $masaKerjaDuration = "{$masaKerjaYears} tahun, {$masaKerjaMonths} bulan";
        $set('masa_kerja_terkini', $masaKerjaDuration);
    } else {
        $set('masa_kerja_terkini', null);
    }
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

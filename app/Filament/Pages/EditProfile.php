<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class EditProfile extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Profil Saya';

    protected static ?string $navigationGroup = 'Profil';

    protected static ?string $modelLabel = 'Profil Saya';

    protected static ?string $pluralLabel = 'Profil Saya';


    protected static string $view = 'filament.pages.edit-profile';

    public $user;
    public $pegawai;
    public $nip;
    public $nama;
    public $komptensi;

    public function mount()
    {
        // Ambil data user yang sedang login
        $this->user = Auth::user();
        // Ambil data pegawai berdasarkan NIP
        $this->pegawai = $this->user->nip_pegawais;
        // dd($this->pegawai);
        $this->nip = $this->pegawai->nip ?? 'Tidak ditemukan';
        $this->nama = $this->pegawai->nama ?? 'Tidak ditemukan';
        $this->komptensi = $this->pegawai->komptensi ?? 'Tidak ditemukan';
        $this->form->fill([
            'nip' => $this->nip,
            'nama' => $this->nama,
            'komptensi' => $this->komptensi,
        ]);
    }


    protected function getFormSchema(): array
    {
        return [
            TextInput::make('nip')
                ->label('NIP')
                ->readOnly()
                ->live(true),
            TextInput::make('nama')
                ->label('Nama')
                ->readOnly()
                ->live(true),
            RichEditor::make('komptensi')
                ->label('Kompetensi')
                ->columnSpanFull()
                ->live(true),
        ];
    }

    public function save()
    {
        if ($this->pegawai) {
            $this->pegawai->update([
                'nip' => $this->nip,
                'nama' => $this->nama,
                'komptensi' => $this->komptensi,
            ]);
        }

        Notification::make()
        ->title('Profil berhasil diperbarui!')
        ->success()
        ->send();
    }

    protected function getActions(): array
    {
        return [];
    }

    protected function getFooterWidgets(): array
    {
        return [];
    }

    protected function getHeaderWidgets(): array
    {
        return [];
    }

}

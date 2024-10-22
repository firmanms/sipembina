<?php

namespace App\Filament\Widgets;

use App\Models\Pegawai;
use Filament\Widgets\ChartWidget;

class PendidikanChart extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Berdasarkan Pendidikan';

    protected function getData(): array
    {
        // Definisikan pendidikan yang ingin dihitung
        $pendidikanLabels = [
            'Belum Tamat SD/Sederajat',
            'Tamat SD/sederajat',
            'SLTP/sederajat',
            'SLTA/sederajat',
            'Diploma I/II',
            'Akademi/Diploma III/S.Muda',
            'Diploma IV/Strata I',
            'Strata II',
            'Strata III',
        ];

        // Hitung jumlah pegawai untuk masing-masing pendidikan
        $dataCounts = [];
        foreach ($pendidikanLabels as $pendidikan) {
            $dataCounts[] = Pegawai::where('pendidikan', $pendidikan)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pegawai',
                    'data' => $dataCounts,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $pendidikanLabels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

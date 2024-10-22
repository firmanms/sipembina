<?php

namespace App\Filament\Widgets;

use App\Models\Pegawai;
use Filament\Widgets\ChartWidget;

class PangkatChart extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Berdasarkan Pangkat/Golongan';

    protected function getData(): array
    {
        // Definisikan pangkat yang ingin dihitung
        $pangkatLabels = [
            'Pembina Utama IV e',
            'Pembina Utama Madya IV d',
            'Pembina Utama Muda IV c',
            'Pembina Tingkat I IV b',
            'Pembina IV a',
            'Penata Tingkat I III d',
            'Penata III c',
            'Penata Muda Tingkat I III b',
            'Penata Muda III a',
            'Pengatur Tingkat I II d',
            'Pengatur II c',
            'Pengatur Muda Tingkat I II b',
            'Pengatur Muda II a',
            'Juru Tingkat I I d',
            'Juru I c',
            'Juru Muda Tingkat I I b',
            'Juru Muda I a',
        ];

        // Hitung jumlah pegawai untuk masing-masing pangkat
        $dataCounts = [];
        foreach ($pangkatLabels as $pangkat) {
            $dataCounts[] = Pegawai::where('pangkat_gol', $pangkat)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pegawai',
                    'data' => $dataCounts,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $pangkatLabels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

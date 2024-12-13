@if (Auth::check())
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usulan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            line-height: 1.5;
        }
        .kop-container {
            display: flex;
            align-items: center;
            text-align: center;
            margin-bottom: 20px;
        }
        .kop-container img {
            width: 100px;
            margin-right: 20px;
        }
        .kop-text {
            flex: 1;
        }
        .kop-header {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .kop-subheader {
            margin: 0;
            font-size: 14px;
        }
        .kop-contact {
            margin: 11px 0 20px;
            font-size: 9px;
        }
        .line {
            border-top: 3px solid black;
            margin: 20px 0;
        }
        .content {
            font-size: 12px;
            text-align: justify;
        }
        .content p {
            margin: 10px 0;
        }
        .signature {
            font-size: 12px;
            margin-top: 50px;
            text-align: right;
            position: relative;
        }
        .signature div {
            display: inline-block;
            text-align: center;
        }
        .signature p {
            margin: 5px 0;
        }
        .tembusan {
            font-size: 12px;
            margin-top: 30px;
        }
        .qr-code {
            text-align: center;
            margin-top: 20px;
        }
        .footer {
            font-size: 10px;
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="kop-container">
        <img src="{{ asset('image/bandung.png') }}" alt="Logo">
        <div class="kop-text">
            <h1 class="kop-header">Pemerintah Kabupaten Bandung</h1>
            <h2 class="kop-header">Dinas Komunikasi Dan Informatika, Statistik Dan Persandian</h2>
            <p class="kop-subheader">Jl. Raya Soreang Km. 17 Soreang 40912 Jawa Barat</p>
            <p class="kop-contact">Telp: (022) 5891251, (022) 85871428 | Email: diskominfo@bandungkab.go.id | Website: www.diskominfo.bandungkab.go.id</p>
        </div>
    </div>
    <div class="line"></div>
    <div class="content">
        <center>DAFTAR USUL MUTASI, PROMOSI DAN LAIN SEBAGAINYA</center>
        <table border="0" width="100%">
            <tr>
                <td>1.</td>
                <td>TEMPAT PEKERJAAN</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>1.1 Kantor</td>
                <td>:</td>
                <td>Dinas Komunikasi Dan Informatika, Statistik Dan Persandian </td>
            </tr>
            <tr>
                <td></td>
                <td>1.2 Bagian/Bidang</td>
                <td>:</td>
                <td> {{ $pegawai->bagians->nama }} </td>
            </tr>

            <tr>
                <td>2.</td>
                <td>NAMA DAN USIA</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>2.1 Nama</td>
                <td>:</td>
                <td> {{ $pegawai->nama }} </td>
            </tr>
            <tr>
                <td></td>
                <td>2.2 NIP</td>
                <td>:</td>
                <td> {{ $pegawai->nip }} </td>
            </tr>
            <tr>
                <td></td>
                <td>2.3 Usia/Tanggal Lahir</td>
                <td>:</td>
                <td> {{ \Carbon\Carbon::parse($pegawai->tgl_lahir)->age }} Tahun / {{ \Carbon\Carbon::parse($pegawai->tgl_lahir)->format('d-m-Y') }}
                     </td>
            </tr>

            <tr>
                <td>3.</td>
                <td>PANGKAT</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>3.1 Pangkat Lama/Tanggal</td>
                <td>: </td>
                <td> {{ $pegawai->pangkat_gol }} / {{ \Carbon\Carbon::parse($pegawai->tgl_pangkat)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <td></td>
                <td>3.2 Pangkat yang diusulkan</td>
                <td>:</td>
                <td> {{ $pembinakarir->naik_pangkat_gol }} </td>
            </tr>
            <tr>
                <td></td>
                <td>3.3 Catatan Pangkat yang diusulkan</td>
                <td>:</td>
                <td> {!! $pembinakarir->catatan_naik !!} </td>
            </tr>


            <tr>
                <td>4.</td>
                <td>URAIAN TENTANG TUGAS PEKERJAAN/ JABATAN</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>4.1 Tugas pekerjaan dalam jabatan, pangkat lama</td>
                <td>:</td>
                <td> {{ $pegawai->jabatans->nama }} </td>
            </tr>
            <tr>
                <td></td>
                <td>4.2 Tugas pekerjaan dalam jabatan, pangkat yang diusulkan</td>
                <td>:</td>
                <td> {!! $pembinakarir->catatan_naik !!} </td>
            </tr>

            <tr>
                <td>5.</td>
                <td>LOWONGAN</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>Golongan ruang yang akan diisi dan diatasi </td>
                <td>:</td>
                <td> {{ $pembinakarir->naik_pangkat_gol }} </td>
            </tr>

            <tr>
                <td>6.</td>
                <td>URAIAN TENTANG ALASAN-ALASAN UNTUK MUTASI, PROMOSI DAN LAIN SEBAGAINYA</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>6.1 Usulan </td>
                <td>:</td>
                <td> {{ $pembinakarir->rotasi_mutasi }} </td>
            </tr>
            <tr>
                <td></td>
                <td>6.2 Jabatan Usulan</td>
                <td>:</td>
                <td> {!! $pembinakarir->catatan_rotasi_mutasi !!} </td>
            </tr>
            <tr>
                <td></td>
                <td>6.3 Catatan Jabatan Usulan</td>
                <td>:</td>
                <td> {!! $pembinakarir->catatan_jabatan !!} </td>
            </tr>

            <tr>
                <td>7.</td>
                <td>KETERANGAN LAIN</td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>7.1 Riwayat Pendidikan </td>
                <td>:</td>
                <td>
                    @if ($pegawai->riwayat_pendidikan_nip && $pegawai->riwayat_pendidikan_nip->count() > 0)
                        <ul>
                            @foreach ($pegawai->riwayat_pendidikan_nip as $pendidikan)
                                <li>{{ $pendidikan->nama_sekolah }} | {{ $pendidikan->jurusan }} ({{ \Carbon\Carbon::parse($pegawai->tgl_ijazah)->format('Y') }} )</li>
                            @endforeach
                        </ul>
                    @else
                        Tidak ada riwayat Pendidikan.
                    @endif
                </td>
            </tr>
            <tr>
                <td></td>
                <td>7.2 Riwayat Jabatan</td>
                <td>:</td>
                <td>
                    @if ($pegawai->riwayat_jabatan_nip && $pegawai->riwayat_jabatan_nip->count() > 0)
                        <ul>
                            @foreach ($pegawai->riwayat_jabatan_nip as $jabatan)
                                <li>{{ $jabatan->nama_jabatan }} | {{ $jabatan->unit_kerja }} | {{ $jabatan->satuan_kerja }} ({{ \Carbon\Carbon::parse($pegawai->tmt_jabatan)->format('d-m-Y') }} - {{ \Carbon\Carbon::parse($pegawai->akhir_jabatan)->format('d-m-Y') }} )</li>
                            @endforeach
                        </ul>
                    @else
                        Tidak ada riwayat jabatan.
                    @endif
                </td>
            </tr>
            <tr>
                <td></td>
                <td>7.3 Riwayat Pelatihan</td>
                <td>:</td>
                <td>
                    @if ($pegawai->riwayat_pelatihan_nip && $pegawai->riwayat_pelatihan_nip->count() > 0)
                        <ul>
                            @foreach ($pegawai->riwayat_pelatihan_nip as $pendidikan)
                                <li>{{ $pendidikan->nama_pelatihan }} | {{ $pendidikan->jurusan }} ({{ \Carbon\Carbon::parse($pegawai->tgl_ijazah)->format('Y') }} )</li>
                            @endforeach
                        </ul>
                    @else
                        Tidak ada riwayat pelatihan.
                    @endif
                 </td>
            </tr>
            <tr>
                <td></td>
                <td>7.4 Kompetensi</td>
                <td>:</td>
                <td> {!! $pegawai->komptensi !!} </td>
            </tr>

        </table>

    </div>
    <div class="signature">
        <div>
            <p>Soreang, {{ \Carbon\Carbon::parse($pegawai->tgl_aksi_kadis)->translatedFormat('d F Y') }}</p>
            <p>KEPALA DINAS KOMUNIKASI DAN</p>
            <p>INFORMATIKA, STATISTIK DAN PERSANDIAN</p>
            <img src="{{ asset('image/qrkadis.png') }}" width="150px" height="150px" alt="Logo">
            <p><strong>H YOSEP NUGRAHA, SH., M.I.P.</strong></p>
            <p>NIP. 197306281992021001</p>
        </div>
    </div>
    <div class="tembusan">
        <!-- <p>Tembusan:</p>
        <ol>
            <li>Asisten Pemerintahan dan Kesejahteraan Rakyat</li>
            <li>Plt Kepala Bagian Hukum</li>
            <li>Kepala Bidang Aplikasi Informatika</li>
        </ol> -->
    </div>
    <div class="qr-code">
        <!-- <img src="qrcode.png" alt="QR Code" style="width: 100px;"> -->
    </div>
    <div class="footer">
        <!-- Dokumen ini ditandatangani secara elektronik menggunakan Sertifikat Elektronik yang diterbitkan BSrE-BSSN ... -->
    </div>
</body>
</html>

@else
    @php
        abort(404);
    @endphp
@endif


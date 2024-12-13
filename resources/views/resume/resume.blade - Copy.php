@if (Auth::check())
<!DOCTYPE html>
    <html>
    <head>
    <style>
        .atable table, .atable th, .atable tr {
      border: 0px ;
    }
     .atable td {
      border: 0px ;
    }
    .btable table, .btable th, .btable td {
      border: 1px solid black;
      border-collapse: collapse;
      text-align: center;
      font-size:9pt;
    }

    table {
      border-collapse: collapse; /* Menghilangkan jarak antar sel */
      width: 100%; /* Opsional, untuk membuat tabel menyesuaikan lebar */
      /* text-align: center; */
      font-size:12pt;
    }

    th, td {
      border: 1px solid black; /* Menambahkan border pada th dan td */
      padding: 0; /* Menghilangkan padding agar lebih rapat */
      /* text-align: center; */
      font-size:12pt;
    }



    </style>
    </head>
    <body>

    <center><b>RESUME</b></center>
    <table width="100%">
        <tr>
            <td>NIP</td>
            <td>: {{ $pegawai->nip }}</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>: {{ $pegawai->nama }}</td>
        </tr>
        <tr>
            <td>Bagian</td>
            <td>: {{ $pegawai->bagians->nama }}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>: {{ $pegawai->jabatans->nama }}</td>
        </tr>


        <tr>
            <td colspan="2" align="center" bgcolor="yellow"><b>PEMETAAN KARIR</b></td>
        </tr>
        <tr>
            <td><b>Pangkat Sekarang</b></td>
            <td>: {{ $pegawai->pangkat_gol }}</td>
        </tr>
        <tr>
            <td><b>Pangkat Selanjutnya</b></td>
            <td>: {{ $pembinakarir->naik_pangkat_gol }}</td>
        </tr>
        <tr>
            <td><b>Catatan Naik Pangkat</b></td>
            <td align="midlle"> {!! $pembinakarir->catatan_naik !!}</td>
        </tr>
        <tr>
            <td><b>Catatan Jabatan Apabila di Pangkat Tersebut</b></td>
            <td align="midlle"> {!! $pembinakarir->catatan_jabatan !!}</td>
        </tr>

        <tr>
            <td colspan="2" align="center" bgcolor="yellow"><b>PELATIHAN PENGEMBANGAN</b></td>
        </tr>
        <tr>
            <td><b>Pendidikan Terakhir</b> <br>{{ $pegawai->pendidikan }} - {{ $pegawai->jurusan }}</td>
            <td><b>Catatan Pendidikan</b> <br> {!! $pembinakarir->catatan_pendidikan !!}</td>
        </tr>
        <tr>
            <td><b>Kompetensi Sekarang</b> <br> {!! $pegawai->komptensi !!}</td>
            <td><b>Kompetensi yang Dibutuhkan</b> <br> {!! $pembinakarir->kompetensi_dibutuhkan !!}</td>
        </tr>
        <tr>
            <td><b>Riwayat Pelatihan</b> <br> {!! $pegawai->riwayat_pelatihan !!}</td>
            <td><b>Usulan Pelatihan</b> <br> {!! $pembinakarir->usulan_pelatihan !!}</td>
        </tr>

        <tr>
            <td colspan="2" align="center" bgcolor="yellow"><b>PENILAIAN KINERJA</b></td>
        </tr>
        <tr>
            <td><b>Output Kinerja</b> <br>{!! $pegawai->output_kinerja !!}</td>
            <td><b>Realisasi Kinerja</b> <br> {!! $pembinakarir->realisasi_kinerja !!}</td>
        </tr>

        <tr>
            <td colspan="2" align="center" bgcolor="yellow"><b>ROTASI MUTASI</b></td>
        </tr>
        <tr>
            <td><b>Saran</b> <br> {!! $pembinakarir->rotasi_mutasi !!}</td>
            <td><b>Catatan Rotasi  Mutasi</b> <br> {!! $pembinakarir->catatan_rotasi_mutasi !!}</td>
        </tr>

    </table>
    </body>
    </html>
@else
    @php
        abort(404);
    @endphp
@endif


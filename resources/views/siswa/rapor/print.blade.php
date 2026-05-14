<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapor {{ $siswa->nama_lengkap }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #333; padding: 6px; }
        th { background: #f0f0f0; }
        .header { border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header text-center">
        <h2>RAPOR PESERTA DIDIK</h2>
        <h3>SMK MUHAMMADIYAH 2 SEMARANG</h3>
        <p>Tahun Ajaran {{ $tahunAjaran?->tahun ?? '-' }} - Semester {{ $tahunAjaran?->semester ?? '-' }}</p>
    </div>

    <table style="border: none; margin-bottom: 20px;">
        <tr style="border: none;">
            <td style="border: none; width: 50%;">
                <p>Nama: <strong>{{ $siswa->nama_lengkap }}</strong></p>
                <p>NIS: {{ $siswa->nis }}</p>
                <p>Kelas: {{ $siswa->kelas?->nama_kelas ?? '-' }}</p>
            </td>
            <td style="border: none; width: 50%;">
                <p>Jurusan: {{ $siswa->kelas?->jurusan->nama_jurusan ?? '-' }}</p>
                <p>Wali Kelas: {{ $siswa->kelas?->waliKelas?->nama_lengkap ?? '-' }}</p>
            </td>
        </tr>
    </table>

    @foreach($nilais->groupBy('semester') as $semester => $nilaiList)
    <h4>Semester {{ $semester }}</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Mata Pelajaran</th>
                <th>KKM</th>
                <th>Nilai</th>
                <th>Predikat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nilaiList as $i => $nilai)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $nilai->mataPelajaran->nama_mapel }}</td>
                <td>{{ $nilai->mataPelajaran->kkm }}</td>
                <td>{{ number_format($nilai->nilai_akhir, 2) }}</td>
                <td>{{ $nilai->predikat }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endforeach

    <div style="margin-top: 40px;">
        <table style="border: none;">
            <tr style="border: none;">
                <td style="border: none; width: 50%; text-align: center;">
                    <p>Orang Tua / Wali</p>
                    <br><br><br>
                    <p>(_________________)</p>
                </td>
                <td style="border: none; width: 50%; text-align: center;">
                    <p>Semarang, {{ now()->format('d F Y') }}</p>
                    <p>Wali Kelas</p>
                    <br><br><br>
                    <p><strong>{{ $siswa->kelas?->waliKelas?->nama_lengkap ?? '(_________________)' }}</strong></p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
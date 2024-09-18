<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Piket Harian</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        font-size: 10px;
        margin: 0px;
        position: relative;
        min-height: 100%;
        padding-bottom: 100px; /* Tambahkan padding bawah untuk ruang footer */
      }
      table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
      }
      /* Style for tables with borders */
      .table-border {
        border: 1px solid black;
      }
      .table-border th, .table-border td {
        border: 1px solid black;
      }
      /* Style for tables without borders */
      .table-borderless {
        border: none;
      }
      .table-borderless th, .table-borderless td {
        border: none;
      }
      /* Override table-borderless for child tables */
      .table-borderless .table-border {
        border: 1px solid black;
      }
      .table-borderless .table-border th,
      .table-borderless .table-border td {
        border: 1px solid black;
      }
      .center-text {
        text-align: center;
      }
      th, td {
        padding: 5px;
        text-align: center;
      }
      th {
        background-color: #f2f2f2;
      }
      .title {
        text-align: center;
        margin-bottom: 20px;
      }
      .signature {
        margin-top: 50px;
        display: flex;
        justify-content: space-between;
      }
      .signature div {
        text-align: center;
        width: 40%;
      }
      .signature .line {
        border-top: 1px solid black;
        margin-top: 50px;
      }
      .kop-surat {
        text-align: center;
        margin-bottom: 20px;
      }
      .kop-surat img {
        max-width: 100%;
        height: auto;
      }
      @page {
        size: 210mm 330mm;
        /* margin: 20px; Mengatur margin sempit (narrow) untuk semua sisi */
        margin: 0px 15px 10px 25px; /* Atas 5px, Kanan 15px, Bawah 10px, Kiri 15px */
      }
      /* Footer Styling */
      footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        text-align: center;
        font-size: 8px;
        padding-bottom: 10px;
      }
    </style>
  </head>
  <body>
    <div class="kop-surat">
      @if($imageSrc)
      <img src="{{ $imageSrc }}" alt="Kop Surat">
      @else
      <p>Kop surat tidak tersedia.</p>
      @endif
    </div>
    <h1 class="center-text" style="margin-bottom: 0px;">AGENDA PIKET HARIAN (KBM)</h1>
    <h3 class="center-text"><strong>HARI/TANGGAL:</strong> {{ \Carbon\Carbon::parse($agendaPiket->tanggal)->translatedFormat('l, d-m-Y') }}</h3>
    
    <h2>A. ABSENSI SISWA</h2>
    <!-- Tabel Utama untuk meletakkan 3 tabel absensi per tingkat dalam satu baris -->
    <table class="table-borderless">
      <tr>
        <!-- Kolom untuk Tingkat 10 -->
        <td>
          <table class="table-border">
            <thead>
              <tr>
                <th>No</th>
                <th>Kelas</th>
                <th>Sakit</th>
                <th>Izin</th>
                <th>Alpa</th>
              </tr>
            </thead>
            <tbody>
              @php $totalSakit10 = 0; $totalIzin10 = 0; $totalAlpa10 = 0; @endphp
              @foreach($kelas->where('tingkat', 10) as $index => $kelasItem)
              <tr>
                <td>{{ $loop->index+1 }}</td>
                <td>{{ $kelasItem->nama_kelas }}</td>
                <td>{{ $absensiPerKelas[$kelasItem->id]['sakit'] ?? 0 }}</td>
                <td>{{ $absensiPerKelas[$kelasItem->id]['izin'] ?? 0 }}</td>
                <td>{{ $absensiPerKelas[$kelasItem->id]['alpa'] ?? 0 }}</td>
              </tr>
              @php
              $totalSakit10 += $absensiPerKelas[$kelasItem->id]['sakit'] ?? 0;
              $totalIzin10 += $absensiPerKelas[$kelasItem->id]['izin'] ?? 0;
              $totalAlpa10 += $absensiPerKelas[$kelasItem->id]['alpa'] ?? 0;
              @endphp
              @endforeach
              <tr>
                <td colspan="2" style="text-align: right; font-weight: bold;">Jumlah</td>
                <td>{{ $totalSakit10 }}</td>
                <td>{{ $totalIzin10 }}</td>
                <td>{{ $totalAlpa10 }}</td>
              </tr>
            </tbody>
          </table>
        </td>
        <!-- Kolom untuk Tingkat 11 -->
        <td>
          <table class="table-border">
            <thead>
              <tr>
                <th>No</th>
                <th>Kelas</th>
                <th>Sakit</th>
                <th>Izin</th>
                <th>Alpa</th>
              </tr>
            </thead>
            <tbody>
              @php $totalSakit11 = 0; $totalIzin11 = 0; $totalAlpa11 = 0; @endphp
              @foreach($kelas->where('tingkat', 11) as $index => $kelasItem)
              <tr>
                <td>{{ $loop->index+1 }}</td>
                <td>{{ $kelasItem->nama_kelas }}</td>
                <td>{{ $absensiPerKelas[$kelasItem->id]['sakit'] ?? 0 }}</td>
                <td>{{ $absensiPerKelas[$kelasItem->id]['izin'] ?? 0 }}</td>
                <td>{{ $absensiPerKelas[$kelasItem->id]['alpa'] ?? 0 }}</td>
              </tr>
              @php
              $totalSakit11 += $absensiPerKelas[$kelasItem->id]['sakit'] ?? 0;
              $totalIzin11 += $absensiPerKelas[$kelasItem->id]['izin'] ?? 0;
              $totalAlpa11 += $absensiPerKelas[$kelasItem->id]['alpa'] ?? 0;
              @endphp
              @endforeach
              <tr>
                <td colspan="2" style="text-align: right; font-weight: bold;">Jumlah</td>
                <td>{{ $totalSakit11 }}</td>
                <td>{{ $totalIzin11 }}</td>
                <td>{{ $totalAlpa11 }}</td>
              </tr>      
            </tbody>
          </table>
        </td>
        <!-- Kolom untuk Tingkat 12 -->
        <td>
          <table class="table-border">
            <thead>
              <tr>
                <th>No</th>
                <th>Kelas</th>
                <th>Sakit</th>
                <th>Izin</th>
                <th>Alpa</th>
              </tr>
            </thead>
            <tbody>
              @php $totalSakit12 = 0; $totalIzin12 = 0; $totalAlpa12 = 0; @endphp
              @foreach($kelas->where('tingkat', 12) as $index => $kelasItem)
              <tr>
                <td>{{ $loop->index+1 }}</td>
                <td>{{ $kelasItem->nama_kelas }}</td>
                <td>{{ $absensiPerKelas[$kelasItem->id]['sakit'] ?? 0 }}</td>
                <td>{{ $absensiPerKelas[$kelasItem->id]['izin'] ?? 0 }}</td>
                <td>{{ $absensiPerKelas[$kelasItem->id]['alpa'] ?? 0 }}</td>
              </tr>
              @php
              $totalSakit12 += $absensiPerKelas[$kelasItem->id]['sakit'] ?? 0;
              $totalIzin12 += $absensiPerKelas[$kelasItem->id]['izin'] ?? 0;
              $totalAlpa12 += $absensiPerKelas[$kelasItem->id]['alpa'] ?? 0;
              @endphp
              @endforeach
              <tr>
                <td colspan="2" style="text-align: right; font-weight: bold;">Jumlah</td>
                <td>{{ $totalSakit12 }}</td>
                <td>{{ $totalIzin12 }}</td>
                <td>{{ $totalAlpa12 }}</td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </table>
    <!-- Persentase Absensi Per Tingkat dan Total -->
    <table class="table-border">
      <thead>
        <tr>
          <th width="150px">Jumlah Siswa yang Tidak hadir</th>
          <th>Kelas X</th>
          <th>Kelas XI</th>
          <th>Kelas XII</th>
          <th>Total Persentase</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Persentase</td>
          <td>{{ number_format($persentase['10']['sakit'] + $persentase['10']['izin'] + $persentase['10']['alpa'], 2) }}%</td>
          <td>{{ number_format($persentase['11']['sakit'] + $persentase['11']['izin'] + $persentase['11']['alpa'], 2) }}%</td>
          <td>{{ number_format($persentase['12']['sakit'] + $persentase['12']['izin'] + $persentase['12']['alpa'], 2) }}%</td>
          <td>{{ number_format($persentaseTotalAbsen, 2) }}%</td>
        </tr>
      </tbody>
    </table>
    <!-- Catatan Kejadian -->
    <h2>B. CATATAN KEJADIAN</h2>
    <p><strong>I. Kejadian Normal:</strong> </p>
    <table class="table-border">
      <tbody>
        <tr>
          <td style="text-align: left;">{{ $agendaPiket->kejadian_normal ?: '-' }}</td>
        </tr>
      </tbody>
    </table>
    <p><strong>II. Kejadian Masalah:</strong> </p>
    <table class="table-border">
      <tr>
        <td><strong>Uraian Kejadian / Masalah</strong></td>
        <td><strong>Solusi / Penanggulangan</strong></td>
      </tr>
      <tr>
        <td>{{ $agendaPiket->kejadian_masalah ?: '-' }}</td>
        <td>{{ $agendaPiket->solusi ?: '-' }}</td>
      </tr>
    </table>
    <!-- Tanda Tangan Section -->
    <table class="table-borderless">
      <tr>
        <td class="center-text">KESISWAAN</td>
        <td class="center-text">PETUGAS PIKET 1</td>
        <td class="center-text">PETUGAS PIKET 2</td>
      </tr>
      <tr>
        <td class="center-text">
          <div class="signature">______________________</div>
        </td>
        <td class="center-text">
          <div class="signature">______________________</div>
        </td>
        <td class="center-text">
          <div class="signature">______________________</div>
        </td>
      </tr>
      <tr>
        <td class="center-text">
          <!-- Nama Kesiswaan -->
          {{ $profilSekolah->kesiswaan->nama_lengkap ?? 'Nama Kesiswaan' }}
        </td>
        <td class="center-text">{{ $guruPiket[0] ?? '' }}</td>
        <td class="center-text">{{ $guruPiket[1] ?? '' }}</td>
      </tr>
      <tr>
        <td colspan="3" class="center-text"></td>
      </tr>
      <tr>
        <td colspan="3" class="center-text"></td>
      </tr>
      <tr>
        <td colspan="3" class="center-text"><b>Mengetahui,</b></td>
      </tr>
      <tr>
        <td colspan="3" class="center-text" style="margin-bottom: 60px;"><b>Kepala Sekolah</b></td>
      </tr>
      <tr>
        <td colspan="3" class="center-text" style="padding-top: 60px;"><u>{{ $profilSekolah->kepalaSekolah->nama_lengkap ?? 'Nama Kepala Sekolah' }}</u><br>{{ $profilSekolah->kepalaSekolah->nip ?? 'NIP' }}</td>
      </tr>

    </table>
    
    <footer>
      <p>Dicetak pada {{ now()->format('d-m-Y H:i') }}</p>
    </footer>
  </body>
</html>
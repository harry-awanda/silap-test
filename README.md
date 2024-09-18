<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumentasi Aplikasi SILAP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        h1, h2, h3 {
            color: #2c3e50;
        }
        p {
            margin-bottom: 15px;
        }
        code {
            background-color: #ecf0f1;
            padding: 2px 4px;
            border-radius: 4px;
        }
        pre {
            background-color: #ecf0f1;
            padding: 15px;
            border-radius: 8px;
            overflow-x: auto;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dokumentasi Aplikasi SILAP</h1>

        <h2>Pendahuluan</h2>
        <p>SILAP adalah aplikasi manajemen sekolah berbasis web yang dibangun dengan Laravel. Aplikasi ini mencakup pengelolaan data guru, siswa, pelanggaran, absensi, dan agenda piket, serta manajemen pengguna dan role.</p>

        <h2>Instalasi</h2>
        <ol>
            <li><strong>Clone repositori:</strong></li>
            <pre><code>git clone https://github.com/harry-awanda/silap-test.git</code></pre>
            
            <li><strong>Masuk ke direktori proyek:</strong></li>
            <pre><code>cd silap-test</code></pre>

            <li><strong>Install dependencies:</strong></li>
            <pre><code>composer install</code></pre>
            <pre><code>npm install</code></pre>

            <li><strong>Buat file .env:</strong></li>
            <pre><code>cp .env.example .env</code></pre>

            <li><strong>Generate key:</strong></li>
            <pre><code>php artisan key:generate</code></pre>

            <li><strong>Migrasi database:</strong></li>
            <pre><code>php artisan migrate</code></pre>

            <li><strong>Jalankan server lokal:</strong></li>
            <pre><code>php artisan serve</code></pre>
        </ol>

        <h2>Fitur Utama</h2>
        <ul>
            <li><strong>Manajemen Pengguna</strong>: Admin dapat menambah, mengedit, dan menghapus pengguna. Role pengguna menentukan akses mereka ke fitur aplikasi.</li>
            <li><strong>Manajemen Guru</strong>: Pengelolaan data guru oleh admin, termasuk pembuatan akun login.</li>
            <li><strong>Manajemen Siswa</strong>: CRUD data siswa dan fitur import melalui upload file.</li>
            <li><strong>Pelanggaran Siswa</strong>: `guru_bk` mengelola pelanggaran, sementara guru biasa hanya bisa melihat pelanggaran siswa mereka.</li>
            <li><strong>Absensi Siswa</strong>: Dikelola oleh `guru_piket`, termasuk rekap absensi dan ekspor ke PDF.</li>
            <li><strong>Agenda Piket</strong>: Manajemen agenda piket, absensi per kelas, dan ekspor PDF dengan tanda tangan guru piket.</li>
        </ul>

        <h2>Struktur Folder</h2>
        <ul>
            <li><strong>app/Http/Controllers</strong>: Mengelola kontrol logika bisnis aplikasi.</li>
            <li><strong>app/Models</strong>: Berisi model untuk entitas seperti `User`, `Guru`, `Siswa`, dll.</li>
            <li><strong>resources/views</strong>: Blade templates untuk antarmuka pengguna.</li>
            <li><strong>routes/web.php</strong>: Mendefinisikan rute HTTP.</li>
        </ul>

        <h2>Manajemen Role dan Akses</h2>
        <p>Aplikasi menggunakan middleware custom <code>checkRole</code> untuk mengelola akses berdasarkan peran pengguna. Role menentukan fitur mana yang bisa diakses oleh pengguna.</p>

        <h2>Pengujian</h2>
        <p>Jalankan perintah berikut untuk melakukan pengujian:</p>
        <pre><code>php artisan test</code></pre>

        <h2>Kesimpulan</h2>
        <p>Aplikasi SILAP membantu mempermudah pengelolaan sekolah dengan fitur yang terstruktur dan pembatasan akses berdasarkan role pengguna. Dengan menggunakan Laravel, aplikasi ini fleksibel dan mudah dikembangkan lebih lanjut.</p>
    </div>
</body>
</html>

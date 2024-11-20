<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Sertifikat</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .sertifikat-container {
            position: relative;
            width: 100%;
            height: 100vh;
            background: url('{{ asset('img/sertifikat.jpg') }}') no-repeat center center;
            background-size: cover;
        }
        .nama-penerima {
            position: absolute;
            top: 40%; /* Atur posisi vertikal */
            left: 50%; /* Atur posisi horizontal */
            transform: translate(-50%, -50%);
            font-size: 4rem; /* Atur ukuran font */
            color: #333; /* Warna teks */
            font-family: 'Times New Roman', Times, serif;
            font-weight: bold;
            text-align: center;
        }
    </style>
    <script type="text/javascript">
        window.onload = function() {
            window.print(); // Memanggil fungsi cetak otomatis setelah halaman dimuat
        };
    </script>
</head>
<body>
    <div class="sertifikat-container">
        <div class="nama-penerima">
            {{ $anggota->nama }}
        </div>
    </div>
</body>
</html>

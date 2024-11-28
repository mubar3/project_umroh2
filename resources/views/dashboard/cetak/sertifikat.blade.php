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
            top: 32%; /* Atur posisi vertikal */
            left: 50%; /* Atur posisi horizontal */
            transform: translate(-50%, -50%);
            font-size: 4rem; /* Atur ukuran font */
            color: #333; /* Warna teks */
            font-family: 'Times New Roman', Times, serif;
            font-weight: bold;
            text-align: center;
            white-space: nowrap;
        }
        .garis-bawah {
            position: absolute;
            top: 36%; /* Sesuaikan posisi */
            left: 50%;
            transform: translateX(-50%);
            width: 50%; /* Lebar garis */
            border-top: 3px solid #333; /* Ketebalan dan warna garis */
        }
        .no-id {
            position: absolute;
            top: 38%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 3rem;
            color: #333;
            font-family: 'Times New Roman', Times, serif;
            text-align: center;
            font-weight: bold;
        }
        .tempat-tanggal-lahir {
            position: absolute;
            top: 42.5%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 3rem;
            color: #333;
            font-family: 'Times New Roman', Times, serif;
            text-align: center;
            font-weight: bold;
        }
        .leader {
            position: absolute;
            top: 47%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 3rem;
            color: #333;
            font-family: 'Times New Roman', Times, serif;
            text-align: center;
            font-weight: bold;
            white-space: nowrap;
            /* position: absolute;
            top: 44%;
            width: 70%;
            display: flex;
            justify-content: space-between;
            font-size: 1.8rem;
            color: #333;
            font-family: 'Times New Roman', Times, serif;
            left: 50%;
            transform: translateX(-50%);
            padding: 0 5%; */
        }
        .kotak-foto {
            position: absolute;
            bottom: 5%; /* Atur jarak dari bawah */
            left: 30%; /* Atur jarak dari kiri */
            width: 6cm; /* Lebar 3 cm (sekitar 90px) */
            height: 8cm; /* Tinggi 4 cm (sekitar 120px) */
            overflow: hidden; /* Agar foto tidak keluar dari kotak */
            border-radius: 5px; /* Membuat sudut melengkung pada kotak */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2); /* Bayangan pada kotak */
        }

        .kotak-foto img {
            width: 100%; /* Gambar memenuhi lebar kotak */
            height: 100%; /* Gambar memenuhi tinggi kotak */
            object-fit: cover; /* Memastikan gambar tetap proporsional dan terpotong jika perlu */
            border-radius: 5px; /* Sudut gambar melengkung sesuai kotak */
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
        <!-- Nama penerima -->
        <div class="nama-penerima">
            {{ $anggota->nama }}
        </div>

        <!-- Garis bawah -->
        <div class="garis-bawah"></div>

        <!-- Nomor ID -->
        <div class="no-id">
            No.Id.({{ $anggota->id_anggota }}){{ substr(preg_replace('/[^0-9]/', '', hash('sha1', $anggota->id)),0,12) }}.{{ strtotime($anggota->input_time) }}
        </div>

        <!-- Tempat dan tanggal lahir -->
        <div class="tempat-tanggal-lahir">
            {{ strtoupper($anggota->tempat_lahir) }}, {{ $anggota->tanggal_lahir }}
        </div>

        <!-- Nama Leader -->
        <div class="leader">
            {{-- <div class="leader-kiri"> --}}
                ~ Leader : {{ $anggota->nama_leader }}
                &nbsp;&nbsp;&nbsp;
            {{-- </div>
            <div class="leader-kanan"> --}}
                ~ Top Leader : {{ $anggota->nama_top_leader }}
            {{-- </div> --}}
        </div>
        <div class="kotak-foto">
            <div class="foto"><img src="{{ $anggota->foto }}" alt="Foto 1"></div>
        </div>
    </div>
</body>
</html>

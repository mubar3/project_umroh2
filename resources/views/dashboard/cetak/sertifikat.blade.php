<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
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
            top: 34%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 2rem;
            color: #000;
            font-family: 'Times New Roman', Times, serif;
            font-weight: bold;
            text-align: center;
            white-space: nowrap;
        }
        .garis-bawah {
            position: absolute;
            top: 36%;
            left: 50%;
            transform: translateX(-50%);
            width: 50%;
            border-top: 3px solid #000;
        }
        .no-id, .tempat-tanggal-lahir {
            position: absolute;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1.5rem;
            color: #000;
            font-family: 'Times New Roman', Times, serif;
            text-align: center;
            font-weight: bold;
        }
        .no-id { top: 38.5%; }
        .tempat-tanggal-lahir { top: 42.5%; }
        .leader {
            position: absolute;
            top: 47%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            justify-content: center;
            gap: 2rem; /* Jarak antar teks */
            font-size: 1.2rem;
            color: #000;
            font-family: 'Times New Roman', Times, serif;
            font-weight: bold;
        }
        .leader-text {
            /* max-width: 35%; /* Batasi lebar masing-masing teks */
            white-space: nowrap; /* Jangan biarkan teks pindah baris */
            overflow: hidden; /* Sembunyikan teks yang terlalu panjang */
            text-overflow: ellipsis; /* Tambahkan "..." untuk teks yang dipotong */
            text-align: center;
        }
        .kotak-foto {
            position: absolute;
            bottom: 7%;
            left: 30%;
            /* width: 6cm; */
            height: 5cm;
            overflow: hidden;
            border-radius: 5px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        }
        .kotak-foto img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 5px;
        }
        @media print {
            .sertifikat-container {
                background-size: contain;
            }
            .nama-penerima, .no-id, .tempat-tanggal-lahir, .leader {
                color: #000;
            }
        }
    </style>
    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 1000);
        };
    </script>
</head>
<body>
    <div class="sertifikat-container">
        <!-- Nama Penerima -->
        <div class="nama-penerima">{{ $anggota->nama }}</div>
        <!-- Garis Bawah -->
        <div class="garis-bawah"></div>
        <!-- Nomor ID -->
        <div class="no-id">
            No.Id.({{ $anggota->id_anggota }}){{ substr(preg_replace('/[^0-9]/', '', hash('sha1', $anggota->id)),0,12) }}.{{ strtotime($anggota->input_time) }}
        </div>
        <!-- Tempat dan Tanggal Lahir -->
        <div class="tempat-tanggal-lahir">{{ strtoupper($anggota->tempat_lahir) }}, {{ $anggota->tanggal_lahir }}</div>
        <!-- Nama Leader -->
        <div class="leader">
            <div class="leader-text">~ Leader: {{ $anggota->nama_leader }}</div>
            <div class="leader-text">~ Top Leader: {{ $anggota->nama_top_leader }}</div>
        </div>
        <!-- Kotak Foto -->
        <div class="kotak-foto">
            <img src="{{ $anggota->foto }}" alt="Foto">
        </div>
    </div>
</body>
</html>

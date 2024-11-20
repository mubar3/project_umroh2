<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .id-card-container {
            width: 70mm; /* Lebar ID card 1/6 dari kertas HVS */
            height: 118mm; /* Tinggi ID card 1/6 dari kertas HVS */
            border: 2px solid #333;
            border-radius: 10px;
            position: relative;
            padding: 10px;
            background-image: url('{{ asset('img/kartu.jpg') }}'); /* Gambar latar belakang */
            background-size: cover; /* Agar gambar menutupi seluruh ID card */
            background-position: center; /* Posisi gambar di tengah */
            font-family: Arial, sans-serif;
        }
        .foto-profil {
            width: 40mm; /* Lebar foto diperbesar sedikit */
            height: 40mm; /* Tinggi foto diperbesar sedikit */
            border-radius: 50%; /* Membuat foto bundar */
            overflow: hidden;
            border: 2px solid #333;
            position: absolute;
            top: 37mm; /* Pindahkan lebih ke bawah */
            left: 52%;
            transform: translateX(-50%); /* Menempatkan foto di tengah secara horizontal */
        }
        .foto-profil img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .id-card-info {
            text-align: center;
            position: absolute;
            top: 80mm; /* Menempatkan nama tepat di bawah foto */
            left: 50%;
            transform: translateX(-50%); /* Menempatkan nama di tengah secara horizontal */
        }
        .id-card-info h2 {
            margin: 5px 0;
            font-size: 1.1rem;
            color: black; /* Warna teks putih agar terlihat jelas di atas latar belakang */
        }
        .id-card-info p {
            margin: 2px 0;
            font-size: 0.9rem;
            color: #fff;
        }
        .id-card-info .id-number {
            font-size: 1rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="id-card-container">
        <div class="foto-profil">
            <!-- Foto profil yang diambil dari controller -->
            <img src="{{ $anggota->foto }}" alt="Foto Profil">
        </div>
        <div class="id-card-info">
            {{-- <h2>{{ $anggota->nama }}</h2> --}}
            {{-- <p class="id-number">ID: {{ $anggota->id }}</p> --}}
            {{-- <p>Email: {{ $user->email }}</p> --}}
            {{-- <p>Nomor HP: {{ $user->nomor_hp }}</p> --}}
        </div>
    </div>

    <script type="text/javascript">
        window.onload = function() {
            window.print(); // Memanggil fungsi cetak otomatis
        };
    </script>
</body>
</html>

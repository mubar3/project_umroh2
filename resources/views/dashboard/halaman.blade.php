@include('dashboard.layout.head')
@include('dashboard.layout.menu')

{{-- halaman utama --}}
@if($halaman == 'home')
    @include('dashboard.halaman.home')
@elseif($halaman == 'tambah_anggota')
    @include('dashboard.halaman.tambah_anggota')
@elseif($halaman == 'daftar_anggota')
    @include('dashboard.halaman.daftar_anggota')
@endif

{{-- footer --}}
@include('dashboard.layout.footer')


{{-- ajax --}}
@if($halaman == 'daftar_anggota')
    @include('dashboard.halaman.ajax.daftar_anggota')
@elseif($halaman == 'tambah_anggota')
    @include('dashboard.halaman.ajax.tambah_anggota')
@endif

@include('dashboard.halaman.ajax.default')

@include('dashboard.layout.head')
@include('dashboard.layout.menu')

@if($halaman == 'home')
    @include('dashboard.halaman.home')
@elseif($halaman == 'tambah_anggota')
    @include('dashboard.halaman.tambah_anggota')
@endif

@include('dashboard.layout.footer')

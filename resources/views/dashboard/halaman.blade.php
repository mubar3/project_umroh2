@include('dashboard.layout.head')
@include('dashboard.layout.menu')

{{-- halaman utama --}}
@if($halaman == 'home')
    @include('dashboard.halaman.home')
@elseif($halaman == 'tambah_anggota')
    @include('dashboard.halaman.tambah_anggota')
@elseif($halaman == 'daftar_anggota')
    @include('dashboard.halaman.daftar_anggota')
@elseif($halaman == 'tambah_user')
    @include('dashboard.halaman.tambah_user')
@elseif($halaman == 'daftar_user')
    @include('dashboard.halaman.daftar_user')
@elseif($halaman == 'tabungan')
    @include('dashboard.halaman.tabungan')
@endif

{{-- footer --}}
@include('dashboard.layout.footer')


{{-- ajax --}}
@if($halaman == 'daftar_anggota')
    @include('dashboard.halaman.ajax.daftar_anggota')
@elseif($halaman == 'tambah_anggota')
    @include('dashboard.halaman.ajax.tambah_anggota')
@elseif($halaman == 'home')
    @include('dashboard.halaman.ajax.home')
@elseif($halaman == 'tambah_user')
    @include('dashboard.halaman.ajax.tambah_user')
@elseif($halaman == 'daftar_user')
    @include('dashboard.halaman.ajax.daftar_user')
@elseif($halaman == 'tabungan')
    @include('dashboard.halaman.ajax.tabungan')
@endif

@include('dashboard.halaman.ajax.default')

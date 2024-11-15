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
@elseif($halaman == 'setoran')
    @include('dashboard.halaman.setoran')
@elseif($halaman == 'hutang')
    @include('dashboard.halaman.hutang')
@elseif($halaman == 'uang_keluar')
    @include('dashboard.halaman.uang_keluar')
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
@elseif($halaman == 'setoran')
    @include('dashboard.halaman.ajax.setoran')
@elseif($halaman == 'hutang')
    @include('dashboard.halaman.ajax.hutang')
@elseif($halaman == 'uang_keluar')
    @include('dashboard.halaman.ajax.uang_keluar')
@endif

@include('dashboard.halaman.ajax.default')

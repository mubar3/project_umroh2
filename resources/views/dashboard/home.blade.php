@include('dashboard.layout.head')
@include('dashboard.layout.menu')


    <!-- Konten Utama -->
    <div class="content" id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <button class="btn btn-primary btn-lg" style="background-color: #026537" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>

                {{-- <li style="background-color:#34495e;"> --}}
                    {{-- <a href="#" onclick="toggleSidebar()"><i class="fas fa-bars"></i></a> --}}
                {{-- </li> --}}
            </nav>

            <div class="row">
                <div class="col-md-12">
                <div class="box box-solid">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <!-- Carousel indicators -->
                        {{-- <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        </ol> --}}

                        <!-- Carousel items -->
                        <div class="carousel-inner">
                            <div class="carousel-item active"> <!-- Ganti 'item' menjadi 'carousel-item' -->
                                <img src="{{ asset('img/slidex1.jpg') }}" alt="First slide" class="d-block w-100"> <!-- Ganti 'img-thumbnail' menjadi 'd-block w-100' -->
                                <div class="carousel-caption">
                                    {{-- <h4>Caption for First Slide</h4> <!-- Tambahkan teks caption --> --}}
                                </div>
                            </div>
                            <div class="carousel-item"> <!-- Ganti 'item' menjadi 'carousel-item' -->
                                <img src="{{ asset('img/slidex.jpg') }}" alt="Tree slide" class="d-block w-100"> <!-- Ganti 'img-thumbnail' menjadi 'd-block w-100' -->
                                <div class="carousel-caption">
                                    {{-- <h4>Caption for Second Slide</h4> <!-- Tambahkan teks caption --> --}}
                                </div>
                            </div>
                        </div>

                        <!-- Controls -->
                        <a class="carousel-control-prev" href="#carousel-example-generic" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carousel-example-generic" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>


                </div>
                <div class="callout callout-success" style="background-image:url({{ asset('img/head.png') }});">
                    <marquee>Selamat datang di Aplikasi<label class="label bg-green"></label></marquee>
                </div>

                <div class="row"> <!-- Tambahkan div row untuk menampung kolom -->
                    <div class="col-md-6">
                        <div class="info-box bg-yellow">
                            <span class="info-box-icon"><i class="fa fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">DATABASE ANGGOTA</span>
                                <span class="info-box-number">Anggota</span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                                <span class="progress-description">
                                    <marquee direction="up" scrollamount="1">Data ini akan bertambah jika telah dilakukan penginputan data kembali oleh administrator sistem</marquee>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-box bg-yellow">
                            <span class="info-box-icon"><i class="fa fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">INPUTAN DATABASE ANGGOTA HARI INI</span>
                                <span class="info-box-number">Anggota</span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                                <span class="progress-description">
                                    <marquee direction="up" scrollamount="1">Data ini akan bertambah jika telah dilakukan penginputan data kembali oleh administrator sistem</marquee>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
            <footer class="footer">
                {{-- <div class="pull-right hidden-xs">
                    <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">Powered by KARTANU</marquee> -->
                </div> --}}
                {{-- <p>&copy; 2024 Perusahaan Anda. Semua hak dilindungi.</p> --}}
                <b> <i class="fa fa-copyright"></i> Copyright <?php echo date("Y");?></b>.
            </footer>
    </div>

@include('dashboard.layout.footer')

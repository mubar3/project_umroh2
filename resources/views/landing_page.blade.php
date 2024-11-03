<!DOCTYPE html>
<html lang="en" class="ie_11_scroll">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        {{-- <meta name="viewport" content="hhhwidth=device-width, initial-scale=1"> --}}
        <link rel="icon" type="image/png" href="{{ asset('img/logo.jpg') }}">
        <title>PT ASH SHOFWAH GROUP</title>
        <link rel="stylesheet" href="{{ asset('asset_landing_page/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('asset_landing_page/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('asset_landing_page/css/templatemo_style.css') . '?v=' . time() }}">
        <link rel="stylesheet" href="{{ asset('asset_landing_page/style.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('asset/plugins/fontawesome-free/css/all.min.css') }}">
    </head>
    <body>
        <!-- Top menu -->
        <div class="show-menu">
            <a href="{{ url('/login_page')}}"><i class="fas fa-sign-in-alt small-icon" style="color:black;"></i></a>
        </div>
        {{-- <div class="show-menu">
            <a href="#" class="shadow-top-down">+</a>
        </div>
        <nav class="main-menu shadow-top-down">
            <ul class="nav nav-pills nav-stacked">
                <li><a href="{{ url('/login_page')}}" class="scroll_effect">Login</a></li>
            </ul>
        </nav> --}}
        <!-- Home -->
        <section id="templatemo_home" style="background-image: url({{ asset('img/slidex1.jpg') }})">
        {{-- <section id="templatemo_home"> --}}
            <div class="container bg-text">
                <div class="templatemo_home_inner_wapper">
                    {{-- <h1 class="text-center"></i> --}}
                        <img width="200px" class="img-thumbnail" style="background-color: #026537;" src="{{ asset('img/logo.jpg') }}">
                    {{-- </h1> --}}
                </div>
                <div class="templatemo_home_inner_wapper">
                    <h2 class="text-center">PT ASH SHOFWAH GROUP TOUR AND TRAVEL</h2>
                    <p>Nikmati perjalanan spiritual yang penuh kenyamanan. Kami hadirkan paket lengkap dengan harga yang terjangkau dan fasilitas yang memuaskan. </p>
                </div>
            </div>
        </section>
        <!-- Features -->
        <section id="templatemo_features">
            <div class="container-fluid">
                <header class="template_header">
                    <h1 class="text-center"><span>...</span> Daftar Paket <span>...</span></h1>
                </header>
                <div class="card-slider">
                    @foreach ($daftar_paket as $paket)
                        <div class="feature-box card">
                            <div class="feature-box-inner">
                                <h4>{{ $paket->judul }}</h4>
                                {{-- <div class="feature-box-icon">
                                </div> --}}
                                <i class="fa fa-map"></i>
                                <h4>{{ $paket->harga }}</h4>
                                <p>
                                    {{ $paket->deskripsi }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                 </div>

            </div>
        </section>
        <!-- Contact -->
        <section id="templatemo_contact">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <header class="template_header">
                            <h1 class="text-center"><span>...</span> Contact <span>...</span></h1>
                        </header>
                        <p class="text-center">
                            <i class="fa fa-map-marker"></i> 1234 Lincoln Way, San Francisco, California<br />
                            <i class="fa fa-envelope"></i> Email: <a href="mailto:info@company.com">info@company.com</a><br />
                            <i class="fa fa-phone"></i> Phone: <a href="tel:010-020-0340">010-020-0340</a>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <ul class="nav nav-pills social">
                            <li><a href="#" class="shadow-top-down social-facebook"><i class="fab fa-facebook"></i></a></li>
                            <li><a href="#" class="shadow-top-down social-twitter"><i class="fab fa-twitter-square"></i></a></li>
                            <li><a href="#" class="shadow-top-down social-youtube"><i class="fab fa-youtube-square"></i></a></li>
                            <li><a href="#" class="shadow-top-down social-instagram"><i class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer -->
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 footer-copyright">
                        <strong>Copyright &copy; {{ date('Y') }} <a href="https://adminlte.io">PT ASH SHOFWAH GROUP</a>.</strong>
                        All rights reserved.
                    </div>
                </div>
            </div>
        </footer>
        <!-- require plugins -->
        <script src="{{ asset('asset_landing_page/js/jquery.min.js') }}"></script>
        <script src="{{ asset('asset_landing_page/js/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('asset_landing_page/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('asset_landing_page/js/jquery.parallax.js') }}"></script>
        <!-- template mo config script -->
        <script src="{{ asset('asset_landing_page/js/templatemo_scripts.js') . '?v=' . time() }}"></script>
    </body>
</html>

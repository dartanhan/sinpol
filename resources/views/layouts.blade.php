<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>SINPOL - Sindicato dos Funcionários da Polícia Civil</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Sindicato dos Funcionários da Polícia Civil" name="keywords">
    <meta content="Sindicato dos Funcionários da Polícia Civil" name="description">
    <link rel="canonical" href="https://sinpol.org.br/home">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <!-- Favicon -->
    <link href="{{URL::asset('img/logo_sinpol.ico')}}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{URL::asset('lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{URL::asset('css/style.css')}}" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid d-none d-lg-block">
    <div class="row align-items-center bg-dark px-lg-5">
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-sm bg-dark p-0">
                <ul class="navbar-nav ml-n2">
                    <li class="nav-item border-right border-secondary">
                        <a class="nav-link text-body small" href="#">
                            {{ \Carbon\Carbon::now()->locale('pt_BR')->translatedFormat('l, j \d\e F \d\e Y') }}
                        </a>
                    </li>
                    <li class="nav-item border-right border-secondary">
                        <a class="nav-link text-body small" href="#">Contato</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="col-lg-3 text-right d-none d-md-block">
            @include('home.socialmedia')
        </div>
    </div>
</div>

    <div class="row d-none d-lg-block">
        <div>
            <img src="{{URL::asset('img/banner2.jpg')}}" alt="Banner" class="img-banner">
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid p-0">

        @include('home.menu')

    </div>
    <!-- Navbar End -->


    <!-- Main News Slider Start -->
    <div class="container-fluid">
        @yield('content')
    </div>
    <!-- Main News Slider End -->


    <!-- Breaking News Start -->
        @yield('breakingNews')
    <!-- Breaking News End -->


    <!-- Featured News Slider Start -->
        @yield('featuredNews')
    <!-- Featured News Slider End -->


    <!-- News With Sidebar Start -->
    <div class="container-fluid">
        @yield('newsWith')
    </div>
    <!-- News With Sidebar End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-dark pt-5 px-sm-3 px-md-5 mt-5">
        @include('home.footer')
    </div>
    <div class="container-fluid py-4 px-sm-3 px-md-5" style="background: #111111;">
        <p class="m-0 text-center">&copy; <a href="#">Sinpol - Sindicato dos Funcionários da Polícia Civil do Estado do Rio de Janeiro </a>. All Rights Reserved.

		<!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
		<!-- Design by <a href="https://htmlcodex.com">HTML Codex</a></p> -->
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary btn-square back-to-top"><i class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{URL::asset('lib/easing/easing.min.js')}}"></script>
    <script src="{{URL::asset('lib/owlcarousel/owl.carousel.min.js')}}"></script>

    <!-- Template Javascript -->
    <script src="{{URL::asset('js/main.js')}}"></script>

    @stack("scripts")
</body>

</html>

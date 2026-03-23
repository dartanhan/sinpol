<nav class="navbar navbar-expand-lg bg-dark navbar-dark py-2 py-lg-0 px-lg-5">

    <div class="row">
        <div class="navbar-brand d-block d-lg-none">
            <img src="{{URL::asset('img/banner.jpg')}}" alt="Banner" class="img-banner-cel">
        </div>
    </div>

    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between px-0 px-lg-3" id="navbarCollapse">
        <div class="d-flex flex-column w-100">
            <!-- Primeira Linha: Institucional -->
            <div class="navbar-nav mr-auto py-0 w-100 flex-wrap">
                <a href="{{route('home.home')}}" class="nav-item nav-link active">Home</a>
                <a href="{{route('home.single', ['pagina' => 'beneficio', 'slug' => ''])}}" class="nav-item nav-link">Benefícios</a>
                <a href="{{route('home.single', ['pagina' => 'como-chegar', 'slug' => ''])}}" class="nav-item nav-link">Como Chegar</a>
                <a href="{{route('home.single', ['pagina' => 'convenio', 'slug' => ''])}}" class="nav-item nav-link">Convênios</a>
                <a href="{{route('home.single', ['pagina' => 'diretoria', 'slug' => ''])}}" class="nav-item nav-link">Diretoria</a>
                <a href="{{route('home.single', ['pagina' => 'fale-conosco', 'slug' => ''])}}" class="nav-item nav-link">Fale Conosco</a>
                <a href="{{route('home.single', ['pagina' => 'historia', 'slug' => ''])}}" class="nav-item nav-link">História</a>
                <a href="{{route('home.single', ['pagina' => 'outrasnoticias', 'slug' => ''])}}" class="nav-item nav-link">Notícias</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Outros</a>
                    <div class="dropdown-menu rounded-0 m-0">
                        <a href="{{route('home.single', ['pagina' => 'principais-links', 'slug' => ''])}}" class="dropdown-item">Principais Links</a>
                        <a href="{{route('login')}}" class="dropdown-item">Administração</a>
                    </div>
                </div>
                <a href="{{route('home.single', ['pagina' => 'ficha', 'slug' => ''])}}" class="nav-item nav-link">Filie-se</a>
            </div>

            <!-- Segunda Linha: Novas Seções Especiais -->
            <div class="navbar-nav mr-auto w-100 flex-wrap justify-content-lg-center" style="font-size: 0.85rem;">
                <a href="{{route('home.single', ['pagina' => 'sinpol-animal', 'slug' => ''])}}" class="nav-item nav-link px-lg-2 py-1">SINPOL ANIMAL</a>
                <a href="{{route('home.single', ['pagina' => 'sinpol-mulher', 'slug' => ''])}}" class="nav-item nav-link px-lg-2 py-1">SINPOL MULHER</a>
                <a href="{{route('home.single', ['pagina' => 'sinpol-permutas', 'slug' => ''])}}" class="nav-item nav-link px-lg-2 py-1">SINPOL PERMUTAS</a>
                <a href="{{route('home.single', ['pagina' => 'classificados-sinpol', 'slug' => ''])}}" class="nav-item nav-link px-lg-2 py-1">CLASSIFICADOS DO SINPOL</a>
                <a href="{{route('home.single', ['pagina' => 'sinpol-fiscaliza', 'slug' => ''])}}" class="nav-item nav-link px-lg-2 py-1">SINPOL FISCALIZA</a>
                <a href="{{route('home.single', ['pagina' => 'sinpol-na-rua', 'slug' => ''])}}" class="nav-item nav-link px-lg-2 py-1">SINPOL NA RUA</a>
                <a href="{{route('home.single', ['pagina' => 'sinpol-denuncias', 'slug' => ''])}}" class="nav-item nav-link px-lg-2 py-1">SINPOL DENÚNCIAS</a>
                <a href="{{route('home.single', ['pagina' => 'sinpol-idoso', 'slug' => ''])}}" class="nav-item nav-link px-lg-2 py-1">SINPOL IDOSO</a>
                <a href="{{route('home.single', ['pagina' => 'sinpol-esportes', 'slug' => ''])}}" class="nav-item nav-link px-lg-2 py-1">SINPOL ESPORTES</a>
                <a href="{{route('home.single', ['pagina' => 'sinpol-peritos', 'slug' => ''])}}" class="nav-item nav-link px-lg-2 py-1">SINPOL PERITOS</a>
            </div>
        </div>
        <!-- <div class="input-group ml-auto d-none d-lg-flex" style="width: 100%; max-width: 300px;">
            <input type="text" class="form-control border-0" placeholder="Keyword">
            <div class="input-group-append">
                <button class="input-group-text bg-primary text-dark border-0 px-3"><i
                        class="fa fa-search"></i></button>
            </div>
        </div> -->
    </div>
</nav>
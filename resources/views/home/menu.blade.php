<style>
    /* Padronização Global do Menu */
    .navbar-dark .navbar-nav .nav-link {
        font-size: 0.85rem !important; /* Tamanho fixo para todos */
        padding: 12px 10px !important;  /* Reduzido de 20px para 12px de altura */
        text-transform: uppercase !important;
        font-weight: 600 !important;
        letter-spacing: 0.5px;
    }

    /* Aproximação no Desktop */
    @media (min-width: 992px) {
        .navbar-nav {
            gap: 2px; /* Pequeno espaçamento entre itens */
        }
        .nav-item.nav-link {
            padding-left: 8px !important;
            padding-right: 8px !important;
        }
    }

    /* Ajuste para o botão HOME não ocupar espaço excessivo */
    .nav-item.active {
        width: auto !important;
        min-width: 80px;
        text-align: center;
    }

    /* Reset para a segunda linha */
    .menu-row-secondary .nav-link {
        padding-top: 8px !important;
        padding-bottom: 8px !important;
    }
</style>

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
                <a href="{{route('home.home')}}" class="nav-item nav-link active">HOME</a>
                <a href="{{route('home.single', ['pagina' => 'beneficio', 'slug' => ''])}}" class="nav-item nav-link">BENEFÍCIOS</a>
                <a href="{{route('home.single', ['pagina' => 'como-chegar', 'slug' => ''])}}" class="nav-item nav-link">COMO CHEGAR</a>
                <a href="{{route('home.single', ['pagina' => 'convenio', 'slug' => ''])}}" class="nav-item nav-link">CONVÊNIOS</a>
                <a href="{{route('home.single', ['pagina' => 'diretoria', 'slug' => ''])}}" class="nav-item nav-link">DIRETORIA</a>
                <a href="{{route('home.single', ['pagina' => 'fale-conosco', 'slug' => ''])}}" class="nav-item nav-link">FALE CONOSCO</a>
                <a href="{{route('home.single', ['pagina' => 'historia', 'slug' => ''])}}" class="nav-item nav-link">HISTÓRIA</a>
                <a href="{{route('home.single', ['pagina' => 'outrasnoticias', 'slug' => ''])}}" class="nav-item nav-link">NOTÍCIAS</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">OUTROS</a>
                    <div class="dropdown-menu rounded-0 m-0">
                        <a href="{{route('home.single', ['pagina' => 'principais-links', 'slug' => ''])}}" class="dropdown-item">PRINCIPAIS LINKS</a>
                        <a href="{{route('login')}}" class="dropdown-item">ADMINISTRAÇÃO</a>
                    </div>
                </div>
                <a href="{{route('home.single', ['pagina' => 'ficha', 'slug' => ''])}}" class="nav-item nav-link">FILIE-SE</a>
            </div>

            <!-- Segunda Linha: Novas Seções Especiais -->
            <div class="navbar-nav mr-auto w-100 flex-wrap justify-content-lg-center menu-row-secondary">
                <a href="{{route('home.single', ['pagina' => 'classificados-sinpol', 'slug' => ''])}}" class="nav-item nav-link">CLASSIFICADOS DO SINPOL</a>
                <a href="{{route('home.single', ['pagina' => 'sinpol-animal', 'slug' => ''])}}" class="nav-item nav-link">SINPOL ANIMAL</a>
                <a href="{{route('home.single', ['pagina' => 'sinpol-denuncias', 'slug' => ''])}}" class="nav-item nav-link">SINPOL DENÚNCIAS</a>
                <a href="{{route('home.single', ['pagina' => 'sinpol-esportes', 'slug' => ''])}}" class="nav-item nav-link">SINPOL ESPORTES</a>
                <a href="{{route('home.single', ['pagina' => 'sinpol-fiscaliza', 'slug' => ''])}}" class="nav-item nav-link">SINPOL FISCALIZA</a>
                <a href="{{route('home.single', ['pagina' => 'sinpol-idoso', 'slug' => ''])}}" class="nav-item nav-link">SINPOL IDOSO</a>
                <a href="{{route('home.single', ['pagina' => 'sinpol-mulher', 'slug' => ''])}}" class="nav-item nav-link">SINPOL MULHER</a>
                <a href="{{route('home.single', ['pagina' => 'sinpol-na-rua', 'slug' => ''])}}" class="nav-item nav-link">SINPOL NA RUA</a>
                <a href="{{route('home.single', ['pagina' => 'sinpol-peritos', 'slug' => ''])}}" class="nav-item nav-link">SINPOL PERITOS</a>
                <a href="{{route('home.single', ['pagina' => 'sinpol-permutas', 'slug' => ''])}}" class="nav-item nav-link">SINPOL PERMUTAS</a>
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
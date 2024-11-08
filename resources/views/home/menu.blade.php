
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
        <div class="navbar-nav mr-auto py-0">
            <a href="{{route('home.home')}}" class="nav-item nav-link active">Home</a>
            <a href="{{route('home.single',['pagina' =>'beneficio','slug'=>''])}}" class="nav-item nav-link">Benefícios</a>
            <a href="#" class="nav-item nav-link">Como Chegar</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Convênios</a>
                <div class="dropdown-menu rounded-0 m-0">
{{--                    <a href="#" class="dropdown-item">Como Obter</a>--}}
                    <a href="{{route('home.single',['pagina' =>'convenio','slug'=>''])}}" class="dropdown-item">Estabelecimentos</a>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Diretoria</a>
                <div class="dropdown-menu rounded-0 m-0">
                    <a href="#" class="dropdown-item">Diretoria</a>
                    <a href="#" class="dropdown-item">Eleição</a>
                </div>
            </div>
            <a href="#" class="nav-item nav-link">Fale Conosco</a>
            <a href="#" class="nav-item nav-link">História</a>
            <a href="{{route('home.single',['pagina' =>'outrasnoticias','slug'=>''])}}" class="nav-item nav-link">Notícias</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Outros</a>
                <div class="dropdown-menu rounded-0 m-0">
                    <a href="#" class="dropdown-item">Principais Links</a>
                    <a href="#" class="dropdown-item">Administração</a>
                </div>
            </div>
            <a href="#" class="nav-item nav-link">Contato</a>
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

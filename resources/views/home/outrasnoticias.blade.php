@extends('layouts')

@section('content')

    <!-- Breaking News Start -->
    <div class="container-fluid mt-5 mb-3 pt-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <div class="section-title border-right-0 mb-0" style="width: 180px;">
                            <h4 class="m-0 text-uppercase font-weight-bold">Notícias</h4>
                        </div>
                        <div class="owl-carousel tranding-carousel position-relative d-inline-flex align-items-center bg-white border border-left-0"
                             style="width: calc(100% - 180px); padding-right: 100px;">
                            @foreach($noticiasBreakNews as $key => $noticiasBreakNew)
                                <div class="text-truncate">
                                    <a class="text-secondary text-uppercase font-weight-semi-bold"
                                       href="{{route('home.single',[ 'pagina' => 'noticia', 'slug' => $noticiasBreakNew->slug])}}">
                                        {{$noticiasBreakNew->subtitulo}}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breaking News End -->


    <!-- News With Sidebar Start -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h4 class="m-0 text-uppercase font-weight-bold">Outras Notícias</h4>
                        </div>
                    </div>

                    @if($noticias->isNotEmpty())
                        @foreach($noticias as $noticia)
                            <div class="col-lg-6">
                                <div class="position-relative mb-3">
                                    @foreach($noticia['imagens'] as $imagem)
                                        @if(!empty($imagem) && strlen($imagem->path) > 0)
                                            <img class="img-fluid" src="{{ URL::asset("storage/posts/files/".$imagem->path) }}"
                                                 style="object-fit: cover; width: 100%; height: 250px;">
                                        @endif
                                    @endforeach
                                    <div class="bg-white border border-top-0 p-4">
                                        <div class="mb-2">
                                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                               href="{{ route('home.home') }}">Notícias</a>
                                            <a class="text-body" href=""><small>{{ $noticia->created_at }}</small></a>
                                        </div>
                                        <a class="h4 d-block mb-3 text-secondary text-uppercase font-weight-bold" href="">
                                            {!! substr(strip_tags($noticia->subtitulo), 0, 25) !!}...
                                        </a>
                                        <p class="m-0">{!! substr(strip_tags($noticia->subtitulo), 0, 150) !!}...</p>
                                    </div>
                                    <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                                        <div class="d-flex align-items-center">
                                            <small>Publicador: {{ $noticia->user->name }}</small>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <small class="ml-3"><i class="far fa-eye mr-2"></i>{{ $noticia->qtd_views }}</small>
                                            <small class="ml-3"><i class="far fa-comment mr-2"></i>0</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Exibir os links de paginação abaixo das notícias -->
                            <div class="col-12 mt-4">
                                <div class="d-flex justify-content-center">
                                    <nav aria-label="Page navigation">
                                        {{ $noticias->links('pagination::bootstrap-4') }}
                                    </nav>
                                </div>
                            </div>
                    @endif
                </div>

            </div>
            <div class="col-lg-4">
            <!-- Social Follow Start -->
{{--            <div class="mb-3">--}}
{{--                <div class="section-title mb-0">--}}
{{--                    <h4 class="m-0 text-uppercase font-weight-bold">Follow Us</h4>--}}
{{--                </div>--}}
{{--                <div class="bg-white border border-top-0 p-3">--}}
{{--                    <a href="" class="d-block w-100 text-white text-decoration-none mb-3" style="background: #39569E;">--}}
{{--                        <i class="fab fa-facebook-f text-center py-4 mr-3" style="width: 65px; background: rgba(0, 0, 0, .2);"></i>--}}
{{--                        <span class="font-weight-medium">12,345 Fans</span>--}}
{{--                    </a>--}}
{{--                    <a href="" class="d-block w-100 text-white text-decoration-none mb-3" style="background: #52AAF4;">--}}
{{--                        <i class="fab fa-twitter text-center py-4 mr-3" style="width: 65px; background: rgba(0, 0, 0, .2);"></i>--}}
{{--                        <span class="font-weight-medium">12,345 Followers</span>--}}
{{--                    </a>--}}
{{--                    <a href="" class="d-block w-100 text-white text-decoration-none mb-3" style="background: #0185AE;">--}}
{{--                        <i class="fab fa-linkedin-in text-center py-4 mr-3" style="width: 65px; background: rgba(0, 0, 0, .2);"></i>--}}
{{--                        <span class="font-weight-medium">12,345 Connects</span>--}}
{{--                    </a>--}}
{{--                    <a href="" class="d-block w-100 text-white text-decoration-none mb-3" style="background: #C8359D;">--}}
{{--                        <i class="fab fa-instagram text-center py-4 mr-3" style="width: 65px; background: rgba(0, 0, 0, .2);"></i>--}}
{{--                        <span class="font-weight-medium">12,345 Followers</span>--}}
{{--                    </a>--}}
{{--                    <a href="" class="d-block w-100 text-white text-decoration-none mb-3" style="background: #DC472E;">--}}
{{--                        <i class="fab fa-youtube text-center py-4 mr-3" style="width: 65px; background: rgba(0, 0, 0, .2);"></i>--}}
{{--                        <span class="font-weight-medium">12,345 Subscribers</span>--}}
{{--                    </a>--}}
{{--                    <a href="" class="d-block w-100 text-white text-decoration-none" style="background: #055570;">--}}
{{--                        <i class="fab fa-vimeo-v text-center py-4 mr-3" style="width: 65px; background: rgba(0, 0, 0, .2);"></i>--}}
{{--                        <span class="font-weight-medium">12,345 Followers</span>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}
            <!-- Social Follow End -->

            <!-- Popular News Start -->
            <div class="mb-3">
                @include('home.ultimasNoticias')
            </div>
            <!-- Popular News End -->

            <!-- Ads Start -->
            <div class="mb-3">
                @include('home.video')
            </div>
            <!-- Ads End -->

            <!-- Newsletter Start -->
{{--            <div class="mb-3">--}}
{{--                @include('home.newsLetter')--}}
{{--            </div>--}}
            <!-- Newsletter End -->

            <!-- Tags Start -->
{{--            <div class="mb-3">--}}
{{--                <div class="section-title mb-0">--}}
{{--                    <h4 class="m-0 text-uppercase font-weight-bold">Tags</h4>--}}
{{--                </div>--}}
{{--                <div class="bg-white border border-top-0 p-3">--}}
{{--                    <div class="d-flex flex-wrap m-n1">--}}
{{--                        <a href="" class="btn btn-sm btn-outline-secondary m-1">Politics</a>--}}
{{--                        <a href="" class="btn btn-sm btn-outline-secondary m-1">Business</a>--}}
{{--                        <a href="" class="btn btn-sm btn-outline-secondary m-1">Corporate</a>--}}
{{--                        <a href="" class="btn btn-sm btn-outline-secondary m-1">Business</a>--}}
{{--                        <a href="" class="btn btn-sm btn-outline-secondary m-1">Health</a>--}}
{{--                        <a href="" class="btn btn-sm btn-outline-secondary m-1">Education</a>--}}
{{--                        <a href="" class="btn btn-sm btn-outline-secondary m-1">Science</a>--}}
{{--                        <a href="" class="btn btn-sm btn-outline-secondary m-1">Business</a>--}}
{{--                        <a href="" class="btn btn-sm btn-outline-secondary m-1">Foods</a>--}}
{{--                        <a href="" class="btn btn-sm btn-outline-secondary m-1">Travel</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <!-- Tags End -->
        </div>
    </div>
    </div>

@endsection

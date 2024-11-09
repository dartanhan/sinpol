@extends('layouts')

@section('content')

{{--    <!-- Breaking News Start -->--}}
{{--    <div class="container-fluid mt-5 mb-3 pt-3">--}}
{{--        <div class="container">--}}
{{--            <div class="row align-items-center">--}}
{{--                <div class="col-12">--}}
{{--                    <div class="d-flex justify-content-between">--}}
{{--                        <div class="section-title border-right-0 mb-0" style="width: 180px;">--}}
{{--                            <h4 class="m-0 text-uppercase font-weight-bold">Notícias</h4>--}}
{{--                        </div>--}}
{{--                        <div class="owl-carousel tranding-carousel position-relative d-inline-flex align-items-center bg-white border border-left-0"--}}
{{--                             style="width: calc(100% - 180px); padding-right: 100px;">--}}
{{--                            @foreach($noticiasBreakNews as $key => $noticiasBreakNew)--}}
{{--                                <div class="text-truncate">--}}
{{--                                    <a class="text-secondary text-uppercase font-weight-semi-bold"--}}
{{--                                       href="{{route('home.single',[ 'pagina' => 'noticia', 'slug' => $noticiasBreakNew->slug])}}">--}}
{{--                                        {{$noticiasBreakNew->subtitulo}}--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <!-- Breaking News End -->--}}


    <!-- News With Sidebar Start -->
    <div class="container mt-5 mb-3 pt-3">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h4 class="m-0 text-uppercase font-weight-bold">Outros Vídeos</h4>
                        </div>
                    </div>

                    @if($videos->isNotEmpty())
                        @foreach($videos as $video)
                            <div class="col-lg-6">
                                <div class="position-relative mb-3">
                                    <div class="bg-white border border-top-0 p-4">
                                        <div class="mb-2">
                                            <a class="badge badge-danger text-uppercase font-weight-semi-bold p-1 mr-2" href="{{$video->link}}" target="_blank">Youtube</a>
                                            <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="{{$video->link}}"
                                               target="_blank" title="{{$video->titulo}}" data-toggle="tooltip" data-placement="top">
                                                {!! substr($video->titulo,0,20) !!}...
                                            </a>
                                        </div>
                                        <div class="bg-white text-center border border-top-0 p-3">

                                        <a href="{{$video->link}}" target="_blank">
                                            <iframe width="100%" height="180"
                                                    src="{{$video->link}}"
                                                    title="{{$video->titulo}}"
                                                    frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                    allowfullscreen>
                                            </iframe>
                                        </a>
                                    </div>
                                        <p class="m-0">{!! $video->titulo !!}</p>
                                    </div>
{{--                                    <div class="d-flex justify-content-between bg-white border border-top-0 p-4">--}}
{{--                                        <div class="d-flex align-items-center">--}}
{{--                                            <small>Publicador: {{ $noticia->user->name }}</small>--}}
{{--                                        </div>--}}
{{--                                        <div class="d-flex align-items-center">--}}
{{--                                            <small class="ml-3"><i class="far fa-eye mr-2"></i>{{ $noticia->qtd_views }}</small>--}}
{{--                                            <small class="ml-3"><i class="far fa-comment mr-2"></i>0</small>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                        @endforeach

                        <!-- Exibir os links de paginação abaixo das notícias -->
                            <div class="col-12 mt-4">
                                <div class="d-flex justify-content-center">
                                    <nav aria-label="Page navigation">
                                        {{ $videos->links('pagination::bootstrap-4') }}
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
{{--            <div class="mb-3">--}}
{{--                @include('home.video')--}}
{{--            </div>--}}
            <!-- Ads End -->

            <!-- Newsletter Start -->
            <div class="mb-3">
                @include('home.newsLetter')
            </div>
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

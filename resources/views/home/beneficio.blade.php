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
    <div class="container-fluid mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- News Detail Start -->
                    <div class="position-relative mb-3">

                        <div class="bg-white border border-top-0 p-4">
                            @foreach($beneficios as $key => $beneficio)
                                <div class="mb-3">
                                    <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2" href="{{route('home.home')}}">Benefícios</a>
                                    <a class="text-body">{{$beneficio->created_at}}</a>
                                </div>
                                <h1 class="mb-3 text-secondary text-uppercase font-weight-bold">
                                {!! substr(strip_tags($beneficio->titulo), 0, 50) !!} <!-- Exibe os primeiros 100 caracteres do conteúdo -->
                                    @if(strlen(strip_tags($beneficio->titulo)) > 50)
                                        [...]
                                    @endif
                                </h1>
                                <p>{!! $beneficio->conteudo!!}</p>
                            @endforeach
                        </div>
                    </div>

                </div>
                <div class="col-lg-4">
                <!-- Popular News Start -->
                    <div class="mb-3">
                        @include('home.ultimasNoticias')
                    </div>
                <!-- Popular News End -->
                <!-- Ads Start -->
                @include('home.video')
                <!-- End Ads -->
                    <!-- Newsletter Start -->
                    <div class="mb-3">
                        {{--                    @include('home.newsLetter')--}}
                    </div>
                    <!-- Newsletter End -->
                </div>
            </div>
        </div>
    </div>
@endsection

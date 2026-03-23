@extends('layouts')

@section('content')
    @php
        $titulos_secao = [
            'sinpol-animal' => 'SINPOL ANIMAL',
            'sinpol-mulher' => 'SINPOL MULHER',
            'sinpol-permutas' => 'SINPOL PERMUTAS',
            'classificados-sinpol' => 'CLASSIFICADOS DO SINPOL',
            'sinpol-fiscaliza' => 'SINPOL FISCALIZA',
            'sinpol-na-rua' => 'SINPOL NA RUA',
            'sinpol-denuncias' => 'SINPOL DENÚNCIAS',
            'sinpol-idoso' => 'SINPOL IDOSO',
            'sinpol-esportes' => 'SINPOL ESPORTES',
            'sinpol-peritos' => 'SINPOL PERITOS',
            'diretoria' => 'DIRETORIA',
            'historia' => 'HISTÓRIA',
            'fale-conosco' => 'FALE CONOSCO',
            'como-chegar' => 'COMO CHEGAR',
            'principais-links' => 'PRINCIPAIS LINKS',
            'convenio' => 'CONVÊNIOS'
        ];
        $tipo_str = (string) $tipo_secao;
        $titulo_formatado = isset($titulos_secao[$tipo_str]) ? $titulos_secao[$tipo_str] : ucfirst(str_replace('-', ' ', $tipo_str));
    @endphp

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
                                        href="{{route('home.single', ['pagina' => 'noticia', 'slug' => $noticiasBreakNew->slug])}}">
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

    <div class="container-fluid mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="position-relative mb-3">
                        <div class="bg-white border border-top-0 p-4">
                            @if(isset($secoes_posts) && count($secoes_posts) > 0)
                                @foreach($secoes_posts as $post)
                                    <div class="mb-5 pb-4 @if(!$loop->last) border-bottom @endif">
                                        <div class="mb-3">
                                            <span class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2">
                                                {{ $titulo_formatado }}
                                            </span>
                                            <a class="text-body" href="">{{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y H:i:s') }}</a>
                                        </div>
                                        
                                        @if($post->titulo && $post->titulo != 'Sem título' && $post->titulo != $titulo_formatado)
                                            <h1 class="mb-3 text-secondary text-uppercase font-weight-bold">
                                                {!! $post->titulo !!}
                                            </h1>
                                        @endif

                                        <div class="text-dark secao-conteudo">
                                            {!! $post->conteudo !!}
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-warning">
                                    Nenhum conteúdo publicado em <strong>{{ $titulo_formatado }}</strong> no momento.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        @include('components.ficha')
                    </div>
                    <div class="mb-3">
                        @include('home.newsLetter')
                    </div>
                    <div class="mb-3">
                        @include('home.ultimasNoticias')
                    </div>
                    
                    @include('home.redesSociais')
                    @include('home.minnimapa')

                    @include('home.video')
                    
                </div>
            </div>
        </div>
    </div>
@endsection

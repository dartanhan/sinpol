@extends('layouts')


@section('breakingNews')
    @include('home.breakingNews')
@endsection

@section('featuredNews')
    @include('home.featuredNews')
@endsection

@section('newsWith')
    @include('home.newsWith')
@endsection


@section('content')

<div class="row">
    <div class="col-lg-7 px-0">
        <div class="owl-carousel main-carousel position-relative">
            @foreach($noticiasPrincipais as $key => $noticia)
            <div class="position-relative overflow-hidden" style="height: 500px;">
                @foreach($noticia['imagens'] as $key => $imagem)
                    @if(!empty($imagem) && strlen($imagem->path) > 0)
                        <img class="img-fluid h-100" src="{{ URL::asset("storage/posts/files/".$imagem->path) }}" style="object-fit: cover;">
                        @break
                    @endif
                @endforeach
                <div class="overlay">
                    <div class="mb-2">
                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                           href="{{route('home.single',['pagina' => 'noticia','slug' => $noticia->slug])}}">Notícia</a>
                        <a class="text-white text-uppercase font-weight-semi-bold p-2 mr-2"
                           href="{{route('home.single',['pagina' => 'noticia','slug' => $noticia->slug])}}">
                               {{$noticia->created_at}}
                        </a>
                    </div>
                        <a class="h2 m-0 text-white text-uppercase font-weight-bold" href="{{route('home.single',['pagina' => 'noticia','slug' => $noticia->slug])}}">
                            {!! substr(strip_tags($noticia->titulo), 0, 40) !!} ...
                        </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="col-lg-5 px-0">
        <div class="row mx-0">
            @foreach($noticiasSecundarias as $key => $noticiaSecundaria)

                <div class="col-md-6 px-0">
                    <div class="position-relative overflow-hidden" style="height: 250px;">
                        @foreach($noticiaSecundaria['imagens'] as $key => $imagem)
                            @if(!empty($imagem) && strlen($imagem->path) > 0)
                                <img class="img-fluid w-100 h-100" src="{{ URL::asset("storage/posts/files/".$imagem->path) }}" style="object-fit: cover;">
                            @endif
                        @endforeach
                        <div class="overlay">
                            <div class="mb-2">
                                <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                    href="{{route('home.single',['pagina' => 'noticia','slug' => $noticiaSecundaria->slug])}}">Notícias</a>
                                <a class="text-white" href="{{route('home.single',['pagina' => 'noticia','slug' => $noticiaSecundaria->slug])}}">
                                    <small>{{$noticiaSecundaria->created_at}}</small>
                                </a>
                            </div>

                            <a class="h6 m-0 text-white text-uppercase font-weight-semi-bold"
                               href="{{route('home.single',['pagina' => 'noticia','slug' => $noticiaSecundaria->slug])}}">
                                {!! substr(strip_tags($noticiaSecundaria->titulo), 0, 30) !!}...
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

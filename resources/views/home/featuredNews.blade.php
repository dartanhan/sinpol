<div class="container-fluid pt-5 mb-3">
    <div class="container">
        <div class="section-title">
            <h4 class="m-0 text-uppercase font-weight-bold">Notícias em Destaque</h4>
        </div>
        <div class="owl-carousel news-carousel carousel-item-4 position-relative">
            @foreach($noticiasDestaques as $key => $noticiasDestaque)
                <div class="position-relative overflow-hidden" style="height: 300px;">
                    @foreach($noticiasDestaque['imagens'] as $key => $imagem)
                        @if(!empty($imagem) && strlen($imagem->path) > 0)
                            <img class="img-fluid h-100" src="{{ URL::asset("storage/posts/files/".$imagem->path) }}" style="object-fit: cover;">
                            @break
                        @endif
                    @endforeach
                    <div class="overlay">
                        <div class="mb-2">
                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-1"
                                href="{{route('home.home')}}">Notícias</a>
                            <a class="text-white" href="{{route('home.single',['pagina' => 'noticia', 'slug' => $noticiasDestaque->slug])}}">
                                <small>{{$noticiasDestaque->created_at}}</small></a>
                        </div>
                        <a class="h6 m-0 text-white text-uppercase font-weight-semi-bold" href="{{route('home.single',['pagina' => 'noticia', 'slug' => $noticiasDestaque->slug])}}">
                            {!! substr(strip_tags($noticiasDestaque->subtitulo), 0, 15) !!}...
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

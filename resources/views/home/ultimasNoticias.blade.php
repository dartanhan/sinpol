
    <div class="section-title mb-0">
        <h4 class="m-0 text-uppercase font-weight-bold">Últimas Noticias</h4>
    </div>
    <div class="bg-white border border-top-0 p-3">
        @if($ultimasNoticias->isNotEmpty())
            @foreach($ultimasNoticias as $ultimasNoticia)
                <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">
                    @foreach($ultimasNoticia['imagens'] as $key => $imagem)
                        @if(!empty($imagem) && strlen($imagem->path) > 0)
                            <img class="img-fluid h-100" src="{{ URL::asset("storage/posts/files/".$imagem->path) }}" style="object-fit: cover;width: 120px">
                        @endif
                    @endforeach
                    <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                        <div class="mb-2">
                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" href="{{route('home.home')}}">Notícias</a>
                            <a class="text-body"><small>{{$ultimasNoticia->createdatformatted}}</small></a>
                        </div>
                        <a class="h6 m-0 text-secondary text-uppercase font-weight-bold"
                           href="{{route('home.single',['pagina' => 'noticia','slug' => $ultimasNoticia->slug])}}">

                            @if(!empty($ultimasNoticia->subtitulo))
                                {!! substr(strip_tags($ultimasNoticia->subtitulo), 0,25) !!}...
                            @else
                                {!! substr(strip_tags($ultimasNoticia->titulo), 0,25) !!}...
                            @endif
                        </a>
                    </div>
                </div>
            @endforeach
        @endif
{{--        <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">--}}

{{--            <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-right-0">--}}
{{--                <div class="mb-2">--}}
{{--                    <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" href="">Business</a>--}}
{{--                    <a class="text-body" href=""><small>Jan 01, 2045</small></a>--}}
{{--                </div>--}}
{{--                <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="">Lorem ipsum dolor sit amet elit...</a>--}}
{{--            </div>--}}
{{--            <img class="img-fluid" src="{{URL::asset('img/news-110x110-1.jpg')}}" alt="">--}}
{{--        </div>--}}

{{--        <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">--}}
{{--            <img class="img-fluid" src="{{URL::asset('img/news-110x110-1.jpg')}}" alt="">--}}
{{--            <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">--}}
{{--                <div class="mb-2">--}}
{{--                    <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" href="">Business</a>--}}
{{--                    <a class="text-body" href=""><small>Jan 01, 2045</small></a>--}}
{{--                </div>--}}
{{--                <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="">Lorem ipsum dolor sit amet elit...</a>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>


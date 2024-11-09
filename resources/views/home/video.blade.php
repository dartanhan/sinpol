    @if(count($videos) > 0)
        <div class="mb-3">
            <div class="section-title mb-0">
                <h4 class="m-0 text-uppercase font-weight-bold">Vídeos</h4>
                <a class="text-secondary font-weight-medium text-decoration-none"
                   href="{{route('home.single',['pagina' => 'outrosvideos','slug' => $videos[0]->slug])}}">
                    <i class="fab fa-youtube mr-1"></i><span>Todos</span>
                </a>
            </div>

            @foreach($videos as $key => $video)
                <div class="bg-white text-center border border-top-0 p-3">
                    <div class="mb-2">
                        <a class="badge badge-danger text-uppercase font-weight-semi-bold p-1 mr-2" href="{{$video->link}}" target="_blank">Youtube</a>
                        <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="{{$video->link}}"
                           target="_blank" title="{{$video->titulo}}" data-toggle="tooltip" data-placement="top">
                            {!! substr($video->titulo,0,20) !!}...
                        </a>
                    </div>
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
            @endforeach
        </div>
    @endif

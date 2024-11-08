<!-- News With Sidebar Start -->
<div class="container-fluid mt-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- News Detail Start -->
                <div class="position-relative mb-3">
                    @if($noticiaSingle && $noticiaSingle[0]->imagens->isNotEmpty() && !empty($noticiaSingle[0]->imagens->first()->path))
                        <img class="img-fluid w-100" src="{{ asset('storage/posts/files/' . $noticiaSingle[0]->imagens->first()->path) }}" style="object-fit: cover;">
                    @endif
                    <div class="bg-white border border-top-0 p-4">
                        <div class="mb-3">
                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                               href="{{route('home.home')}}">Notícias</a>
                            <a class="text-body">{{$noticiaSingle[0]->created_at}}</a>
                        </div>
                        <h1 class="mb-3 text-secondary text-uppercase font-weight-bold">
                        {!! substr(strip_tags($noticiaSingle[0]->titulo), 0, 50) !!} <!-- Exibe os primeiros 100 caracteres do conteúdo -->
                            @if(strlen(strip_tags($noticiaSingle[0]->titulo)) > 50)
                                [...]
                            @endif
                        </h1>
                        <p>{!! $noticiaSingle[0]->conteudo!!}</p>
                    </div>
                    <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                        <div class="d-flex align-items-center">
                            {{--                            <img class="rounded-circle mr-2" src="{{ asset('img/user.jpg')}}" width="25" height="25" alt="">--}}
                            <span>Publicador: {{$noticiaSingle[0]->user->name}}</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="ml-3"><i class="far fa-eye mr-2"></i>{{$noticiaSingle[0]->qtd_views}}</span>
                            <span class="ml-3"><i class="far fa-comment mr-2"></i>0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

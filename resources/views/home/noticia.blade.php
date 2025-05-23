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
                    @if($noticiaSingle && $noticiaSingle->imagens->isNotEmpty() && !empty($noticiaSingle->imagens->first()->path))
                        <img class="img-fluid w-100" src="{{ asset('storage/posts/files/' . $noticiaSingle->imagens->first()->path) }}" style="object-fit: cover;">
                    @endif
                    <div class="bg-white border border-top-0 p-4">
                        <div class="mb-3">
                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                               href="{{route('home.home')}}">Notícias</a>
                            <a class="text-body">{{$noticiaSingle->created_at}}</a>
                        </div>
                        <h1 class="mb-3 text-secondary text-uppercase font-weight-bold">
                            {!! $noticiaSingle->titulo !!}
                        </h1>
                        <p>{!! $noticiaSingle->conteudo!!}</p>
                    </div>
                    <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                        <div class="d-flex align-items-center">
{{--                            <img class="rounded-circle mr-2" src="{{ asset('img/user.jpg')}}" width="25" height="25" alt="">--}}
                            <span>Publicador: {{$noticiaSingle->user->name}}</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="ml-3"><i class="far fa-eye mr-2"></i>{{$noticiaSingle->qtd_views}}</span>
                            <span class="ml-3"><i class="far fa-comment mr-2"></i>0</span>
                        </div>
                    </div>
                </div>
                <!-- News Detail End -->

                <!-- Comment List Start -->
{{--                <div class="mb-3">--}}
{{--                    <div class="section-title mb-0">--}}
{{--                        <h4 class="m-0 text-uppercase font-weight-bold">3 Comments</h4>--}}
{{--                    </div>--}}
{{--                    <div class="bg-white border border-top-0 p-4">--}}
{{--                        <div class="media mb-4">--}}
{{--                            <img src="img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">--}}
{{--                            <div class="media-body">--}}
{{--                                <h6><a class="text-secondary font-weight-bold" href="">John Doe</a> <small><i>01 Jan 2045</i></small></h6>--}}
{{--                                <p>Diam amet duo labore stet elitr invidunt ea clita ipsum voluptua, tempor labore--}}
{{--                                    accusam ipsum et no at. Kasd diam tempor rebum magna dolores sed sed eirmod ipsum.</p>--}}
{{--                                <button class="btn btn-sm btn-outline-secondary">Reply</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="media">--}}
{{--                            <img src="img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">--}}
{{--                            <div class="media-body">--}}
{{--                                <h6><a class="text-secondary font-weight-bold" href="">John Doe</a> <small><i>01 Jan 2045</i></small></h6>--}}
{{--                                <p>Diam amet duo labore stet elitr invidunt ea clita ipsum voluptua, tempor labore--}}
{{--                                    accusam ipsum et no at. Kasd diam tempor rebum magna dolores sed sed eirmod ipsum.</p>--}}
{{--                                <button class="btn btn-sm btn-outline-secondary">Reply</button>--}}
{{--                                <div class="media mt-4">--}}
{{--                                    <img src="img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1"--}}
{{--                                         style="width: 45px;">--}}
{{--                                    <div class="media-body">--}}
{{--                                        <h6><a class="text-secondary font-weight-bold" href="">John Doe</a> <small><i>01 Jan 2045</i></small></h6>--}}
{{--                                        <p>Diam amet duo labore stet elitr invidunt ea clita ipsum voluptua, tempor--}}
{{--                                            labore accusam ipsum et no at. Kasd diam tempor rebum magna dolores sed sed--}}
{{--                                            eirmod ipsum.</p>--}}
{{--                                        <button class="btn btn-sm btn-outline-secondary">Reply</button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <!-- Comment List End -->

                <!-- Comment Form Start -->
{{--                <div class="mb-3">--}}
{{--                    <div class="section-title mb-0">--}}
{{--                        <h4 class="m-0 text-uppercase font-weight-bold">Leave a comment</h4>--}}
{{--                    </div>--}}
{{--                    <div class="bg-white border border-top-0 p-4">--}}
{{--                        <form>--}}
{{--                            <div class="form-row">--}}
{{--                                <div class="col-sm-6">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label for="name">Name *</label>--}}
{{--                                        <input type="text" class="form-control" id="name">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-sm-6">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label for="email">Email *</label>--}}
{{--                                        <input type="email" class="form-control" id="email">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="website">Website</label>--}}
{{--                                <input type="url" class="form-control" id="website">--}}
{{--                            </div>--}}

{{--                            <div class="form-group">--}}
{{--                                <label for="message">Message *</label>--}}
{{--                                <textarea id="message" cols="30" rows="5" class="form-control"></textarea>--}}
{{--                            </div>--}}
{{--                            <div class="form-group mb-0">--}}
{{--                                <input type="submit" value="Leave a comment"--}}
{{--                                       class="btn btn-primary font-weight-semi-bold py-2 px-3">--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <!-- Comment Form End -->
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
                    @include('home.newsLetter')
                </div>
                <!-- Newsletter End -->
            </div>
        </div>
    </div>
</div>

@endsection

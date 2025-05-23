<div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        @include('home.body')
{{--                        @include('home.outrasNoticias')--}}
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

        {{--                    @if(count($videos) > 0)--}}
{{--                        <div class="mb-3">--}}
{{--                            <div class="section-title mb-0">--}}
{{--                                <h4 class="m-0 text-uppercase font-weight-bold">Vídeos</h4>--}}
{{--                            </div>--}}

{{--                            @foreach($videos as $key => $video)--}}
{{--                                <div class="bg-white text-center border border-top-0 p-3">--}}
{{--                                    <a href="{{$video->link}}" target="_blank">--}}
{{--                                        <iframe width="100%" height="180"--}}
{{--                                                src="{{$video->link}}"--}}
{{--                                                title="{{$video->titulo}}"--}}
{{--                                                frameborder="0"--}}
{{--                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"--}}
{{--                                                allowfullscreen>--}}
{{--                                        </iframe>--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                    @endif--}}
                    <!-- Ads End -->

                    <!-- Newsletter Start -->
                    <div class="mb-3">
                        @include('home.newsLetter')
                    </div>
                    <!-- Newsletter End -->

                    <div class="mb-3">
                        @include('components.ficha')
                    </div>

                     <!-- Social Follow Start -->
{{--                     <div class="mb-3">--}}
{{--                        <div class="section-title mb-0">--}}
{{--                            <h4 class="m-0 text-uppercase font-weight-bold">Redes Sociais</h4>--}}
{{--                        </div>--}}
{{--                        <div class="bg-white border border-top-0 p-3">--}}
{{--                            <a href="" class="d-block w-100 text-white text-decoration-none mb-3" style="background: #39569E;">--}}
{{--                                <i class="fab fa-facebook-f text-center py-4 mr-3" style="width: 65px; background: rgba(0, 0, 0, .2);"></i>--}}
{{--                                <span class="font-weight-medium">12,345 Fans</span>--}}
{{--                            </a>--}}
{{--                            <a href="" class="d-block w-100 text-white text-decoration-none mb-3" style="background: #52AAF4;">--}}
{{--                                <i class="fab fa-twitter text-center py-4 mr-3" style="width: 65px; background: rgba(0, 0, 0, .2);"></i>--}}
{{--                                <span class="font-weight-medium">12,345 Followers</span>--}}
{{--                            </a>--}}
{{--                            <a href="" class="d-block w-100 text-white text-decoration-none mb-3" style="background: #0185AE;">--}}
{{--                                <i class="fab fa-linkedin-in text-center py-4 mr-3" style="width: 65px; background: rgba(0, 0, 0, .2);"></i>--}}
{{--                                <span class="font-weight-medium">12,345 Connects</span>--}}
{{--                            </a>--}}
{{--                            <a href="" class="d-block w-100 text-white text-decoration-none mb-3" style="background: #C8359D;">--}}
{{--                                <i class="fab fa-instagram text-center py-4 mr-3" style="width: 65px; background: rgba(0, 0, 0, .2);"></i>--}}
{{--                                <span class="font-weight-medium">12,345 Followers</span>--}}
{{--                            </a>--}}
{{--                            <a href="" class="d-block w-100 text-white text-decoration-none mb-3" style="background: #DC472E;">--}}
{{--                                <i class="fab fa-youtube text-center py-4 mr-3" style="width: 65px; background: rgba(0, 0, 0, .2);"></i>--}}
{{--                                <span class="font-weight-medium">12,345 Subscribers</span>--}}
{{--                            </a>--}}
{{--                            <a href="" class="d-block w-100 text-white text-decoration-none" style="background: #055570;">--}}
{{--                                <i class="fab fa-vimeo-v text-center py-4 mr-3" style="width: 65px; background: rgba(0, 0, 0, .2);"></i>--}}
{{--                                <span class="font-weight-medium">12,345 Followers</span>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <!-- Social Follow End -->
                    <!-- Tags Start -->
                    <!-- <div class="mb-3">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold">Tags</h4>
                        </div>
                        <div class="bg-white border border-top-0 p-3">
                            <div class="d-flex flex-wrap m-n1">
                                <a href="" class="btn btn-sm btn-outline-secondary m-1">Politics</a>
                                <a href="" class="btn btn-sm btn-outline-secondary m-1">Business</a>
                                <a href="" class="btn btn-sm btn-outline-secondary m-1">Corporate</a>
                                <a href="" class="btn btn-sm btn-outline-secondary m-1">Business</a>
                                <a href="" class="btn btn-sm btn-outline-secondary m-1">Health</a>
                                <a href="" class="btn btn-sm btn-outline-secondary m-1">Education</a>
                                <a href="" class="btn btn-sm btn-outline-secondary m-1">Science</a>
                                <a href="" class="btn btn-sm btn-outline-secondary m-1">Business</a>
                                <a href="" class="btn btn-sm btn-outline-secondary m-1">Foods</a>
                                <a href="" class="btn btn-sm btn-outline-secondary m-1">Travel</a>
                            </div>
                        </div>
                    </div> -->
                    <!-- Tags End -->
                </div>
            </div>
        </div>

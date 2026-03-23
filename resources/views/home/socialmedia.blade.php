
    <nav class="navbar navbar-expand-sm bg-dark p-0">
        <ul class="navbar-nav ml-auto mr-n2">
            @if(isset($socialmedias) && $socialmedias->isNotEmpty() )
                @foreach($socialmedias as $key => $socialmedia)
                    <li class="nav-item">
                        <a class="nav-link text-body px-1" href="{{$socialmedia->link}}" target="_blank">
                            <i class="fab fa-{{$socialmedia->slug}}" style="font-size: 11px !important;"></i>
                        </a>
                    </li>
                @endforeach
            @endif
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link text-body" href="#"><small class="fab fa-facebook-f"></small></a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link text-body" href="#"><small class="fab fa-linkedin-in"></small></a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link text-body" href="#"><small class="fab fa-instagram"></small></a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link text-body" href="#"><small class="fab fa-google-plus-g"></small></a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link text-body" href="#"><small class="fab fa-youtube"></small></a>--}}
{{--            </li>--}}
        </ul>
    </nav>


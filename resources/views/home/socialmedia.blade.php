
    <nav class="navbar navbar-expand-sm bg-dark p-0">
        <ul class="navbar-nav ml-auto mr-n2">
            @foreach($socialmedias as $key => $socialmedia)
                <li class="nav-item">
                    <a class="nav-link text-body" href="{{$socialmedia->link}}" target="_blank">
                        <small class="fab fa-{{$socialmedia->slug}}"></small>
                    </a>
                </li>
            @endforeach
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


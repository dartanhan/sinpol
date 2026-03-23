@if(isset($socialmedias) && count($socialmedias) > 0)
    <div class="mb-3">
        <div class="section-title mb-0">
            <h4 class="m-0 text-uppercase font-weight-bold">Redes Sociais</h4>
        </div>
        <div class="bg-white border border-top-0 p-3">
            @foreach($socialmedias as $social)
                <div class="d-flex align-items-center bg-white mb-3" style="height: 60px;">
                    @if($social->imagem)
                        <img class="img-fluid" src="{{ asset('images/social_media/'.$social->imagem) }}" alt="{{ $social->titulo }}" style="width: 60px; height: 60px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fa fa-image text-muted fa-lg"></i>
                        </div>
                    @endif
                    <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                        <a class="m-0 text-secondary text-uppercase font-weight-bold" style="font-size: 11px; line-height: 1.2;" href="{{ $social->link }}" target="_blank">
                            {{ $social->titulo }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

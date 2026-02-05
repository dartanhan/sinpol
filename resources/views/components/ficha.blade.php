<style>
    @keyframes blink-animation {
        0% {
            opacity: 1;
            color: #000;
        }

        50% {
            opacity: 0.5;
            color: #FF0000;
            /* Vermelho para chamar atenção */
        }

        100% {
            opacity: 1;
            color: #000;
        }
    }

    .piscar-destaque {
        animation: blink-animation 1.5s infinite;
    }
</style>
<div class="section-title mb-0">
    <h4 class="m-0 text-uppercase font-weight-bold piscar-destaque">SINDICALIZE-SE</h4>
</div>
<div class="bg-white text-center border border-top-0 p-3">
    <p>Desejo filiar-me ao SINPOL!</p>
    <div class="input-group mb-2" style="width: 100%;">
        {{--<input type="text" class="form-control form-control-lg" placeholder="Email">--}}
        <div class="input-group-append">
            <a href="{{route('home.single', ['pagina' => 'ficha', 'slug' => ''])}}"
                class="btn btn-primary font-weight-bold px-3">Enviar</a>
        </div>
    </div>
    <!-- <small>Lorem ipsum dolor sit amet elit</small> -->
</div>
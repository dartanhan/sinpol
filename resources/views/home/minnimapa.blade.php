@php
    $mapa_ativo = \App\Models\Mapa::where('status', 1)->orderBy('id', 'desc')->first();
@endphp
@if($mapa_ativo)
    <div class="mb-3">
        <div class="section-title mb-0">
            <h4 class="m-0 text-uppercase font-weight-bold">QUAL É A DELEGACIA?</h4>
        </div>
        <div class="bg-white border border-top-0 p-3">
            @php
                $map_link = $mapa_ativo->link;
                $embed_url = "";
                $external_link = $map_link;

                // Se for um link do Google My Maps (contém /maps/d/)
                if (strpos($map_link, '/maps/d/') !== false) {
                    $embed_url = str_replace(['/viewer', '/edit'], '/embed', $map_link);
                    $embed_url = preg_replace('/\/u\/\d+\//', '/', $embed_url);
                    
                    // Para o link externo, tentamos converter para uma busca padrão se o usuário quiser Google Maps
                    // Como MyMaps é uma camada diferente, o link direto sempre abrirá no MyMaps.
                    // Uma alternativa é usar o título do mapa ou endereço, se disponível, mas aqui usaremos o link salvo.
                    // Para forçar "Google Maps", o ideal é o usuário salvar um link de "Lugar" ou "Endereço".
                } 
                // Se for um link comum do Google Maps
                elseif (strpos($map_link, 'http') === 0) {
                    $embed_url = $map_link . (strpos($map_link, '?') !== false ? '&' : '?') . 'output=embed';
                } 
                // Se for apenas texto/endereço
                else {
                    $embed_url = "https://maps.google.com/maps?q=" . urlencode($map_link) . "&hl=pt&z=14&output=embed";
                    $external_link = "https://www.google.com/maps/search/?api=1&query=" . urlencode($map_link);
                }
            @endphp
            <div style="width: 100%; height: 250px; overflow: hidden;" class="border rounded shadow-sm">
                <iframe 
                    width="100%" 
                    height="100%" 
                    style="border:0;"
                    allowfullscreen="" 
                    loading="lazy" 
                    src="{{ $embed_url }}">
                </iframe>
            </div>
            <div class="mt-2 text-center">
                <a href="{{ $external_link }}" target="_blank" class="btn btn-sm btn-outline-primary font-weight-bold">
                    <i class="fas fa-map-marker-alt mr-1"></i> Abrir no Google Maps
                </a>
            </div>
        </div>
    </div>
@endif

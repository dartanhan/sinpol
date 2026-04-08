@php
    $mapa_ativo = \App\Models\Mapa::where('status', 1)->orderBy('id', 'desc')->first();
@endphp
@if($mapa_ativo)
    <div class="mb-4">
        <div class="section-title mb-0">
            <h4 class="m-0 text-uppercase font-weight-bold" style="letter-spacing: 1px;">
                <i class="fas fa-map-marked-alt mr-2 text-primary"></i>QUAL É A DELEGACIA?
            </h4>
        </div>
        <div class="bg-white border border-top-0 p-3 shadow-sm rounded-bottom">
            @php
                $map_link = $mapa_ativo->link;
                $embed_url = "";
                $external_link = $map_link;

                if (strpos($map_link, '/maps/d/') !== false) {
                    $embed_url = str_replace(['/viewer', '/edit'], '/embed', $map_link);
                    $embed_url = preg_replace('/\/u\/\d+\//', '/', $embed_url);
                } 
                elseif (preg_match('/\/maps\/place\/([^\/@]+)/', $map_link, $matches)) {
                    $address = str_replace('+', ' ', $matches[1]);
                    $embed_url = "https://maps.google.com/maps?q=" . urlencode($address) . "&hl=pt&z=14&output=embed";
                    $external_link = "https://www.google.com/maps/search/?api=1&query=" . urlencode($address);
                }
                elseif (strpos($map_link, 'http') === 0) {
                    $embed_url = $map_link . (strpos($map_link, '?') !== false ? '&' : '?') . 'output=embed';
                } 
                else {
                    $embed_url = "https://maps.google.com/maps?q=" . urlencode($map_link) . "&hl=pt&z=14&output=embed";
                    $external_link = "https://www.google.com/maps/search/?api=1&query=" . urlencode($map_link);
                }
            @endphp
            
            <div class="position-relative overflow-hidden border rounded" style="height: 280px; transition: transform 0.3s ease;">
                <!-- Decorative Frame -->
                <div class="position-absolute w-100 h-100" style="pointer-events: none; border: 1px solid rgba(0,0,0,0.05); z-index: 1;"></div>
                
                <iframe 
                    width="100%" 
                    height="100%" 
                    style="border:0;"
                    allowfullscreen="" 
                    loading="lazy" 
                    src="{{ $embed_url }}">
                </iframe>
            </div>

            <div class="mt-3">
                <a href="{{ $external_link }}" target="_blank" 
                   class="btn btn-primary btn-block py-2 font-weight-bold shadow-sm d-flex align-items-center justify-content-center"
                   style="border-radius: 8px; transition: all 0.3s ease; gap: 8px;">
                    <i class="fas fa-external-link-alt"></i>
                    VER NO GOOGLE MAPS
                </a>
                <p class="text-center text-muted mt-2 mb-0" style="font-size: 0.75rem;">
                    Consulte endereços e contatos das delegacias do RJ.
                </p>
            </div>
        </div>
    </div>
@endif


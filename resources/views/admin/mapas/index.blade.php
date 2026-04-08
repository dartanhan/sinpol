@extends('admin.layouts.layout')
@section('menu')
    @include('admin.menu')
@endsection

@section('content')

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-1"></i>
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($message = Session::get('danger'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-octagon me-1"></i>
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title m-0">Gerenciar Mapas e Endereços</h5>
                            <button type="button" class="btn btn-primary btnModalMapa shadow-sm" data-toggle="modal"
                                data-target="#modalMapa" data-rota="{{route('mapas.store')}}">
                                <i class="bi bi-plus-circle me-1"></i> Adicionar Novo Mapa
                            </button>
                        </div>

                        <table class="table datatable table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" width="50">#</th>
                                    <th scope="col" width="200">Visualização</th>
                                    <th scope="col">Link / Endereço</th>
                                    <th scope="col" width="100">Status</th>
                                    <th scope="col" width="120">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mapas as $mapa)
                                    @php
                                        $map_link = $mapa->link;
                                        $embed_url = "";
                                        if (strpos($map_link, '/maps/d/') !== false) {
                                            $embed_url = str_replace(['/viewer', '/edit'], '/embed', $map_link);
                                            $embed_url = preg_replace('/\/u\/\d+\//', '/', $embed_url);
                                        } elseif (preg_match('/\/maps\/place\/([^\/@]+)/', $map_link, $matches)) {
                                            $address = str_replace('+', ' ', $matches[1]);
                                            $embed_url = "https://maps.google.com/maps?q=" . urlencode($address) . "&hl=pt&z=14&output=embed";
                                        } elseif (strpos($map_link, 'http') === 0) {
                                            $embed_url = $map_link . (strpos($map_link, '?') !== false ? '&' : '?') . 'output=embed';
                                        } else {
                                            $embed_url = "https://maps.google.com/maps?q=" . urlencode($map_link) . "&hl=pt&z=14&output=embed";
                                        }
                                    @endphp
                                    <tr>
                                        <th scope="row">{{$mapa->id}}</th>
                                        <td>
                                            <div class="border rounded overflow-hidden shadow-sm" style="width: 180px; height: 100px;">
                                                <iframe width="100%" height="100%" frameborder="0" src="{{ $embed_url }}"></iframe>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-truncate" style="max-width: 400px;" title="{{$mapa->link}}">
                                                <i class="bi bi-geo-alt text-primary me-1"></i> {{$mapa->link}}
                                            </div>
                                            <small class="text-muted">Criado em: {{ \Carbon\Carbon::parse($mapa->created_at)->format('d/m/Y H:i') }}</small>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input statusSwitchMapa" type="checkbox"
                                                    data-rota="{{route('atualizar-status-mapa')}}"
                                                    data-id="{{$mapa->id}}" @if($mapa->status) checked @endif
                                                    title="Ativar/Desativar no site">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group shadow-sm">
                                                <button class="btn btn-sm btn-outline-info btn-editar-mapa" 
                                                    data-rota="{{route('mapas.edit', $mapa->id)}}"
                                                    data-rota-update="{{route('mapas.update', $mapa->id)}}" 
                                                    data-toggle="modal"
                                                    data-target="#modalMapa">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger btn-excluir-mapa"
                                                    data-rota="{{route('mapas.destroy', $mapa->id)}}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="modalMapa" tabindex="-1" role="dialog" aria-labelledby="modalMapaLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalMapaLabel">
                        <i class="bi bi-map-fill me-2"></i>Gerenciar Mapa
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <form action="{{route('mapas.store')}}" method="POST" id="mapaForm">
                        @csrf

                        <div class="form-group mb-4">
                            <label for="link" class="form-label font-weight-bold">Link ou Endereço do Google Maps</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-light"><i class="bi bi-link-45deg"></i></span>
                                <input type="text" class="form-control" name="link" id="link" 
                                    placeholder="Ex: Delegacia Legal, Rua Tals, RJ ou Link do Google Maps" required>
                            </div>
                            <small class="text-secondary d-block mt-1">
                                <i class="bi bi-info-circle-fill me-1"></i> Dica: O sistema aceita endereços comuns ou links completos de compartilhamento do Google Maps.
                            </small>
                        </div>

                        <div class="text-end border-top pt-3">
                            <button type="button" class="btn btn-light me-2" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">Salvar Informações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push("scripts")
    <script>
        $('.btnModalMapa').on('click', function (e) {
            $("#link").val("");

            $('#mapaForm').attr('action', $(this).data('rota'));

            const myForm = document.getElementById('mapaForm');
            const existingMethodInput = myForm.querySelector('input[name="_method"]');
            if (existingMethodInput) {
                myForm.removeChild(existingMethodInput);
            }
        });

        document.querySelectorAll('.btn-editar-mapa').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();

                const rota = $(this).data('rota');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const myForm = document.getElementById('mapaForm');

                const existingMethodInput = myForm.querySelector('input[name="_method"]');
                if (existingMethodInput) {
                    myForm.removeChild(existingMethodInput);
                }

                fetch(rota, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    }
                })
                    .then(response => response.json())
                    .then(response => {
                        if (response.success) {
                            document.getElementById('link').value = response.data.link;

                            myForm.action = $(this).data('rota-update');

                            const hiddenMethodInput = document.createElement('input');
                            hiddenMethodInput.type = 'hidden';
                            hiddenMethodInput.name = '_method';
                            hiddenMethodInput.value = 'PUT';
                            myForm.appendChild(hiddenMethodInput);

                        } else {
                            Swal.fire({
                                title: 'Error!',
                                icon: 'error',
                                html: response.message,
                                showConfirmButton: true
                            });
                        }
                    })
                    .catch(error => Swal.fire({
                        title: 'Error!',
                        icon: 'error',
                        html: error,
                        showConfirmButton: true
                    })
                    );
            });
        });

        document.querySelectorAll('.btn-excluir-mapa').forEach(function (element) {
            element.addEventListener('click', function () {
                const rota = $(this).data('rota');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                let confirmation = confirm("Deseja realmente excluir este conteúdo?");
                if (!confirmation) return;

                fetch(rota, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert("Erro ao excluir");
                        }
                    })
                    .catch(error => alert("Erro ao excluir"));
            });
        });

        document.querySelectorAll('.statusSwitchMapa').forEach(function (element) {
            element.addEventListener('click', function () {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const rota = $(this).data('rota');
                const id = $(this).data('id');
                let status = this.checked ? 1 : 0;

                fetch(rota, {
                    method: 'POST',
                    body: JSON.stringify({ id: id, status: status }),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Sucesso!',
                                html: data.message,
                                icon: 'success',
                                timer: 1000
                            });
                        }
                    })
                    .catch(error => Swal.fire('Error!', error, 'error'));
            });
        });
    </script>
@endpush

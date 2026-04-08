@extends('admin.layouts.layout')
@section('menu')
    @include('admin.menu')
@endsection

@section('content')

    <style>
        .map-management-card {
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        .map-management-card:hover {
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
        }
        .table-custom thead {
            background: #f8f9fa;
        }
        .table-custom th {
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            font-weight: 700;
            color: #31404B;
            border: none;
        }
        .table-custom td {
            vertical-align: middle;
            border-bottom: 1px solid #f1f3f5;
            padding: 1.25rem 0.75rem;
        }
        .preview-frame {
            position: relative;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .preview-frame:hover {
            transform: scale(1.05);
        }
        .preview-frame::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            border: 1px solid rgba(0,0,0,0.05);
            pointer-events: none;
            border-radius: 1rem;
        }
        .status-badge {
            padding: 0.5em 1em;
            border-radius: 2rem;
            font-weight: 600;
            font-size: 0.8rem;
        }
        .btn-action {
            width: 36px;
            height: 36px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            transition: all 0.2s ease;
        }
        .btn-action:hover {
            transform: translateY(-2px);
        }
        .form-switch .form-check-input {
            width: 2.5em;
            height: 1.25em;
            cursor: pointer;
        }
        .form-switch .form-check-input:checked {
            background-color: #FFCC00;
            border-color: #FFCC00;
        }
    </style>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" style="border-radius: 1rem;" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <strong>Sucesso!</strong> {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card map-management-card">
                    <div class="card-body p-4">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
                            <div>
                                <h4 class="fw-bold text-dark mb-1">Central de Mapas</h4>
                                <p class="text-muted small mb-0">Gerencie os locais e endereços exibidos no portal SINPOL-RJ</p>
                            </div>
                            <button type="button" class="btn btn-primary btnModalMapa px-4 py-2 fw-bold shadow-sm" 
                                style="border-radius: 12px;" data-toggle="modal"
                                data-target="#modalMapa" data-rota="{{route('mapas.store')}}">
                                <i class="bi bi-plus-lg me-2"></i> Novo Endereço
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-custom datatable align-middle">
                                <thead>
                                    <tr>
                                        <th scope="col" width="60">ID</th>
                                        <th scope="col" width="220">Prévia Visual</th>
                                        <th scope="col">Informações do Local</th>
                                        <th scope="col" width="100" class="text-center">Visibilidade</th>
                                        <th scope="col" width="130" class="text-end">Gerenciar</th>
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
                                            <td class="fw-bold text-muted">#{{$mapa->id}}</td>
                                            <td>
                                                <div class="preview-frame" style="width: 200px; height: 110px;">
                                                    <iframe width="100%" height="100%" frameborder="0" src="{{ $embed_url }}"></iframe>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center mb-1">
                                                    <div class="bg-light p-2 rounded-circle me-3">
                                                        <i class="bi bi-geo-alt-fill text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark text-truncate" style="max-width: 350px;" title="{{$mapa->link}}">
                                                            {{$mapa->link}}
                                                        </div>
                                                        <div class="text-muted small">
                                                            Sincronizado em: {{ \Carbon\Carbon::parse($mapa->updated_at)->format('d/m/Y H:i') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check form-switch d-inline-block">
                                                    <input class="form-check-input statusSwitchMapa focus-none" type="checkbox"
                                                        data-rota="{{route('atualizar-status-mapa')}}"
                                                        data-id="{{$mapa->id}}" @if($mapa->status) checked @endif>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <div class="d-flex justify-content-end gap-2">
                                                    <button class="btn btn-action btn-outline-primary btn-editar-mapa" 
                                                        data-rota="{{route('mapas.edit', $mapa->id)}}"
                                                        data-rota-update="{{route('mapas.update', $mapa->id)}}" 
                                                        data-toggle="modal"
                                                        data-target="#modalMapa"
                                                        title="Editar endereço">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <button class="btn btn-action btn-outline-danger btn-excluir-mapa"
                                                        data-rota="{{route('mapas.destroy', $mapa->id)}}"
                                                        title="Excluir mapeamento">
                                                        <i class="bi bi-trash3"></i>
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
        </div>
    </section>

    <!-- Modal Modernizado -->
    <div class="modal fade" id="modalMapa" tabindex="-1" role="dialog" aria-labelledby="modalMapaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem;">
                <div class="modal-header bg-white border-0 p-4">
                    <div class="bg-primary-subtle p-3 rounded-4 me-3" style="background: #e9ecef;">
                        <i class="bi bi-map-fill text-primary fs-4"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-dark" id="modalMapaLabel">Gerenciar Unidade</h5>
                        <p class="text-muted small mb-0">Adicione ou edite a localização da delegacia</p>
                    </div>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4 pt-0">
                    <form action="{{route('mapas.store')}}" method="POST" id="mapaForm" class="space-y-4">
                        @csrf

                        <div class="form-group">
                            <label for="link" class="form-label fw-bold text-dark mb-2">Link de Compartilhamento</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0" style="border-radius: 12px 0 0 12px;"><i class="bi bi-link-45deg"></i></span>
                                <input type="text" class="form-control bg-light border-start-0 py-2" name="link" id="link" 
                                    style="border-radius: 0 12px 12px 0;"
                                    placeholder="Cole aqui o link do Google Maps..." required>
                            </div>
                            <div class="mt-3 p-3 bg-light rounded-4 border">
                                <div class="d-flex gap-2">
                                    <i class="bi bi-info-circle-fill text-primary"></i>
                                    <p class="small text-muted mb-0">
                                        <strong>Como obter:</strong> Abra o local no Google Maps, clique em <strong>Compartilhar</strong> e copie o link gerado.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary py-3 fw-bold shadow" style="border-radius: 12px;">
                                SALVAR LOCALIZAÇÃO
                            </button>
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

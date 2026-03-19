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
                        <h5 class="card-title">Mapas</h5>
                        <button type="button" class="btn btn-primary mt-3 btnModalMapa" data-toggle="modal"
                            data-target="#modalMapa" data-rota="{{route('mapas.store')}}">
                            Novo Mapa
                        </button>

                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Link</th>
                                    <th scope="col">Ativo</th>
                                    <th scope="col">Criado em</th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mapas as $mapa)
                                    <tr>
                                        <th scope="row">{{$mapa->id}}</th>
                                        <td>{{$mapa->link}}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input statusSwitchMapa" type="checkbox"
                                                    data-rota="{{route('atualizar-status-mapa')}}"
                                                    data-id="{{$mapa->id}}" @if($mapa->status) checked @endif>
                                            </div>
                                        </td>
                                        <td>{{$mapa->created_at}}</td>
                                        <td>
                                            <i class="bi bi-pencil-square custom-icon-size text-info btn-editar-mapa"
                                                style="cursor: pointer" data-rota="{{route('mapas.edit', $mapa->id)}}"
                                                data-rota-update="{{route('mapas.update', $mapa->id)}}" data-toggle="modal"
                                                data-target="#modalMapa">
                                            </i>
                                            <i class="bi bi-trash custom-icon-size text-danger btn-excluir-mapa"
                                                style="cursor: pointer"
                                                data-rota="{{route('mapas.destroy', $mapa->id)}}"></i>
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
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMapaLabel">Gerenciar Mapa</h5>
                    <button type="button" class="close btn btn-secondary" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="{{route('mapas.store')}}" method="POST" id="mapaForm">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="link">Link do Google Maps</label>
                            <input type="text" class="form-control" name="link" id="link" placeholder="Cole aqui o link do Google Maps" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
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

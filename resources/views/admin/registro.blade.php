@extends('admin.layouts.layout')

@section('menu')

    @include('admin.menu')

@endsection

@section('content')

    <div class="pagetitle">

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item">Regsitro</li>
                <li class="breadcrumb-item active">Usuários </li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('danger'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-octagon me-1"></i>
                {{ session('danger') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </section>

    <!-- Modal Registro -->
    <div class="modal fade" id="usuarioModal" tabindex="-1" role="dialog" aria-labelledby="usuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="{{route('admin.store')}}" name="register" id="register" enctype="multipart/form-data">
                @csrf
                <div class="modal-content shadow-lg border-0">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="usuarioModalLabel"><i class="bi bi-person-plus me-2"></i>Gerenciar Usuário</h5>
                        <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 text-start">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Nome Completo</label>
                            <input id="name" type="text" name="name" class="form-control" placeholder="Ex: João Silva" required>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">E-mail</label>
                            <input id="email" type="email" name="email" class="form-control" placeholder="exemplo@email.com" required>
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label fw-bold">Senha</label>
                                <input id="password" type="password" name="password" class="form-control" placeholder="********">
                                <small class="text-muted">Mínimo 8 caracteres.</small>
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label fw-bold">Confirmar Senha</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="********">
                            </div>
                        </div>

                        <div class="modal-footer border-top-0 pt-3 px-0">
                            <button type="button" class="btn btn-light px-4" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm text-uppercase fw-bold">Salvar Usuário</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card shadow-sm text-center">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title m-0 p-0 text-uppercase">Gerenciar Usuários</h5>
                        <button type="button" class="btn btn-primary btnModalUser px-4 shadow-sm" data-toggle="modal"
                                data-target="#usuarioModal" data-rota="{{route('admin.store')}}">
                            <i class="bi bi-person-plus me-1"></i> Novo Usuário
                        </button>
                    </div>

                    <table class="table datatable table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" width="50">#</th>
                                <th scope="col" class="text-start">Nome</th>
                                <th scope="col" class="text-start">E-mail</th>
                                <th scope="col" width="150">Criado em</th>
                                <th scope="col" width="120">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuarios as $usuario)
                                <tr>
                                    <th scope="row">{{$usuario->id}}</th>
                                    <td class="text-start fw-bold text-dark">{{$usuario->name}}</td>
                                    <td class="text-start">{{$usuario->email}}</td>
                                    <td>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($usuario->created_at)->format('d/m/Y H:i') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group shadow-sm">
                                            <button class="btn btn-sm btn-outline-info btn-editar-usuario" 
                                                data-rota="{{route('usuario.edit',$usuario->id)}}"
                                                data-rota-update="{{route('usuario.update',$usuario->id)}}"
                                                data-toggle="modal" data-target="#usuarioModal"
                                                title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger btn-excluir"
                                                data-rota="{{route('usuario.destroy',$usuario->id)}}"
                                                title="Excluir">
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
@endsection
@push("scripts")
    <script src="{{URL::asset('admin/assets/js/custom.js')}}"></script>
@endpush
@push("styles")
    <link rel="stylesheet" type="text/css" href="{{URL::asset('admin/assets/css/custom.css')}}">

@endpush

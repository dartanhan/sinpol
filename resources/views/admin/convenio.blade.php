@extends('admin.layouts.layout')

@section('menu')

    @include('admin.menu')

@endsection

@section('content')

    <div class="pagetitle">

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item">Convênios</li>
                <li class="breadcrumb-item active">Criar Convênio</li>
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

    <!-- Modal Convênio -->
    <div class="modal fade" id="modalConvenio" tabindex="-1" role="dialog" aria-labelledby="convenioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <form method="POST" action="{{route('convenio.store')}}" name="convenioForm" id="convenioForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-content shadow-lg border-0">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="convenioModalLabel">
                            <i class="bi bi-handshake me-2"></i>Gerenciar Convênio
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 text-start">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label for="titulo" class="form-label fw-bold">Título do Convênio</label>
                                <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Nome da empresa ou serviço" maxlength="150" required>
                                <small class="text-muted">Máximo 150 caracteres.</small>
                            </div>
                            <div class="col-md-4">
                                <label for="slug" class="form-label fw-bold">Slug</label>
                                <input type="text" name="slug" id="slug" readonly class="form-control bg-light" placeholder="Gerado automaticamente">
                            </div>
                            
                            <div class="col-12 mt-3">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-light py-3">
                                        <h6 class="m-0 fw-bold text-primary"><i class="bi bi-pencil-square me-2"></i>Conteúdo do Convênio</h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <textarea class="tinymce_editor" name="tinymce_editor" id="tinymce_editor"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer border-top-0 pt-4 px-0">
                            <button type="button" class="btn btn-light me-2 px-4" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm text-uppercase fw-bold">Salvar Convênio</button>
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
                        <h5 class="card-title m-0 p-0 text-uppercase">Gerenciar Convênios</h5>
                        <button type="button" class="btn btn-primary btnModalConvenio px-4 shadow-sm" data-toggle="modal"
                                data-target="#modalConvenio" data-rota="{{route('convenio.store')}}">
                            <i class="bi bi-plus-circle me-1"></i> Adicionar Convênio
                        </button>
                    </div>

                    <table class="table datatable table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" width="50">#</th>
                                <th scope="col" class="text-start">Título / Link Amigável</th>
                                <th scope="col" width="100">Status</th>
                                <th scope="col" width="150">Criado em</th>
                                <th scope="col" width="120">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($convenios as $convenio)
                                <tr>
                                    <th scope="row">{{$convenio->id}}</th>
                                    <td class="text-start">
                                        <div class="fw-bold text-dark">{{$convenio->titulo}}</div>
                                        <small class="text-info">{{$convenio->slug}}</small>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch d-flex justify-content-center">
                                            <input class="form-check-input statusSwitch" type="checkbox"
                                                   data-toggle="tooltip" data-placement="top"
                                                   title="{{$convenio->status == 0 ? "Inativo" : "Ativo"}}"
                                                   data-id="{{$convenio->id}}"
                                                   data-rota="{{route('atualizar-status-convenio')}}"
                                                   {{$convenio->status == 0 ? "" : "checked"}}>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($convenio->created_at)->format('d/m/Y H:i') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group shadow-sm">
                                            <button class="btn btn-sm btn-outline-info btn-editar-convenio" 
                                                data-rota="{{route('convenio.edit',$convenio->id)}}"
                                                data-rota-update="{{route('convenio.update',$convenio->id)}}"
                                                data-toggle="modal" data-target="#modalConvenio"
                                                title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger btn-excluir"
                                                data-rota="{{route('convenio.destroy',$convenio->id)}}"
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
        @push("styles")
            <link rel="stylesheet" type="text/css" href="{{URL::asset('admin/assets/css/custom.css')}}">
        @endpush
        @push("scripts")
            <script src="{{URL::asset('admin/assets/js/file-pond-custom.js')}}"></script>
            <script src="{{URL::asset('admin/assets/js/custom.js')}}"></script>
        @endpush

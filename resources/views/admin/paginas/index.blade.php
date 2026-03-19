@extends('admin.layouts.layout')
@section('menu')
    @include('admin.menu')
@endsection

@section('content')

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi bi-check-circle me-1"></i>
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($message = Session::get('danger'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi bi-exclamation-octagon me-1"></i>
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title m-0 p-0 text-uppercase">Páginas Institucionais</h5>
                            <button type="button" class="btn btn-primary btnModalPagina px-4 shadow-sm" data-toggle="modal"
                                data-target="#modalPagina" data-rota="{{route('pagina.store')}}">
                                <i class="bi bi-plus-circle me-1"></i> Nova Página
                            </button>
                        </div>

                        <table class="table datatable table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" width="50">#</th>
                                    <th scope="col">Título / URL</th>
                                    <th scope="col" width="100">Status</th>
                                    <th scope="col" width="150">Criado em</th>
                                    <th scope="col" width="120">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paginas as $pagina)
                                    <tr>
                                        <th scope="row">{{$pagina->id}}</th>
                                        <td>
                                            <div class="fw-bold text-dark">{{$pagina->titulo}}</div>
                                            <small class="text-info">{{$pagina->slug}}</small>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch d-flex justify-content-center">
                                                <input class="form-check-input statusSwitch" type="checkbox"
                                                    data-toggle="tooltip" data-placement="top"
                                                    title="{{$pagina->status ? 'Liberado' : 'Bloqueado'}}"
                                                    data-rota="{{route('atualizar-status-pagina')}}"
                                                    data-id="{{$pagina->id}}" @if($pagina->status) checked @endif>
                                            </div>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($pagina->created_at)->format('d/m/Y H:i') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group shadow-sm">
                                                <button class="btn btn-sm btn-outline-info btn-editar-pagina" 
                                                    data-rota="{{route('pagina.edit', $pagina->id)}}"
                                                    data-rota-update="{{route('pagina.update', $pagina->id)}}"
                                                    data-toggle="modal" data-target="#modalPagina"
                                                    title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger btn-excluir"
                                                    data-rota="{{route('pagina.destroy', $pagina->id)}}"
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
    </section>

    <!-- Modal Pagina -->
    <div class="modal fade" id="modalPagina" tabindex="-1" role="dialog" aria-labelledby="modalPaginaLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalPaginaLabel"><i class="bi bi-file-earmark-richtext me-2"></i>Gerenciar Página</h5>
                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <form action="{{route('pagina.store')}}" method="POST" enctype="multipart/form-data" id="paginaForm">
                        @csrf
                        <div class="row g-3">
                            @if (auth("web")->user()->admin)
                                <div class="col-md-8 text-start">
                                    <label for="titulo" class="form-label fw-bold">Título Identificador</label>
                                    <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Ex: História do Sinpol" required>
                                    <small class="text-muted">Nome descritivo da página.</small>
                                </div>

                                <div class="col-md-4 text-start">
                                    <label for="slug" class="form-label fw-bold">Slug (URL)</label>
                                    <input type="text" class="form-control bg-light" name="slug" id="slug" placeholder="Gerado automaticamente" readonly>
                                </div>
                            @endif

                            <div class="col-12 mt-3">
                                <label class="form-label fw-bold">Conteúdo da Página</label>
                                <textarea id="tinymce_editor" name="tinymce_editor" class="tinymce_editor"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer border-top-0 pt-4 px-0">
                            <button type="button" class="btn btn-light px-4" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm text-uppercase fw-bold">Salvar Página</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push("scripts")
    <script src="{{URL::asset('admin/assets/js/file-pond-custom.js')}}"></script>
    <script src="{{URL::asset('admin/assets/js/custom.js')}}?v={{time()}}"></script>
    <script src="{{URL::asset('admin/assets/js/custom_pagina.js')}}?v={{time()}}"></script>
@endpush
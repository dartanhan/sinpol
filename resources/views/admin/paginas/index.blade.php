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
                        <h5 class="card-title">Páginas Institucionais (História, Fale Conosco, etc.)</h5>
                        <button type="button" class="btn btn-primary mt-3 btnModalPagina" data-toggle="modal"
                            data-target="#modalPagina" data-rota="{{route('pagina.store')}}">
                            Nova Página
                        </button>

                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Título</th>
                                    <th scope="col">Slug (URL)</th>
                                    <th scope="col">Ativo</th>
                                    <th scope="col">Criado em</th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paginas as $pagina)
                                    <tr>
                                        <th scope="row">{{$pagina->id}}</th>
                                        <td>{{$pagina->titulo}}</td>
                                        <td>{{$pagina->slug}}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input statusSwitch" type="checkbox"
                                                    id="flexSwitchCheckChecked" data-rota="{{route('atualizar-status-pagina')}}"
                                                    data-id="{{$pagina->id}}" @if($pagina->status) checked @endif>
                                            </div>
                                        </td>
                                        <td>{{$pagina->created_at}}</td>
                                        <td>
                                            <i class="bi bi-pencil-square custom-icon-size text-info btn-editar-pagina"
                                                style="cursor: pointer" data-rota="{{route('pagina.edit', $pagina->id)}}"
                                                data-rota-update="{{route('pagina.update', $pagina->id)}}" data-toggle="modal"
                                                data-target="#modalPagina">
                                            </i>
                                            <i class="bi bi-trash custom-icon-size text-danger btn-excluir"
                                                style="cursor: pointer"
                                                data-rota="{{route('pagina.destroy', $pagina->id)}}"></i>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Modal Pagina -->
    <div class="modal fade" id="modalPagina" tabindex="-1" role="dialog" aria-labelledby="modalPaginaLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPaginaLabel">Gerenciar Página</h5>
                    <button type="button" class="close btn btn-secondary" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('pagina.store')}}" method="POST" enctype="multipart/form-data" id="paginaForm">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="titulo">Título Identificador (ex: História)</label>
                            <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Título da Página"
                                required>
                            <small class="form-text text-muted">A URL (slug) será gerada automaticamente a partir do título
                                (ex: historia).</small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="slug">Slug (URL)</label>
                            <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug automático"
                                readonly>
                        </div>

                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                Crie o conteúdo da Página!
                            </div>
                            <div class="card-body mt-4">
                                <textarea id="tinymce_editor" name="tinymce_editor" class="tinymce_editor"></textarea>
                            </div>
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
    <script src="{{URL::asset('admin/assets/js/file-pond-custom.js')}}"></script>
    <script src="{{URL::asset('admin/assets/js/custom.js')}}?v={{time()}}"></script>
    <script src="{{URL::asset('admin/assets/js/custom_pagina.js')}}?v={{time()}}"></script>
@endpush
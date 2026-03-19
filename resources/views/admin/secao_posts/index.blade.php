@extends('admin.layouts.layout')
@section('menu')
    @include('admin.menu')
@endsection

@section('content')
    @php
        $titulos = [
            'sinpol-animal' => 'SINPOL ANIMAL',
            'sinpol-mulher' => 'SINPOL MULHER',
            'sinpol-permutas' => 'SINPOL PERMUTAS',
            'classificados-sinpol' => 'CLASSIFICADOS DO SINPOL',
            'sinpol-fiscaliza' => 'SINPOL FISCALIZA',
            'sinpol-na-rua' => 'SINPOL NA RUA',
            'sinpol-denuncias' => 'SINPOL DENÚNCIAS'
        ];
        $tituloDaTela = isset($titulos[$tipo]) ? $titulos[$tipo] : ucfirst(str_replace('-', ' ', $tipo));
    @endphp

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

    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title m-0 p-0 text-uppercase">{{ $tituloDaTela }}</h5>
                        <button type="button" class="btn btn-primary btnModalSecao px-4 shadow-sm" data-toggle="modal"
                            data-target="#modalSecao" data-rota="{{route($tipo.'.store')}}">
                            <i class="bi bi-plus-circle me-1"></i> Nova Entrada
                        </button>
                    </div>

                    <table class="table datatable table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" width="50">#</th>
                                <th scope="col">Título do Post</th>
                                <th scope="col" width="100">Status</th>
                                <th scope="col" width="150">Criado em</th>
                                <th scope="col" width="120">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $post)
                                <tr>
                                    <th scope="row">{{$post->id}}</th>
                                    <td>
                                        <div class="fw-bold text-dark">{{$post->titulo}}</div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch d-flex justify-content-center">
                                            <input class="form-check-input statusSwitch" type="checkbox"
                                                data-rota="{{route($tipo.'.atualizar-status')}}"
                                                data-id="{{$post->id}}" @if($post->status) checked @endif
                                                title="Ativar/Desativar no site">
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y H:i') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group shadow-sm">
                                            <button class="btn btn-sm btn-outline-info btn-editar-secao" 
                                                data-rota="{{route($tipo.'.edit', $post->id)}}"
                                                data-rota-update="{{route($tipo.'.update', $post->id)}}" 
                                                data-toggle="modal" data-target="#modalSecao"
                                                title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger btn-excluir-secao"
                                                data-rota="{{route($tipo.'.destroy', $post->id)}}"
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

            </div>
        </div>
    </section>

    <!-- Modal Secao -->
    <div class="modal fade" id="modalSecao" tabindex="-1" role="dialog" aria-labelledby="modalSecaoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSecaoLabel">Gerenciar Conteúdo - {{ $tituloDaTela }}</h5>
                    <button type="button" class="close btn btn-secondary" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="{{route($tipo.'.store')}}" method="POST" enctype="multipart/form-data" id="secaoForm">
                        @csrf

                        <div class="form-group mb-3 d-none">
                            <label for="titulo">Título Interno</label>
                            <input type="text" class="form-control" name="titulo" id="titulo">
                        </div>

                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                Crie o conteúdo para {{ $tituloDaTela }}!
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
    <script src="{{URL::asset('admin/assets/js/custom_secao.js')}}?v={{time()}}"></script>
@endpush

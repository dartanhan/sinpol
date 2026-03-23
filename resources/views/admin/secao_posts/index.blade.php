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
            'sinpol-denuncias' => 'SINPOL DENÚNCIAS',
            'sinpol-idoso' => 'SINPOL IDOSO',
            'sinpol-esportes' => 'SINPOL ESPORTES',
            'sinpol-peritos' => 'SINPOL PERITOS',
            'diretoria' => 'DIRETORIA',
            'historia' => 'HISTÓRIA',
            'fale-conosco' => 'FALE CONOSCO',
            'como-chegar' => 'COMO CHEGAR',
            'principais-links' => 'PRINCIPAIS LINKS',
            'convenio' => 'CONVÊNIOS'
        ];
        $tipo_str = (string) $tipo;
        $tituloDaTela = isset($titulos[$tipo_str]) ? $titulos[$tipo_str] : ucfirst(str_replace('-', ' ', $tipo_str));
    @endphp

    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item">Páginas</li>
                <li class="breadcrumb-item active">{{ $tituloDaTela }}</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
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
                                    <th scope="col" width="100" class="text-center">Status</th>
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
                                            <small class="text-muted">ID: {{$post->id}}</small>
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
    </section>

    <!-- Modal Secao -->
    <div class="modal fade" id="modalSecao" tabindex="-1" role="dialog" aria-labelledby="modalSecaoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalSecaoLabel">
                        <i class="bi bi-pencil-square me-2"></i>Gerenciar {{ $tituloDaTela }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <form action="{{route($tipo.'.store')}}" method="POST" enctype="multipart/form-data" id="secaoForm">
                        @csrf

                        <input type="hidden" name="titulo" id="titulo" value="{{ $tituloDaTela }}">

                        <div class="card shadow-none border">
                            <div class="card-header bg-light fw-bold">
                                <i class="bi bi-type me-1"></i> Editor de Conteúdo - {{ $tituloDaTela }}
                            </div>
                            <div class="card-body p-0">
                                <textarea id="tinymce_editor" name="tinymce_editor" class="tinymce_editor"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer border-top-0 pt-4 px-0">
                            <button type="button" class="btn btn-light me-2 px-4" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm">Salvar Alterações</button>
                        </div>
                    </form>
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
    <script src="{{URL::asset('admin/assets/js/custom.js')}}?v={{time()}}"></script>
    <script src="{{URL::asset('admin/assets/js/custom_secao.js')}}?v={{time()}}"></script>
@endpush

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
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title m-0 p-0 text-uppercase fw-bold text-primary">
                                <i class="bi bi-stack me-2"></i>{{ $tituloDaTela }}
                            </h5>
                            <a href="{{ route($tipo.'.create') }}" class="btn btn-primary px-4 shadow-sm fw-bold">
                                <i class="bi bi-plus-circle me-1"></i> Nova Entrada
                            </a>
                        </div>

                        <table class="table datatable table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" width="50" class="text-center">#</th>
                                    <th scope="col" class="text-start">Título do Post</th>
                                    <th scope="col" width="100" class="text-center">Status</th>
                                    <th scope="col" width="150" class="text-center">Criado em</th>
                                    <th scope="col" width="120" class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $post)
                                    <tr>
                                        <th scope="row" class="text-center">{{$post->id}}</th>
                                        <td class="text-start">
                                            <div class="fw-bold text-dark">{{$post->titulo}}</div>
                                            <small class="text-muted">ID: {{$post->id}}</small>
                                        </td>
                                        <td class="text-center">
                                            @if($post->status == 1)
                                                <span class="badge bg-success text-uppercase">Publicado</span>
                                            @else
                                                <span class="badge bg-secondary text-uppercase">Rascunho</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <small class="text-muted fw-semibold">{{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y H:i') }}</small>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group shadow-sm">
                                                <a href="{{ route($tipo.'.edit', $post->id) }}" class="btn btn-sm btn-outline-info" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
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
@endsection

@push("styles")
    <link rel="stylesheet" type="text/css" href="{{URL::asset('admin/assets/css/custom.css')}}">
@endpush

@push("scripts")
    <script src="{{URL::asset('admin/assets/js/file-pond-custom.js')}}"></script>
    <script src="{{URL::asset('admin/assets/js/custom.js')}}?v={{time()}}"></script>
    <script src="{{URL::asset('admin/assets/js/custom_secao.js')}}?v={{time()}}"></script>
@endpush

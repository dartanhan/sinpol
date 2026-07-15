@extends('admin.layouts.layout')

@section('menu')
    @include('admin.menu')
@endsection

@section('content')

    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Notícias</li>
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

    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title m-0 p-0 text-uppercase">Gerenciar Notícias</h5>
                        <a href="{{route('noticia.create')}}" class="btn btn-primary px-4 shadow-sm">
                            <i class="bi bi-plus-circle me-1"></i> Nova Notícia
                        </a>
                    </div>

                    <table class="table datatable table-hover align-middle table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" width="50">#</th>
                                <th scope="col" class="text-start">Título / Resumo</th>
                                <th scope="col" width="100" class="text-center">Status</th>
                                <th scope="col" width="150" class="text-center">Criado em</th>
                                <th scope="col" width="120" class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($noticias as $noticia)
                                <tr>
                                    <th scope="row">{{$noticia->id}}</th>
                                    <td class="text-start">
                                        <div class="fw-bold text-dark">{{$noticia->titulo}}</div>
                                        <div class="text-muted small text-truncate" style="max-width: 450px;" title="{{ $noticia->subtitulo }}">
                                            {{$noticia->subtitulo ?: 'Sem resumo'}}
                                        </div>
                                        <small class="text-info">{{$noticia->slug}}</small>
                                        @if($noticia->destaque)
                                            <span class="badge bg-warning text-dark text-uppercase ms-1" style="font-size: 0.65rem;">Destaque</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($noticia->status == 1)
                                            <span class="badge bg-success text-uppercase">Publicado</span>
                                        @else
                                            <span class="badge bg-secondary text-uppercase">Rascunho</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <small class="text-muted d-block fw-semibold">{{ \Carbon\Carbon::parse($noticia->created_at)->format('d/m/Y H:i') }}</small>
                                        <small class="text-secondary" style="font-size: 0.75rem;">Mod: {{ $noticia->updated_at_formatted }}</small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group shadow-sm">
                                            <a href="{{route('noticia.edit',$noticia->id)}}" class="btn btn-sm btn-outline-info" title="Editar Notícia">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger btn-excluir"
                                                data-rota="{{route('noticia.destroy',$noticia->id)}}"
                                                title="Excluir Notícia">
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
    <script src="{{URL::asset('admin/assets/js/custom.js')}}"></script>
@endpush

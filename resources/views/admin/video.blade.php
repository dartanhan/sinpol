@extends('admin.layouts.layout')

@section('menu')
    @include('admin.menu')
@endsection

@section('content')

    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Vídeos</li>
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
                        <h5 class="card-title m-0 p-0 text-uppercase">Gerenciar Vídeos</h5>
                        <a href="{{route('video.create')}}" class="btn btn-primary px-4 shadow-sm">
                            <i class="bi bi-plus-circle me-1"></i> Novo Vídeo
                        </a>
                    </div>

                    <table class="table datatable table-hover align-middle table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" width="50">#</th>
                                <th scope="col" width="220" class="text-center">Miniatura</th>
                                <th scope="col" class="text-start">Informações do Vídeo</th>
                                <th scope="col" width="120" class="text-center">Status</th>
                                <th scope="col" width="120" class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($videos as $video)
                                <tr>
                                    <th scope="row">{{$video->id}}</th>
                                    <td class="text-center">
                                        @php
                                            $embed_url = $video->link;
                                            if (strpos($embed_url, 'youtube.com/watch?v=') !== false) {
                                                $embed_url = str_replace('youtube.com/watch?v=', 'youtube.com/embed/', $embed_url);
                                                $embed_url = explode('&', $embed_url)[0];
                                            } elseif (strpos($embed_url, 'youtu.be/') !== false) {
                                                $embed_url = str_replace('youtu.be/', 'youtube.com/embed/', $embed_url);
                                            } elseif (strpos($embed_url, 'youtube.com/shorts/') !== false) {
                                                $embed_url = str_replace('youtube.com/shorts/', 'youtube.com/embed/', $embed_url);
                                            }
                                        @endphp
                                        <div class="border rounded overflow-hidden shadow-sm mx-auto"
                                            style="width: 180px; height: 100px;">
                                            <iframe width="100%" height="100%" src="{{ $embed_url }}" frameborder="0"
                                                allowfullscreen></iframe>
                                        </div>
                                    </td>
                                    <td class="text-start">
                                        <div class="fw-bold text-dark">{{$video->titulo}}</div>
                                        <div class="text-muted small text-truncate" style="max-width: 450px;"
                                            title="{{ $video->subtitulo }}">
                                            {{$video->subtitulo ?: 'Sem descrição'}}
                                        </div>
                                        <small class="text-info">{{$video->slug}}</small>
                                    </td>
                                    <td class="text-center">
                                        @if($video->status == 1)
                                            <span class="badge bg-success text-uppercase">Publicado</span>
                                        @else
                                            <span class="badge bg-secondary text-uppercase">Rascunho</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group shadow-sm">
                                            <a href="{{route('video.edit', $video->id)}}" class="btn btn-sm btn-outline-info"
                                                title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger btn-excluir"
                                                data-rota="{{route('video.destroy', $video->id)}}" title="Excluir">
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
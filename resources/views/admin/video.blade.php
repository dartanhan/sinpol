@extends('admin.layouts.layout')

@section('menu')

    @include('admin.menu')

@endsection

@section('content')

    <div class="pagetitle">

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item">Vídeos</li>
                <li class="breadcrumb-item active">Gerenciar Vídeos</li>
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

    <!-- Modal Video -->
    <div class="modal fade" id="modalVideo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form method="POST" action="{{route('video.store')}}" name="videoForm" id="videoForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-content shadow-lg border-0">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <i class="bi bi-play-btn-fill me-2"></i>Gerenciar Vídeo
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-12 text-start">
                                <label for="link" class="form-label font-weight-bold">Link do YouTube</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-youtube text-danger"></i></span>
                                    <input type="text" name="link" id="link" class="form-control" 
                                           placeholder="Ex: https://www.youtube.com/watch?v=..." required>
                                </div>
                            </div>
                            <div class="col-md-6 text-start">
                                <label for="titulo" class="form-label font-weight-bold">Título do Vídeo</label>
                                <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Título que aparecerá no site" required>
                            </div>
                            <div class="col-md-6 text-start">
                                <label for="slug" class="form-label font-weight-bold">Slug</label>
                                <input type="text" name="slug" id="slug" readonly class="form-control bg-light" placeholder="Gerado automaticamente">
                            </div>
                            <div class="col-md-12 text-start mt-3">
                                <label for="subtitulo" class="form-label font-weight-bold">Subtítulo / Descrição Curta</label>
                                <textarea name="subtitulo" id="subtitulo" class="form-control" rows="3" placeholder="Breve resumo sobre o vídeo"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer border-top-0 pt-4 px-0">
                            <button type="button" class="btn btn-light me-2 px-4" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm">Salvar Vídeo</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title m-0 p-0">Gerenciar Vídeos</h5>
                        <button type="button" class="btn btn-primary btnModalVideo px-4 shadow-sm" data-toggle="modal"
                                data-target="#modalVideo" data-rota="{{route('video.store')}}">
                            <i class="bi bi-plus-circle me-1"></i> Adicionar Novo Vídeo
                        </button>
                    </div>

                    <table class="table datatable table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" width="50">#</th>
                                <th scope="col" width="250">Miniatura</th>
                                <th scope="col">Informações do Vídeo</th>
                                <th scope="col" width="100">Status</th>
                                <th scope="col" width="120">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($videos as $video)
                                <tr>
                                    <th scope="row">{{$video->id}}</th>
                                    <td>
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
                                        <div class="border rounded overflow-hidden shadow-sm" style="width: 220px; height: 120px;">
                                            <iframe width="100%" height="100%" src="{{ $embed_url }}" 
                                                    frameborder="0" allowfullscreen></iframe>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{$video->titulo}}</div>
                                        <div class="text-muted small text-truncate" style="max-width: 300px;" title="{{ $video->subtitulo }}">
                                            {{$video->subtitulo ?: 'Sem descrição'}}
                                        </div>
                                        <small class="text-info">{{$video->slug}}</small>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch d-flex justify-content-center">
                                            <input class="form-check-input statusSwitch" type="checkbox"
                                                   data-toggle="tooltip" data-placement="top"
                                                   title="{{$video->status == 0 ? "Bloqueado" : "Liberado"}}"
                                                   data-id="{{$video->id}}"
                                                   data-rota="{{route('atualizar-status-video')}}"
                                                   {{$video->status == 0 ? "" : "checked"}}>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group shadow-sm">
                                            <button class="btn btn-sm btn-outline-info btn-editar-video" 
                                                data-rota="{{route('video.edit',$video->id)}}"
                                                data-rota-update="{{route('video.update',$video->id)}}"
                                                data-toggle="modal" data-target="#modalVideo"
                                                title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger btn-excluir"
                                                data-rota="{{route('video.destroy',$video->id)}}"
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
            <script>
                $(document).ready(function() {
                    $('#link').on('input', function() {
                        var url = $(this).val();
                        if (url.includes('youtube.com/shorts/')) {
                            var videoId = url.split('/shorts/')[1].split('?')[0];
                            var newUrl = 'https://www.youtube.com/watch?v=' + videoId;
                            $(this).val(newUrl);
                            toastr.info('Link do YouTube Shorts convertido para formato compatível.');
                        }
                    });

                    $('#videoForm').on('submit', function() {
                        var btn = $(this).find('button[type="submit"]');
                        btn.prop('disabled', true);
                        btn.html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Salvando...');
                    });
                });
            </script>
        @endpush

@extends('admin.layouts.layout')

@section('menu')
    @include('admin.menu')
@endsection

@section('content')
    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('video.index')}}">Vídeos</a></li>
                <li class="breadcrumb-item active">Criar Vídeo</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3 d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 p-0 text-white text-uppercase fw-bold">
                            <i class="bi bi-plus-circle me-2"></i>Criar Vídeo
                        </h5>
                        <a href="{{route('video.index')}}" class="btn btn-light btn-sm text-uppercase fw-bold px-3">
                            <i class="bi bi-arrow-left me-1"></i> Voltar
                        </a>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{route('video.store')}}" name="videoForm" id="videoForm">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-12 text-start">
                                    <label for="link" class="form-label fw-bold">Link do YouTube</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i
                                                class="bi bi-youtube text-danger"></i></span>
                                        <input type="text" name="link" id="link" class="form-control"
                                            placeholder="Ex: https://www.youtube.com/watch?v=..." required
                                            value="{{ old('link') }}">
                                    </div>
                                    <small class="text-muted">Suporta links normais, Shorts e links curtos
                                        (youtu.be).</small>
                                </div>

                                <div class="col-md-6 text-start">
                                    <label for="titulo" class="form-label fw-bold">Título do Vídeo</label>
                                    <input type="text" name="titulo" id="titulo" class="form-control"
                                        placeholder="Título descritivo" required value="{{ old('titulo') }}">
                                </div>

                                <div class="col-md-6 text-start">
                                    <label for="slug" class="form-label fw-bold">Slug</label>
                                    <input type="text" name="slug" id="slug" readonly class="form-control bg-light"
                                        placeholder="Gerado automaticamente" value="{{ old('slug') }}">
                                </div>

                                <div class="col-md-12 text-start">
                                    <label for="subtitulo" class="form-label fw-bold">Subtítulo / Descrição Curta</label>
                                    <textarea name="subtitulo" id="subtitulo" class="form-control" rows="3"
                                        placeholder="Breve descrição ou resumo sobre o conteúdo do vídeo">{{ old('subtitulo') }}</textarea>
                                </div>

                                <x-status-select status="1" />
                            </div>

                            <div class="text-end mt-4">
                                <a href="{{route('video.index')}}" class="btn btn-light me-2 px-4">Cancelar</a>
                                <button type="submit" class="btn btn-primary px-5 shadow-sm text-uppercase fw-bold">Salvar
                                    Vídeo</button>
                            </div>
                        </form>
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
    <script src="{{URL::asset('admin/assets/js/custom.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const linkInput = document.getElementById('link');
            if (linkInput) {
                linkInput.addEventListener('input', function () {
                    let url = this.value.trim();
                    if (url.includes('youtube.com/shorts/')) {
                        const parts = url.split('/shorts/');
                        const videoId = parts[1].split('?')[0];
                        const newUrl = 'https://www.youtube.com/watch?v=' + videoId;
                        this.value = newUrl;
                        if (typeof toastr !== 'undefined') {
                            toastr.info('Link do YouTube Shorts convertido para formato compatível.');
                        }
                    }
                });
            }

            const videoForm = document.getElementById('videoForm');
            if (videoForm) {
                videoForm.addEventListener('submit', function () {
                    const submitBtn = videoForm.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Salvando...';
                    }
                });
            }
        });
    </script>
@endpush
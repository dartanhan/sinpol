@extends('admin.layouts.layout')

@section('menu')
    @include('admin.menu')
@endsection

@section('content')
    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('noticia.index')}}">Notícias</a></li>
                <li class="breadcrumb-item active">Editar Notícia</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3 d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 p-0 text-white text-uppercase fw-bold">
                            <i class="bi bi-pencil me-2"></i>Editar Notícia
                        </h5>
                        <a href="{{route('noticia.index')}}" class="btn btn-light btn-sm text-uppercase fw-bold px-3">
                            <i class="bi bi-arrow-left me-1"></i> Voltar
                        </a>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{route('noticia.update', $noticia->id)}}" name="noticiaForm" id="noticiaForm" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="idImagemDestaque" id="idImagemDestaque" value="{{ old('idImagemDestaque', $noticia->imagem_id) }}"/>
                            
                            <div class="row g-3">
                                <div class="col-md-8 text-start">
                                    <label for="titulo" class="form-label fw-bold">Título da Notícia</label>
                                    <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Título impactante para a notícia" maxlength="60" required value="{{ old('titulo', $noticia->titulo) }}">
                                    <small class="text-muted">Máximo 60 caracteres.</small>
                                </div>
                                <div class="col-md-4 text-start">
                                    <label for="slug" class="form-label fw-bold">Slug</label>
                                    <input type="text" name="slug" id="slug" readonly class="form-control bg-light" placeholder="Gerado automaticamente" value="{{ old('slug', $noticia->slug) }}">
                                </div>
                                
                                <div class="col-md-12 text-start">
                                    <label for="subtitulo" class="form-label fw-bold">Subtítulo (Resumo)</label>
                                    <textarea name="subtitulo" id="subtitulo" class="form-control" rows="2" placeholder="Um breve resumo que aparecerá no slider e listagens" maxlength="250">{{ old('subtitulo', $noticia->subtitulo) }}</textarea>
                                </div>
                                
                                <div class="col-md-4 text-start d-flex align-items-center">
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" id="destaque" name="destaque" {{ old('destaque', $noticia->destaque) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold ms-2" for="destaque">Definir como Destaque?</label>
                                    </div>
                                </div>

                                <div class="col-md-4 text-start">
                                    <label for="status" class="form-label fw-bold">Status</label>
                                    <select name="status" id="status" class="form-select" required>
                                        <option value="1" {{ old('status', $noticia->status) == '1' ? 'selected' : '' }}>ATIVO / PUBLICADO</option>
                                        <option value="0" {{ old('status', $noticia->status) == '0' ? 'selected' : '' }}>INATIVO / RASCUNHO</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-4 text-end d-flex align-items-end justify-content-end">
                                    <button type="button" class="btn btn-outline-primary w-100" id="modalImage">
                                        <i class="bi bi-image me-1"></i> Selecionar Imagem de Capa
                                    </button>
                                </div>

                                @php
                                    $hasCapa = old('idImagemDestaque', $noticia->imagem_id);
                                    $capaImg = $noticia->imagens->first();
                                    $capaUrl = $capaImg ? URL::asset('storage/posts/files/'.$capaImg->path) : '';
                                @endphp
                                <div class="col-12" id="editorContainer" style="display: {{ $hasCapa ? 'block' : 'none' }};">
                                    <div class="d-flex justify-content-center border rounded p-2 bg-light shadow-sm">
                                        <img src="{{ $capaUrl }}" alt="Preview" id="previewImagem" style="max-height: 200px; width: auto;" class="img-fluid rounded">
                                    </div>
                                </div>

                                <div class="col-12 mt-4">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header bg-light py-3 d-flex align-items-center justify-content-between">
                                            <h6 class="m-0 fw-bold text-primary"><i class="bi bi-pencil-square me-2"></i>Conteúdo da Notícia</h6>
                                            <button type="button" class="btn btn-warning btn-sm text-white px-3 fw-bold shadow-sm" data-target="#exampleModalImage" data-toggle="modal">
                                                <i class="bi bi-images me-1"></i> Galeria
                                            </button>
                                        </div>
                                        <div class="card-body p-0">
                                            <textarea class="tinymce_editor" name="tinymce_editor" id="tinymce_editor">{{ old('tinymce_editor', $noticia->conteudo) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <a href="{{route('noticia.index')}}" class="btn btn-light me-2 px-4">Cancelar</a>
                                <button type="submit" class="btn btn-primary px-5 shadow-sm text-uppercase fw-bold">Salvar Alterações</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Galeria/Imagens -->
    <div class="modal fade" id="exampleModalImage" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-images me-2"></i>Galeria de Imagens</h5>
                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0" style="max-height: 500px; overflow-y: auto;">
                    <div class="row g-2 p-3">
                        @foreach($images as $image)
                            <div class="col-md-3 col-6">
                                <div class="card h-100 shadow-sm border-0 gallery-item">
                                    <img src="{{URL::asset('storage/posts/files/'.$image->path)}}" 
                                         class="card-img-top rounded resize-image-gallery" 
                                         style="height: 120px; object-fit: cover; cursor: pointer;"
                                         title="Clique para selecionar"
                                         data-dismiss="modal">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Seleção de Imagem (usado pelo botão Capa) -->
    <div class="modal fade" id="imagemModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-image me-2"></i>Selecione a Imagem de Capa</h5>
                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0" style="max-height: 500px; overflow-y: auto;">
                    <div class="row g-2 p-3">
                        @foreach($images as $image)
                            <div class="col-md-3 col-6">
                                <div class="card h-100 shadow-sm border-0">
                                    <img src="{{URL::asset('storage/posts/files/'.$image->path)}}" 
                                         data-id="{{$image->id}}" 
                                         class="card-img-top rounded imagem-selecao" 
                                         style="height: 120px; object-fit: cover; cursor: pointer;" 
                                         title="Selecionar esta imagem">
                                </div>
                            </div>
                        @endforeach
                    </div>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let noticiaForm = document.getElementById('noticiaForm');
            if (noticiaForm) {
                noticiaForm.addEventListener('submit', function (event) {
                    const tinymceContent = tinymce.get('tinymce_editor').getContent();
                    if (tinymceContent.trim() === "") {
                        event.preventDefault();
                        Swal.fire({
                            title: 'Atenção!',
                            text: 'O Conteúdo da notícia não pode estar vazio!',
                            icon: 'info',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }
                    tinymce.triggerSave();
                });
            }
        });
    </script>
@endpush

@extends('admin.layouts.layout')

@section('menu')
    @include('admin.menu')
@endsection

@section('content')
    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('beneficio.index')}}">Benefícios</a></li>
                <li class="breadcrumb-item active">Editar Benefício</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3 d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 p-0 text-white text-uppercase">
                            <i class="bi bi-pencil-square me-2"></i>Editar Benefício
                        </h5>
                        <a href="{{route('beneficio.index')}}" class="btn btn-light btn-sm text-uppercase fw-bold px-3">
                            <i class="bi bi-arrow-left me-1"></i> Voltar
                        </a>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{route('beneficio.update', $beneficio->id)}}" name="beneficioForm" id="beneficioForm" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="titulo" class="form-label fw-bold">Título do Benefício</label>
                                    <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Nome do benefício" maxlength="150" required value="{{ old('titulo', $beneficio->titulo) }}">
                                    <small class="text-muted">Máximo 150 caracteres.</small>
                                </div>
                                <div class="col-md-3">
                                    <label for="slug" class="form-label fw-bold">Slug</label>
                                    <input type="text" name="slug" id="slug" readonly class="form-control bg-light" placeholder="Gerado automaticamente" value="{{ old('slug', $beneficio->slug) }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="status" class="form-label fw-bold">Status</label>
                                    <select name="status" id="status" class="form-select" required>
                                        <option value="1" {{ old('status', $beneficio->status) == '1' ? 'selected' : '' }}>ATIVO / PUBLICADO</option>
                                        <option value="0" {{ old('status', $beneficio->status) == '0' ? 'selected' : '' }}>INATIVO / RASCUNHO</option>
                                    </select>
                                </div>
                                
                                <div class="col-12 mt-4">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header bg-light py-3 d-flex align-items-center justify-content-between">
                                            <h6 class="m-0 fw-bold text-primary"><i class="bi bi-pencil-square me-2"></i>Detalhes do Benefício</h6>
                                            <button type="button" class="btn btn-warning btn-sm text-white px-3 fw-bold" data-target="#exampleModalImage" data-toggle="modal">
                                                <i class="bi bi-images me-1"></i> Galeria
                                            </button>
                                        </div>
                                        <div class="card-body p-0">
                                            <textarea class="tinymce_editor" name="tinymce_editor" id="tinymce_editor">{{ old('tinymce_editor', $beneficio->conteudo) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <a href="{{route('beneficio.index')}}" class="btn btn-light me-2 px-4">Cancelar</a>
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
                    <h5 class="modal-title"><i class="bi bi-images me-2"></i>Galeria de Imagens</h5>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ URL::asset('admin/assets/js/custom.js') }}"></script>
@endpush

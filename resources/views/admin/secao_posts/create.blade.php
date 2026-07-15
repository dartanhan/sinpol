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
                <li class="breadcrumb-item"><a href="{{route($tipo.'.index')}}">{{ $tituloDaTela }}</a></li>
                <li class="breadcrumb-item active">Nova Entrada</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        @if ($message = Session::get('danger'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-octagon me-1"></i>
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3 d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 p-0 text-white text-uppercase fw-bold">
                            <i class="bi bi-plus-circle me-2"></i>Nova Entrada em {{ $tituloDaTela }}
                        </h5>
                        <a href="{{route($tipo.'.index')}}" class="btn btn-light btn-sm text-uppercase fw-bold px-3">
                            <i class="bi bi-arrow-left me-1"></i> Voltar
                        </a>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{route($tipo.'.store')}}" name="secaoForm" id="secaoForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="titulo" class="form-label fw-bold">Título do Post</label>
                                    <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Título" maxlength="150" required value="{{ old('titulo', $tituloDaTela) }}">
                                    <small class="text-muted">Máximo 150 caracteres.</small>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label for="status" class="form-label fw-bold text-uppercase">Status</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>ATIVO / PUBLICADO</option>
                                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>INATIVO / RASCUNHO</option>
                                    </select>
                                </div>
                                
                                <div class="col-12 mt-4">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header bg-light py-3 d-flex align-items-center justify-content-between">
                                            <h6 class="m-0 fw-bold text-primary"><i class="bi bi-pencil-square me-2"></i>Conteúdo</h6>
                                            <button type="button" class="btn btn-warning btn-sm text-white px-3 fw-bold shadow-sm" data-target="#exampleModalImage" data-toggle="modal">
                                                <i class="bi bi-images me-1"></i> Galeria
                                            </button>
                                        </div>
                                        <div class="card-body p-0">
                                            <textarea class="tinymce_editor" name="tinymce_editor" id="tinymce_editor">{{ old('tinymce_editor') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <a href="{{route($tipo.'.index')}}" class="btn btn-light me-2 px-4">Cancelar</a>
                                <button type="submit" class="btn btn-primary px-5 shadow-sm text-uppercase fw-bold">Salvar Entrada</button>
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
@endsection

@push('scripts')
    <script src="{{ URL::asset('admin/assets/js/custom.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let secaoForm = document.getElementById('secaoForm');
            if (secaoForm) {
                secaoForm.addEventListener('submit', function (event) {
                    const tinymceContent = tinymce.get('tinymce_editor').getContent();
                    if (tinymceContent.trim() === "") {
                        event.preventDefault();
                        Swal.fire({
                            title: 'Atenção!',
                            text: 'O Conteúdo está vazio!',
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

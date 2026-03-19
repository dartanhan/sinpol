@extends('admin.layouts.layout')

@section('menu')

    @include('admin.menu')

@endsection

@section('content')

    <div class="pagetitle">

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item">Notícias</li>
                <li class="breadcrumb-item active">Criar Notícia</li>
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

    <!-- Modal Notícia -->
    <div class="modal fade" id="modalNoticia" tabindex="-1" role="dialog" aria-labelledby="noticiaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <form method="POST" action="{{route('noticia.store')}}" name="noticiaForm" id="noticiaForm" enctype="multipart/form-data">
                <input type="hidden" name="idImagemDestaque" id="idImagemDestaque"/>
                @csrf
                <div class="modal-content shadow-lg border-0">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="noticiaModalLabel">
                            <i class="bi bi-newspaper me-2"></i>Gerenciar Notícia
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-8 text-start">
                                <label for="titulo" class="form-label font-weight-bold">Título da Notícia</label>
                                <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Título impactante para a notícia" maxlength="60" required>
                                <small class="text-muted">Máximo 60 caracteres.</small>
                            </div>
                            <div class="col-md-4 text-start">
                                <label for="slug" class="form-label font-weight-bold">Slug</label>
                                <input type="text" name="slug" id="slug" readonly class="form-control bg-light" placeholder="Gerado automaticamente">
                            </div>
                            <div class="col-md-12 text-start">
                                <label for="subtitulo" class="form-label font-weight-bold">Subtítulo (Resumo)</label>
                                <textarea name="subtitulo" id="subtitulo" class="form-control" rows="2" placeholder="Um breve resumo que aparecerá no slider e listagens" maxlength="250"></textarea>
                            </div>
                            
                            <div class="col-md-6 text-start d-flex align-items-center">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" id="destaque" name="destaque">
                                    <label class="form-check-label fw-bold ms-2" for="destaque">Definir como Destaque?</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6 text-end">
                                <button type="button" class="btn btn-outline-primary" id="modalImage">
                                    <i class="bi bi-image me-1"></i> Selecionar Imagem de Capa
                                </button>
                            </div>

                            <div class="col-12" id="editorContainer" style="display: none;">
                                <div class="d-flex justify-content-center border rounded p-2 bg-light shadow-sm">
                                    <img src="" alt="Preview" id="previewImagem" style="max-height: 200px; width: auto;" class="img-fluid rounded">
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label fw-bold">Conteúdo da Notícia</label>
                                <textarea class="tinymce_editor" name="tinymce_editor" id="tinymce_editor"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer border-top-0 pt-4 px-0">
                            <button type="button" class="btn btn-warning text-white me-auto px-4" data-target="#exampleModalImage" data-toggle="modal">
                                <i class="bi bi-images me-1"></i> Galeria
                            </button>
                            <button type="button" class="btn btn-light me-2 px-4" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm">Salvar Notícia</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Galeria/Imagens -->
    <div class="modal fade" id="exampleModalImage" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
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
                                         title="Clique para selecionar">
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

    <!-- Modal Seleção de Imagem (usado pelo botão Capa) -->
    <div class="modal fade" id="imagemModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-image me-2"></i>Selecione a Imagem de Capa</h5>
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

    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title m-0 p-0 text-uppercase">Gerenciar Notícias</h5>
                        <button type="button" class="btn btn-primary btnModalNoticia px-4 shadow-sm" data-toggle="modal"
                                data-target="#modalNoticia" data-rota="{{route('noticia.store')}}">
                            <i class="bi bi-plus-circle me-1"></i> Nova Notícia
                        </button>
                    </div>

                    <table class="table datatable table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" width="50">#</th>
                                <th scope="col">Título / Resumo</th>
                                <th scope="col" width="100">Status</th>
                                <th scope="col" width="150">Criado em</th>
                                <th scope="col" width="120">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($noticias as $noticia)
                                <tr>
                                    <th scope="row">{{$noticia->id}}</th>
                                    <td>
                                        <div class="fw-bold text-dark">{{$noticia->titulo}}</div>
                                        <div class="text-muted small text-truncate" style="max-width: 400px;" title="{{ $noticia->subtitulo }}">
                                            {{$noticia->subtitulo ?: 'Sem resumo'}}
                                        </div>
                                        <small class="text-info">{{$noticia->slug}}</small>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch d-flex justify-content-center">
                                            <input class="form-check-input statusSwitch" type="checkbox"
                                                   data-toggle="tooltip" data-placement="top"
                                                   title="{{$noticia->status == 0 ? "Bloqueado" : "Liberado"}}"
                                                   data-id="{{$noticia->id}}"
                                                   data-rota="{{route('atualizar-status')}}"
                                                   {{$noticia->status == 0 ? "" : "checked"}}>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted d-block">{{ \Carbon\Carbon::parse($noticia->created_at)->format('d/m/Y H:i') }}</small>
                                        <small class="text-secondary" style="font-size: 0.75rem;">Mod: {{ $noticia->updated_at_formatted }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group shadow-sm">
                                            <button class="btn btn-sm btn-outline-info btn-editar" 
                                                data-rota="{{route('noticia.edit',$noticia->id)}}"
                                                data-rota-update="{{route('noticia.update',$noticia->id)}}"
                                                data-toggle="modal" data-target="#modalNoticia"
                                                title="Editar Notícia">
                                                <i class="bi bi-pencil"></i>
                                            </button>
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
    <script src="{{URL::asset('admin/assets/js/file-pond-custom.js')}}"></script>
    <script src="{{URL::asset('admin/assets/js/custom.js')}}"></script>
@endpush

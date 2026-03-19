@extends('admin.layouts.layout')

@section('menu')

    @include('admin.menu')

@endsection

@section('content')

    <div class="pagetitle">

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item">Social Media</li>
                <li class="breadcrumb-item active">Criar Social Media</li>
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

    <!-- Modal Social Media -->
    <div class="modal fade" id="modalSocialMedia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form method="POST" action="{{route('socialmedia.store')}}" name="socialmediaForm" id="socialmediaForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-content shadow-lg border-0">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <i class="bi bi-share-fill me-2"></i>Gerenciar Rede Social
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6 text-start">
                                <label for="titulo" class="form-label font-weight-bold">Nome da Rede Social</label>
                                <input type="text" name="titulo" id="titulo"
                                    class="form-control"
                                    placeholder="Ex: Instagram Sinpol" maxlength="150"
                                    required>
                                <small class="text-muted">Nome que aparecerá no site.</small>
                            </div>
                            <div class="col-md-6 text-start">
                                <label for="link" class="form-label font-weight-bold">Link (URL completa)</label>
                                <input type="text" name="link" id="link"
                                    class="form-control"
                                    placeholder="https://..." maxlength="255"
                                    required>
                                <small class="text-muted">Link de destino ao clicar.</small>
                            </div>
                            <div class="col-md-12 text-start">
                                <label for="slug" class="form-label font-weight-bold">Slug (Identificador)</label>
                                <input type="text" name="slug" id="slug" readonly
                                    class="form-control bg-light"
                                    placeholder="Gerado automaticamente">
                            </div>
                            <div class="col-md-12 text-start mt-3">
                                <label for="imagem" class="form-label font-weight-bold">Ícone / Imagem</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-image"></i></span>
                                    <input type="file" name="imagem" id="imagem"
                                        class="form-control" accept="image/*">
                                </div>
                                <small class="text-secondary"><i class="bi bi-info-circle me-1"></i> Recomendado: Imagem quadrada (1:1) com fundo transparente ou ícone.</small>
                            </div>
                        </div>

                        <div class="modal-footer border-top-0 pt-4 px-0">
                            <button type="button" class="btn btn-light me-2 px-4" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm">Salvar Rede Social</button>
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
                        <h5 class="card-title m-0 p-0">Gerenciar Redes Sociais</h5>
                        <button type="button" class="btn btn-primary btnModalSocialMedia px-4 shadow-sm" data-toggle="modal"
                                data-target="#modalSocialMedia" data-rota="{{route('socialmedia.store')}}">
                            <i class="bi bi-plus-circle me-1"></i> Nova Rede Social
                        </button>
                    </div>

                    <table class="table datatable table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" width="50">#</th>
                                <th scope="col">Thumbnail</th>
                                <th scope="col">Rede Social</th>
                                <th scope="col">Link de Acesso</th>
                                <th scope="col" width="80">Status</th>
                                <th scope="col" width="120">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($socialMedias as $socialMedia)
                                <tr>
                                    <th scope="row">{{$socialMedia->id}}</th>
                                    <td>
                                        <div class="border rounded overflow-hidden shadow-sm" style="width: 50px; height: 50px;">
                                            @if($socialMedia->imagem)
                                                <img src="{{ asset('images/social_media/'.$socialMedia->imagem) }}" 
                                                     alt="" style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                                    <i class="bi bi-share text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{$socialMedia->titulo}}</div>
                                        <small class="text-muted">{{$socialMedia->slug}}</small>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 250px;" title="{{$socialMedia->link}}">
                                            <a href="{{$socialMedia->link}}" target="_blank" class="text-decoration-none text-info">
                                                <i class="bi bi-link-45deg"></i> Ver Link
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch p-0 m-0 d-flex justify-content-center">
                                            <input class="form-check-input statusSwitch" type="checkbox"
                                                   data-toggle="tooltip" data-placement="top"
                                                   title="{{$socialMedia->status == 0 ? 'Bloqueado no site' : 'Visível no site'}}"
                                                   data-id="{{$socialMedia->id}}"
                                                   data-rota="{{route('atualizar-status-socialmedia')}}"
                                                   {{$socialMedia->status == 0 ? "" : "checked"}}>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group shadow-sm">
                                            <button class="btn btn-sm btn-outline-info btn-editar-socialmedia" 
                                                data-rota="{{route('socialmedia.edit',$socialMedia->id)}}"
                                                data-rota-update="{{route('socialmedia.update',$socialMedia->id)}}"
                                                data-toggle="modal" data-target="#modalSocialMedia"
                                                title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger btn-excluir"
                                                data-rota="{{route('socialmedia.destroy',$socialMedia->id)}}"
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
            <script src="{{URL::asset('admin/assets/js/custom.js')}}"></script>
        @endpush

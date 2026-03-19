@extends('admin.layouts.layout')

@section('menu')

    @include('admin.menu')

@endsection

@section('content')

    <div class="pagetitle">

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item">Noticas</li>
                <li class="breadcrumb-item active">Galeria de Imagens </li>
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

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title m-0 p-0 text-uppercase">Gerenciar Galeria</h5>
                <button type="button" class="btn btn-primary px-4 shadow-sm" data-toggle="modal" data-target="#exampleModal">
                    <i class="bi bi-upload me-1"></i> Fazer Upload
                </button>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    @foreach($images as $image)
                        @php
                            $extension = pathinfo($image->path, PATHINFO_EXTENSION);
                            $fileTypes = [
                                'pdf' => 'pdf',
                                'doc' => 'doc',
                                'docx' => 'docx',
                                'xls' => 'xls',
                                'xlsx' => 'xlsx',
                            ];
                            $isDoc = isset($fileTypes[$extension]);
                        @endphp

                        <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                            <div class="card h-100 border-0 shadow-sm gallery-card">
                                <div class="position-relative overflow-hidden rounded-top" style="height: 150px;">
                                    @if($isDoc)
                                        <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                            <img src="{{URL::asset('images/'.$fileTypes[$extension].'.png')}}" class="img-fluid p-4" style="max-height: 100%;">
                                        </div>
                                    @else
                                        <img src="{{URL::asset('storage/posts/files/'.$image->path)}}" class="card-img-top h-100 w-100" style="object-fit: cover;">
                                    @endif
                                </div>
                                <div class="card-footer bg-white border-0 text-center p-2">
                                    <button class="btn btn-sm btn-outline-danger w-100 btnRemove" 
                                            title="Remover Arquivo"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            data-id="{{$image->id}}"
                                            data-rota="{{route('remove-galery-image')}}">
                                        <i class="bi bi-trash me-1"></i> Excluir
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $images->links() }}
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Upload -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="{{route('uploadImagem')}}" name="uploadForm" id="uploadForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-content shadow-lg border-0">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-cloud-upload me-2"></i>Upload de Arquivos</h5>
                        <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 text-center">
                        <div class="mb-3 p-3 border rounded bg-light">
                            <input type="file" name="image" id="image" class="filepond"/>
                        </div>
                        <p class="text-muted small mb-0">Selecione imagens ou documentos para adicionar à galeria.</p>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-light px-4" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm text-uppercase fw-bold">Salvar Arquivo</button>
                    </div>
                </div>
            </form>
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


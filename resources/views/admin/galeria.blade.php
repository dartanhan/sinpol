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
        <div class="row">
            <div>
                <div class="card">
                    <div class="card-body mt-3">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('danger'))
                            <div class="alert alert-danger">
                                {{ session('danger') }}
                            </div>
                        @endif
                        <div class="container text-center ">
                            <!-- Botão para abrir o modal -->
                            <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#exampleModal">
                                Fazer Upload
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form method="POST" action="{{route('uploadImagem')}}" name="uploadForm" id="uploadForm" enctype="multipart/form-data">
                                    @csrf
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title" id="exampleModalLabel">Upload</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-row">
                                                    <input type="file" name="image" id="image" class="filepond"/>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                <button type="submit" class="btn btn-primary">Salvar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="card">
        <div class="row">
            <section class="product-list">
                @foreach($images as $image)
                    @php
                        /** @var TYPE_NAME $image */
                        $extension = pathinfo($image->path, PATHINFO_EXTENSION);

                        // Mapeamento das extensões para tipos de arquivo
                        $fileTypes = [
                            'pdf' => 'pdf',
                            'doc' => 'doc',
                            'docx' => 'docx',
                            'xls' => 'xls',
                            'xlsx' => 'xlsx',
                            // Adicione outras extensões conforme necessário
                        ];
                    @endphp

                    @if(isset($fileTypes[$extension]))
                        <div class="product-card">
                            <img src="{{URL::asset('images/'.$fileTypes[$extension].'.png')}}" class="resize-image">
                            <button class="btn btn-xs btn-danger btnRemove" title="Remover Image"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    data-id="{{$image->id}}"
                                    data-rota="{{route('remove-galery-image')}}">Deletar</button>
                        </div>
                    @else
                        <div class="product-card">
                            <img src="{{URL::asset('storage/posts/files/'.$image->path)}}" class="resize-image">
                            <button class="btn btn-xs btn-danger btnRemove" title="Remover Arquivo"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    data-id="{{$image->id}}"
                                    data-rota="{{route('remove-galery-image')}}">Deletar</button>
                        </div>
                    @endif
                @endforeach
            </section>
        </div>
        <div class="row justify-content-center">
            {{ $images->links() }}
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


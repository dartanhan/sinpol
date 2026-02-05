@extends('admin.layouts.layout')

@section('menu')

    @include('admin.menu')

@endsection

@section('content')

    <div class="pagetitle">

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item">Diretoria</li>
                <li class="breadcrumb-item active">Criar Diretoria</li>
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
                            <button type="button" class="btn btn-primary mt-3 btnModalDiretoria" data-toggle="modal"
                                data-target="#modalDiretoria" data-rota="{{route('diretoria.store')}}">
                                Salvar nova Diretoria
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="modalDiretoria" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-lg modal-md" role="document">
                                    <form method="POST" action="{{route('diretoria.store')}}" name="diretoriaForm"
                                        id="diretoriaForm" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title" id="exampleModalLabel">Salvar nova Diretoria</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-row">
                                                    <div class="form-group d-flex align-items-start" style="gap: 20px;">
                                                        <div class="w-50" style="text-align: left;">
                                                            <label for="titulo"><strong>Máximo de 150
                                                                    Caracteres</strong></label>
                                                            <input type="text" name="titulo" id="titulo"
                                                                class="form-control" placeholder="Título da Diretoria"
                                                                maxlength="150" data-toggle="tooltip" data-placement="top"
                                                                title="Título da Diretoria">
                                                        </div>
                                                        <div class="w-50" style="text-align: left;">
                                                            <label for="slug"><strong>Slug</strong></label>
                                                            <input type="text" name="slug" id="slug" readonly
                                                                class="form-control" placeholder="Slug" maxlength="150"
                                                                data-toggle="tooltip" data-placement="top" title="Slug">
                                                        </div>
                                                    </div>


                                                    <div class="form-group  mt-3" style="text-align: left;">
                                                        <div class="card-header bg-primary text-white text-left">
                                                            <label for="noticia"><b>Crie o conteúdo da Diretoria ao seu
                                                                    estilo!</b></label>
                                                        </div>
                                                        <div class="card-body mt-3">
                                                            <textarea class="tinymce_editor" name="tinymce_editor"
                                                                id="tinymce_editor"></textarea>
                                                        </div>
                                                    </div>


                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Fechar</button>
                                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                                    </div>
                                                </div>
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
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <section>
                    <table class="table datatable table-responsive table-hover table-striped text-center ">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Titulo</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Status</th>
                                <th scope="col">Criado em:</th>
                                <th scope="col">Atualizado em:</th>
                                <th scope="col" colspan="2" width="200px" style="width: 200px">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($diretorias as $diretoria)
                                <tr>
                                    <th class="align-middle">{{$diretoria->id}}</th>
                                    <td class="align-middle">{{$diretoria->titulo}}</td>
                                    <td class="align-middle">{{$diretoria->slug}}</td>
                                    <td class="align-middle" style="text-align: center;">
                                        <div class="form-check form-switch mt-2"
                                            style="display: inline-block; vertical-align: middle;cursor: pointer">
                                            <input class="form-check-input statusSwitch"
                                                style="text-align: center;cursor: pointer" type="checkbox" data-toggle="tooltip"
                                                data-placement="top"
                                                title="{{$diretoria->status == 0 ? "Bloqueado, sem visualização no site." : "Liberado, para visualização no site."}}"
                                                data-id="{{$diretoria->id}}" data-rota="{{route('atualizar-status-diretoria')}}"
                                                {{$diretoria->status == 0 ? "" : "checked"}}>
                                        </div>
                                    </td>
                                    <td class="align-middle">{{$diretoria->created_at}}</td>
                                    <td class="align-middle">{{$diretoria->updated_at}}</td>
                                    <td class="align-middle align-center">
                                        <div class="d-flex">
                                            <i class="bi bi-trash custom-icon-size text-danger btn-excluir"
                                                style="cursor: pointer" data-toggle="tooltip" data-placement="top"
                                                title="Excluir" data-rota="{{route('diretoria.destroy', $diretoria->id)}}">
                                            </i>
                                            <span data-toggle="tooltip" data-placement="top" title="Editar">
                                                <i class="bi bi-pencil-square custom-icon-size text-info btn-editar-diretoria"
                                                    style="cursor: pointer"
                                                    data-rota="{{route('diretoria.edit', $diretoria->id)}}"
                                                    data-rota-update="{{route('diretoria.update', $diretoria->id)}}"
                                                    data-toggle="modal" data-target="#modalDiretoria">
                                                </i>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>
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
    <script src="{{URL::asset('admin/assets/js/custom_diretoria.js')}}"></script>
@endpush
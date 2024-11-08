@extends('admin.layouts.layout')

@section('menu')

    @include('admin.menu')

@endsection

@section('content')

    <div class="pagetitle">

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item">Convênios</li>
                <li class="breadcrumb-item active">Criar Convênio</li>
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
                            <button type="button" class="btn btn-primary mt-3 btnModalConvenio" data-toggle="modal"
                                    data-target="#modalConvenio" data-rota="{{route('convenio.store')}}">
                                   Salvar novo Convênio
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="modalConvenio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-lg modal-md" role="document">
                                    <form method="POST" action="{{route('convenio.store')}}" name="convenioForm" id="convenioForm" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title" id="exampleModalLabel">Salvar novo Convênio</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-row">
                                                        <div class="form-group d-flex align-items-start" style="gap: 20px;">
                                                            <div class="w-50" style="text-align: left;">
                                                                <label for="titulo"><strong>Máximo de 150 Caracteres</strong></label>
                                                                <input type="text" name="titulo" id="titulo"
                                                                       class="form-control"
                                                                       placeholder="Título do Convênio" maxlength="150"
                                                                       data-toggle="tooltip"
                                                                       data-placement="top"
                                                                       title="Título do Convênio">
                                                            </div>
                                                            <div class="w-50" style="text-align: left;">
                                                                <label for="slug"><strong>Slug</strong></label>
                                                                <input type="text" name="slug" id="slug" readonly
                                                                       class="form-control"
                                                                       placeholder="Slug" maxlength="150"
                                                                       data-toggle="tooltip"
                                                                       data-placement="top"
                                                                       title="Slug">
                                                            </div>
                                                        </div>


                                                        <div class="form-group  mt-3"  style="text-align: left;">
                                                            <div class="card-header bg-primary text-white text-left">
                                                            <label for="noticia"><b>Crie o Convênio ao seu estilo!</b></label>
                                                            </div>
                                                            <div class="card-body mt-3">
                                                                <textarea class="tinymce_editor" name="tinymce_editor" id="tinymce_editor"></textarea>
                                                            </div>
                                                        </div>


                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
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
                            @foreach($convenios as $convenio)
                                <tr>
                                    <th class="align-middle">{{$convenio->id}}</th>
                                    <td class="align-middle">{{$convenio->titulo}}</td>
                                    <td class="align-middle">{{$convenio->slug}}</td>
                                    <td class="align-middle" style="text-align: center;">
                                        <div class="form-check form-switch mt-2"  style="display: inline-block; vertical-align: middle;cursor: pointer">
                                            <input class="form-check-input statusSwitch" style="text-align: center;cursor: pointer"
                                                   type="checkbox"
                                                   data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="{{$convenio->status == 0 ? "Bloqueado, sem visualização no site." : "Liberado, para visualização no site."}}"
                                                   data-id="{{$convenio->id}}"
                                                   data-rota="{{route('atualizar-status-convenio')}}"
                                                   {{$convenio->status == 0 ? "" : "checked"}}>
                                        </div>
                                    </td>
                                    <td class="align-middle">{{$convenio->created_at}}</td>
                                    <td class="align-middle">{{$convenio->updated_at}}</td>
                                    <td class="align-middle align-center">
                                        <div class="d-flex">
                                            <i class="bi bi-trash custom-icon-size text-danger btn-excluir" style="cursor: pointer"
                                               data-toggle="tooltip"
                                               data-placement="top"
                                               title="Excluir"
                                               data-rota="{{route('convenio.destroy',$convenio->id)}}">
                                            </i>
                                            <span data-toggle="tooltip" data-placement="top" title="Editar">
                                               <i class="bi bi-pencil-square custom-icon-size text-info btn-editar-convenio" style="cursor: pointer"
                                                   data-rota="{{route('convenio.edit',$convenio->id,'/edit')}}"
                                                   data-rota-update="{{route('convenio.update',$convenio->id)}}"
                                                   data-toggle="modal"
                                                   data-target="#modalConvenio">
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
        @endpush

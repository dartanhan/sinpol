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
                            <button type="button" class="btn btn-primary mt-3 btnModalSocialMedia" data-toggle="modal"
                                    data-target="#modalSocialMedia" data-rota="{{route('socialmedia.store')}}">
                                   Salvar novo Social Media
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="modalSocialMedia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-lg modal-md" role="document">
                                    <form method="POST" action="{{route('socialmedia.store')}}" name="socialmediaForm" id="socialmediaForm" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title" id="exampleModalLabel">Salvar novo Social Media</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-row">
                                                        <div class="form-group d-flex align-items-start" style="gap: 20px;">
                                                            <div class="w-50" style="text-align: left;">
                                                                <label for="titulo"><strong>Máximo de 150 Caracteres</strong></label>
                                                                <input type="text" name="titulo" id="titulo"
                                                                       class="form-control"
                                                                       placeholder="Titulo Social Media" maxlength="150"
                                                                       data-toggle="tooltip"
                                                                       data-placement="top"
                                                                       title="Titulo da Social Media">
                                                            </div>
                                                            <div class="w-50" style="text-align: left;">
                                                                <label for="titulo"><strong>Máximo de 255 Caracteres</strong></label>
                                                                <input type="text" name="link" id="link"
                                                                       class="form-control"
                                                                       placeholder="Link Social Media" maxlength="255"
                                                                       data-toggle="tooltip"
                                                                       data-placement="top"
                                                                       title="Link da Social Media">
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
                                <th scope="col">Link</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Status</th>
                                <th scope="col">Criado em:</th>
                                <th scope="col">Atualizado em:</th>
                                <th scope="col" colspan="2" width="200px" style="width: 200px">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($socialMedias as $socialMedia)
                                <tr>
                                    <th class="align-middle">{{$socialMedia->id}}</th>
                                    <th class="align-middle">{{$socialMedia->titulo}}</th>
                                    <td class="align-middle">{{$socialMedia->link}}</td>
                                    <td class="align-middle">{{$socialMedia->slug}}</td>
                                    <td class="align-middle" style="text-align: center;">
                                        <div class="form-check form-switch mt-2"  style="display: inline-block; vertical-align: middle;cursor: pointer">
                                            <input class="form-check-input statusSwitch" style="text-align: center;cursor: pointer"
                                                   type="checkbox"
                                                   data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="{{$socialMedia->status == 0 ? "Bloqueado, sem visualização no site." : "Liberado, para visualização no site."}}"
                                                   data-id="{{$socialMedia->id}}"
                                                   data-rota="{{route('atualizar-status-socialmedia')}}"
                                                   {{$socialMedia->status == 0 ? "" : "checked"}}>
                                        </div>
                                    </td>
                                    <td class="align-middle">{{$socialMedia->created_at}}</td>
                                    <td class="align-middle">{{$socialMedia->updated_at}}</td>
                                    <td class="align-middle align-center">
                                        <div class="d-flex">
                                            <i class="bi bi-trash custom-icon-size text-danger btn-excluir" style="cursor: pointer"
                                               data-toggle="tooltip"
                                               data-placement="top"
                                               title="Excluir"
                                               data-rota="{{route('socialmedia.destroy',$socialMedia->id)}}">
                                            </i>
                                            <span data-toggle="tooltip" data-placement="top" title="Editar">
                                               <i class="bi bi-pencil-square custom-icon-size text-info btn-editar-socialmedia" style="cursor: pointer"
                                                   data-rota="{{route('socialmedia.edit',$socialMedia->id,'/edit')}}"
                                                   data-rota-update="{{route('socialmedia.update',$socialMedia->id)}}"
                                                   data-toggle="modal"
                                                   data-target="#modalSocialMedia">
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
            <script src="{{URL::asset('admin/assets/js/custom.js')}}"></script>
        @endpush

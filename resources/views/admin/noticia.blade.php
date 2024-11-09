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
                            <button type="button" class="btn btn-primary mt-3 btnModal" data-toggle="modal"
                                    data-target="#modalNoticia" data-rota="{{route('noticia.store')}}">
                               Criar Notícia
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="modalNoticia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-lg modal-md" role="document">
                                    <form method="POST" action="{{route('noticia.store')}}" name="noticiaForm" id="noticiaForm" enctype="multipart/form-data">
                                        <input type="hidden" name="idImagemDestaque" id="idImagemDestaque"/>
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title" id="exampleModalLabel">Criar Notícia</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-row">
                                                        <div class="form-group d-flex align-items-start" style="gap: 20px;">
                                                            <div class="w-50" style="text-align: left;">
                                                                <label for="titulo"><strong>Máximo de 60 Caracteres</strong></label>
                                                                <input type="text" name="titulo" id="titulo"
                                                                       class="form-control"
                                                                       placeholder="Título da Notícia" maxlength="60"
                                                                       data-toggle="tooltip"
                                                                       data-placement="top"
                                                                       title="Título da Notícia">
                                                            </div>
                                                            <div class="w-50" style="text-align: left;">
                                                                <label for="slug"><strong>Slug</strong></label>
                                                                <input type="text" name="slug" id="slug" readonly
                                                                       class="form-control"
                                                                       placeholder="Slug da Notícia" maxlength="255"
                                                                       data-toggle="tooltip"
                                                                       data-placement="top"
                                                                       title="Slug da Notícia">
                                                            </div>
                                                        </div>


                                                        <div class="form-group  mt-3"  style="text-align: left;">
                                                        <label><strong>Máximo de 250 Caracteres</strong></label>
                                                        <textarea type="text" name="subtitulo" id="subtitulo"
                                                                  class="form-control"
                                                                  placeholder="SubTítulo da Notícia" maxlength="250"
                                                                  data-toggle="tooltip"
                                                                  data-placement="top"
                                                                  title="Subtítulo no slider principal"></textarea>
                                                    </div>
                                                    <div class="form-check form-switch mt-3 text-start">
                                                        <label class="form-check-label" style="cursor: pointer">
                                                            <input class="form-check-input" type="checkbox" id="destaque" name="destaque" style="cursor: pointer">
                                                            <span class="badge bg-primary ms-2"
                                                                  data-toggle="tooltip"
                                                                  data-placement="top"
                                                                  title="Esta função coloca a notícia como destaque no slider principal">Colocar como Destaque?</span>
                                                        </label>
                                                    </div>
                                                    <div class="form-group mt-3 text-start" id="editorContainer" style="display: none;">
                                                        <button type="button" class="btn btn-primary" id="modalImage" data-toggle="tooltip"
                                                                data-placement="top" title="Informe a imagem que deverá ser exibida no slider e na notícia">
                                                            Selecionar Imagem
                                                        </button>
                                                        <div class="card">
                                                            <div class="form-group mt-3 col-md-6 offset-md-3 text-justify">
                                                                <img src="" alt="Preview da Imagem" id="previewImagem" class="img-thumbnail img-thumbnail-none">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card mt-3">
                                                        <div class="card-header bg-primary text-white text-left">
                                                            <label for="noticia"><b>Crie a Nóticia ao seu estilo!</b></label>
                                                        </div>
                                                        <div class="card-body mt-3">
                                                            <textarea class="tinymce_editor" name="tinymce_editor" id="tinymce_editor"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <span data-toggle="tooltip"
                                                            data-placement="top"
                                                            title="Utilize as imagens da galeria de imagens , faça upload no menu Galeria de Imagens">
                                                        <button type="button" class="btn btn-warning text-white"
                                                                data-target="#exampleModalImage"
                                                                data-toggle="modal"
                                                                style="margin-right: auto;">Abrir Galeria de Imagens </button>
                                                            </span>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                    </form>
                                </div>
                            </div>
                            <div class="modal fade" id="exampleModalImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-md" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning  text-white">
                                            <h5 class="modal-title" id="exampleModalLabel">Galeria</h5>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-row">
                                                <div class="card" style="height: 420px;overflow-y: auto;">
                                                    <section class="product-list-gallery">
                                                        @foreach($images as $image)
                                                            <div class="product-card-gallery">
                                                                <img src="{{URL::asset('storage/posts/files/'.$image->path)}}" class="resize-image-gallery" title="Inserir Image">
                                                            </div>
                                                        @endforeach
                                                    </section>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="modalConteudoNoticia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="exampleModalLabel">Conteúdo Completo da Notícia</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body modal-conteudo" id="modal-conteudo">
                                            <!-- O conteúdo será carregado aqui via JavaScript -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="imagemModal" tabindex="-1" aria-labelledby="imagemModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="imagemModalLabel">Selecione uma Imagem</h5>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-row">
                                                <div class="card" style="height: 320px;overflow-y: auto;">
                                                    <section class="product-list-gallery">
                                                         @foreach($images as $image)
                                                            <div class="product-card-gallery">
                                                                <img src="{{URL::asset('storage/posts/files/'.$image->path)}}" data-toggle="tooltip"
                                                                     data-placement="top"
                                                                     data-id="{{$image->id}}" class="imagem-selecao" title="Click para Inserir esta Imagem">
                                                            </div>
                                                        @endforeach
                                                    </section>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
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
                                <th scope="col">SubTitulo</th>
                                <th scope="col">Inativo/Ativo</th>
                                <th scope="col">Destaque</th>
                                <th scope="col">Criado em:</th>
                                <th scope="col">Atualizado em:</th>
                                <th scope="col" colspan="2" width="200px" style="width: 200px">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($noticias as $noticia)
                                @foreach($noticia['imagens'] as $key => $imagem)
                                        @php
                                            /** @var TYPE_NAME $imagem */
                                            $imgPath = $imagem->path;
                                        @endphp
                                @endforeach

                                <tr>
                                    <th class="align-middle">{{$noticia->id}}</th>
                                    <td class="align-middle">{{$noticia->titulo}}</td>
                                    <td class="align-middle">{{$noticia->slug}}</td>
                                    <td class="align-middle" style="width: 250px">
                                        {{$noticia->subtitulo == "" ? "-" : $noticia->subtitulo }}
                                    </td>
                                    <td class="align-middle" style="text-align: center;">
                                        <div class="form-check form-switch mt-2"  style="display: inline-block; vertical-align: middle;cursor: pointer">
                                            <input class="form-check-input statusSwitch" style="text-align: center;cursor: pointer"
                                                   type="checkbox"
                                                   data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="{{$noticia->status == 0 ? "Bloqueado, sem visualização no site." : "Liberado, para visualização no site."}}"
                                                   data-id="{{$noticia->id}}"
                                                   data-rota="{{route('atualizar-status')}}"
                                                   {{$noticia->status == 0 ? "" : "checked"}}>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="form-check form-switch mt-2" style="display: inline-block; vertical-align: middle;cursor: pointer">
                                            <input class="form-check-input destaqueSwitch" style="text-align: center;cursor: pointer"
                                                   type="checkbox"
                                                   data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="{{$noticia->destaque == 0 ? "Notíca não é Destaque." : "Notíca está ativa como Destaque"}}"
                                                   data-id="{{$noticia->id}}"
                                                   data-rota="{{route('atualizar-destaque')}}"
                                                {{$noticia->destaque == 0 ? "" : "checked"}}>
                                        </div>
                                    </td>
                                    <td class="align-middle">{{$noticia->created_at}}</td>
                                    <td class="align-middle">{{$noticia->updated_at_formatted}}</td>
                                    <td class="align-middle align-center">
                                        <div class="d-flex">
                                            <i class="bi bi-trash custom-icon-size text-danger btn-excluir" style="cursor: pointer"
                                               data-toggle="tooltip"
                                               data-placement="top"
                                               title="Excluir Noticia"
                                               data-rota="{{route('noticia.destroy',$noticia->id)}}">
                                            </i>
                                            <i class="bi bi-pencil-square custom-icon-size text-info btn-editar" style="cursor: pointer"
                                               data-toggle="tooltip"
                                               data-placement="top"
                                               title="Editar Noticia"
                                               data-rota="{{route('noticia.edit',$noticia->id,'/edit')}}"
                                               data-rota-update="{{route('noticia.update',$noticia->id)}}">
                                            </i>
{{--                                            <a href="#" class="ler-mais"--}}
{{--                                                data-toggle="modal"--}}
{{--                                                data-target="#modalConteudoNoticia"--}}
{{--                                                data-conteudo="{{ $noticia->conteudo }}"--}}
{{--                                                data-img-destaque = "{{isset($imgPath) == true ? "../public/storage/posts/files/".$imgPath : ''}}">--}}

{{--                                                <i class="bi bi-eye-fill custom-icon-size text-success"--}}
{{--                                                   data-toggle="tooltip"--}}
{{--                                                   data-placement="top"--}}
{{--                                                   title="Visualizar a Notícia">--}}
{{--                                                </i>--}}
                                            </a>
{{--                                            <i class="bi bi-eye-fill custom-icon-size text-success btn-view" style="cursor: pointer"--}}
{{--                                                   data-toggle="tooltip"--}}
{{--                                                   data-placement="top"--}}
{{--                                                   title="Visualizar a Notícia"--}}
{{--                                                   data-conteudo="{{ $noticia->conteudo }}"--}}
{{--                                                   data-img-destaque = "{{isset($imgPath) == true ? "../public/storage/posts/files/".$imgPath : ''}}">--}}
{{--                                                    </i>--}}
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

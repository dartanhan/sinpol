@extends('admin.layouts.layout')

@section('menu')

    @include('admin.menu')

@endsection

@section('content')

    <div class="pagetitle">

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Benefícios</li>
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

    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card shadow-sm text-center">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title m-0 p-0 text-uppercase">Gerenciar Benefícios</h5>
                        <a href="{{route('beneficio.create')}}" class="btn btn-primary px-4 shadow-sm">
                            <i class="bi bi-plus-circle me-1"></i> Adicionar Benefício
                        </a>
                    </div>

                    <table class="table datatable table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" width="50">#</th>
                                <th scope="col" class="text-start">Título / Link Amigável</th>
                                <th scope="col" width="100">Status</th>
                                <th scope="col" width="150">Criado em</th>
                                <th scope="col" width="120">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($beneficios as $beneficio)
                                <tr>
                                    <th scope="row">{{$beneficio->id}}</th>
                                    <td class="text-start">
                                        <div class="fw-bold text-dark">{{$beneficio->titulo}}</div>
                                        <small class="text-info">{{$beneficio->slug}}</small>
                                    </td>
                                    <td class="text-center">
                                        @if($beneficio->status == 1)
                                            <span class="badge bg-success text-uppercase">Publicado</span>
                                        @else
                                            <span class="badge bg-secondary text-uppercase">Rascunho</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($beneficio->getRawOriginal('created_at'))->format('d/m/Y H:i') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group shadow-sm">
                                            <a href="{{route('beneficio.edit',$beneficio->id)}}" class="btn btn-sm btn-outline-info" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger btn-excluir"
                                                data-rota="{{route('beneficio.destroy',$beneficio->id)}}"
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
            <script src="{{URL::asset('admin/assets/js/file-pond-custom.js')}}"></script>
            <script src="{{URL::asset('admin/assets/js/custom.js')}}"></script>
        @endpush

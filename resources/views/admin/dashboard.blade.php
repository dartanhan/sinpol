@extends('admin.layouts.layout')

@section('menu')

    @include('admin.menu')

@endsection

@section('content')

    <div class="pagetitle mb-4">
        <h1 class="text-dark">Resumo do Painel</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <!-- Row for Main Stats -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Members Card -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card members-card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title text-secondary small text-uppercase fw-bold">Associados <span>| Total</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary-light text-primary">
                                        <i class="bi bi-people-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 class="fs-4 fw-bold">{{ $usersCount ?? '0' }}</h6>
                                        <span class="text-success small pt-1 fw-bold">Ativos</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- News Card -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card news-card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title text-secondary small text-uppercase fw-bold">Notícias <span>| Publicadas</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success-light text-success">
                                        <i class="bi bi-newspaper"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 class="fs-4 fw-bold">{{ $noticiasCount ?? '0' }}</h6>
                                        <span class="text-muted small pt-2 ps-1">Postagens</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Agreements Card -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card agreements-card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title text-secondary small text-uppercase fw-bold">Convênios <span>| Rede Viva</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-warning-light text-warning">
                                        <i class="bi bi-shop"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 class="fs-4 fw-bold">{{ $conveniosCount ?? '0' }}</h6>
                                        <span class="text-muted small pt-2 ps-1">Parceiros</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Videos Card -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card videos-card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title text-secondary small text-uppercase fw-bold">Vídeos <span>| Youtube</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-danger-light text-danger">
                                        <i class="bi bi-play-circle"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 class="fs-4 fw-bold">{{ $videosCount ?? '0' }}</h6>
                                        <span class="text-muted small pt-2 ps-1">Produções</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">
                    <!-- Reports -->
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title">Atividade no Site <span>/ Semanal</span></h5>
                                <div id="reportsChart"></div>
                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        new ApexCharts(document.querySelector("#reportsChart"), {
                                            series: [{
                                                name: 'Visitas',
                                                data: [31, 40, 28, 51, 42, 82, 56],
                                            }, {
                                                name: 'Acessos Associados',
                                                data: [11, 32, 45, 32, 34, 52, 41]
                                            }],
                                            chart: {
                                                height: 350,
                                                type: 'area',
                                                toolbar: { show: false },
                                            },
                                            colors: ['#4154f1', '#2eca6a'],
                                            fill: {
                                                type: "gradient",
                                                gradient: {
                                                    shadeIntensity: 1,
                                                    opacityFrom: 0.3,
                                                    opacityTo: 0.4,
                                                    stops: [0, 90, 100]
                                                }
                                            },
                                            dataLabels: { enabled: false },
                                            stroke: { curve: 'smooth', width: 2 },
                                            xaxis: {
                                                type: 'datetime',
                                                categories: ["2024-05-19T00:00:00.000Z", "2024-05-20T00:00:00.000Z", "2024-05-21T00:00:00.000Z", "2024-05-22T00:00:00.000Z", "2024-05-23T00:00:00.000Z", "2024-05-24T00:00:00.000Z", "2024-05-25T00:00:00.000Z"]
                                            },
                                        }).render();
                                    });
                                </script>
                            </div>
                        </div>
                    </div>

                    <!-- Recent News Table -->
                    <div class="col-12">
                        <div class="card shadow-sm border-0 recent-sales overflow-auto">
                            <div class="card-body">
                                <h5 class="card-title">Últimas Notícias <span>| Recentemente Adicionadas</span></h5>
                                <table class="table table-borderless datatable align-middle">
                                    <thead>
                                        <tr class="bg-light">
                                            <th scope="col">Título</th>
                                            <th scope="col">Data</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($noticias->take(5) as $n)
                                        <tr>
                                            <td class="fw-bold">{{ $n->titulo }}</td>
                                            <td>{{ \Carbon\Carbon::parse($n->created_at)->format('d/m/Y') }}</td>
                                            <td><span class="badge {{ $n->status ? 'bg-success' : 'bg-secondary' }}">{{ $n->status ? 'Público' : 'Rascunho' }}</span></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right side columns -->
            <div class="col-lg-4">
                <!-- Website Traffic -->
                <div class="card shadow-sm border-0">
                    <div class="card-body pb-0">
                        <h5 class="card-title">Distribuição de Conteúdo</h5>
                        <div id="trafficChart" style="min-height: 400px;" class="echart"></div>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                echarts.init(document.querySelector("#trafficChart")).setOption({
                                    tooltip: { trigger: 'item' },
                                    legend: { top: '5%', left: 'center' },
                                    series: [{
                                        name: 'Conteúdo',
                                        type: 'pie',
                                        radius: ['40%', '70%'],
                                        avoidLabelOverlap: false,
                                        label: { show: false, position: 'center' },
                                        emphasis: {
                                            label: { show: true, fontSize: '18', fontWeight: 'bold' }
                                        },
                                        data: [
                                            { value: {{ $noticiasCount ?? 10 }}, name: 'Notícias' },
                                            { value: {{ $conveniosCount ?? 15 }}, name: 'Convênios' },
                                            { value: {{ $videosCount ?? 5 }}, name: 'Vídeos' },
                                            { value: {{ $beneficiosCount ?? 8 }}, name: 'Benefícios' }
                                        ]
                                    }]
                                });
                            });
                        </script>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Informação do Sistema</h5>
                        <div class="activity">
                            <div class="p-3 bg-light rounded text-center">
                                <p class="m-0 text-muted">Acesso administrativo monitorado</p>
                                <hr class="my-2">
                                <p class="m-0 small">Bem-vindo, <strong>{{ auth()->user()->nome }}</strong>!</p>
                                <p class="m-0 small text-secondary mt-1">Sua sessão expira em breve.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
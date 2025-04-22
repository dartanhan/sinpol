@extends('layouts')

@section('content')
    <!-- Breaking News Start -->
    <div class="container-fluid mt-5 mb-3 pt-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <div class="section-title border-right-0 mb-0" style="width: 180px;">
                            <h4 class="m-0 text-uppercase font-weight-bold">Notícias</h4>
                        </div>
                        <div class="owl-carousel tranding-carousel position-relative d-inline-flex align-items-center bg-white border border-left-0"
                             style="width: calc(100% - 180px); padding-right: 100px;">
                            @foreach($noticiasBreakNews as $key => $noticiasBreakNew)
                                <div class="text-truncate">
                                    <a class="text-secondary text-uppercase font-weight-semi-bold"
                                       href="{{route('home.single',[ 'pagina' => 'noticia', 'slug' => $noticiasBreakNew->slug])}}">
                                        {{$noticiasBreakNew->subtitulo}}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breaking News End -->
    <!-- News With Sidebar Start -->
    <div class="container-fluid mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- News Detail Start -->
                    <div class="position-relative mb-3">
                        <div class="bg-white border border-top-0 p-4">

                            <div class="container my-5">
                                <h3 class="mb-4">Ficha de Filiação - SINPOL</h3>
                                <p class="text-danger">* Todos os campos são obrigatórios</p>

                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach($errors->all() as $erro)
                                                <li>{{ $erro }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif


                                <form action="{{ route('ficha.enviar') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- DADOS PESSOAIS -->
                                    <div class="card mb-4">
                                        <div class="card-header bg-primary text-white">Dados Pessoais</div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <label class="form-label">Nome Completo *</label>
                                                        <input type="text" name="nome" class="form-control" maxlength="200" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">CPF *</label>
                                                        <input type="text" name="cpf" id="cpf" class="form-control" maxlength="14" required>
                                                        <small id="cpfErro" class="text-danger d-none">CPF inválido</small>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Data Nascimento *</label>
                                                        <input type="date" name="data_nascimento" class="form-control"  maxlength="10" required>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Email *</label>
                                                        <input type="email" name="email" class="form-control" maxlength="200" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Nacionalidade *</label>
                                                        <input type="text" name="nacionalidade" class="form-control" maxlength="50" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Naturalidade *</label>
                                                        <input type="text" name="naturalidade" class="form-control" maxlength="50" required>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Sexo *</label>
                                                        <select name="sexo" class="form-control form-select" required>
                                                            <option value="">Selecione</option>
                                                            <option value="Feminino">Feminino</option>
                                                            <option value="Masculino">Masculino</option>
                                                            <option value="Outro">Outro</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="form-label">Estado Civil *</label>
                                                        <input type="text" name="estado_civil" class="form-control" required>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="form-label">Telefone *</label>
                                                        <input type="tel" name="telefone" id="telefone" class="form-control" maxlength="40" required>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <!-- ENDEREÇO -->
                                                    <div class="card mb-4">
                                                        <div class="card-header bg-primary text-white">Endereço</div>
                                                        <div class="card-body">
                                                            <div class="row g-3">
                                                                <div class="col-md-4">
                                                                    <label class="form-label">CEP *</label>
                                                                    <input type="text"
                                                                             name="cep"
                                                                             id="cep"
                                                                             class="form-control"
                                                                             maxlength="9"
                                                                             placeholder="Apenas números.."
                                                                             required>
                                                                    <small id="cep-erro" class="text-danger d-none">CEP não encontrado.</small>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label">Endereço *</label>
                                                                    <input type="text" name="endereco" id="endereco" class="form-control" maxlength="200"required>
                                                                </div>

                                                                <div class="row mt-3">
                                                                    <div class="col-md-3">
                                                                        <label class="form-label">Bairro *</label>
                                                                        <input type="text" name="bairro" id="bairro" class="form-control" maxlength="50" required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label class="form-label">Município *</label>
                                                                        <input type="text" name="municipio" id="municipio" class="form-control" maxlength="50" required>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label class="form-label">Estado *</label>
                                                                        <input type="text" name="estado" id="uf" class="form-control" maxlength="20" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <!-- IDENTIFICAÇÃO -->
                                                    <div class="card mb-4">
                                                        <div class="card-header bg-primary text-white">Identificação</div>
                                                        <div class="card-body">
                                                            <div class="row g-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label">Filiação *</label>
                                                                    <input type="text" name="filiacao" class="form-control" maxlength="150" required>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label">Identidade *</label>
                                                                    <input type="number" name="identidade" class="form-control" maxlength="50" required>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label">Órgão Emissor *</label>
                                                                    <input type="text" name="orgao_emissor" class="form-control" maxlength="10" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <!-- DADOS FUNCIONAIS -->
                                                    <div class="card mb-4">
                                                        <div class="card-header bg-primary text-white">Dados Funcionais</div>
                                                        <div class="card-body">
                                                            <div class="row g-3">
                                                                <div class="row">
                                                                    <div class="col-md-5">
                                                                        <label class="form-label">Cargo *</label>
                                                                        <input type="text" name="cargo" class="form-control" maxlength="50" required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label class="form-label">Data de Admissão *</label>
                                                                        <input type="date" name="data_admissao" class="form-control" maxlength="10" required>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label class="form-label">Lotação *</label>
                                                                        <input type="text" name="lotacao" class="form-control" maxlength="50" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-2">
                                                                    <div class="col-md-3">
                                                                        <label class="form-label">Matrícula *</label>
                                                                        <input type="text" name="matricula" class="form-control" maxlength="50" required>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label class="form-label">ID Funcional *</label>
                                                                        <input type="number" name="id_funcional" class="form-control" maxlength="50" required>
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <label class="form-label">Aposentado? *</label><br>
                                                                        <select name="aposentado" id="aposentado" class="form-control form-select" required>
                                                                            <option value="">Selecione</option>
                                                                            <option value="Sim">Sim</option>
                                                                            <option value="Não">Não</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-2">
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Data de Aposentadoria</label>
                                                                        <input type="date" name="data_aposentadoria" class="form-control" maxlength="10">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Beneficiários</label><br>
                                                                        <input type="checkbox" name="beneficiarios[]" value="conjuge"> Cônjuge
                                                                        <input type="checkbox" class="ms-3" name="beneficiarios[]" value="filho"> Filho(a)
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <!-- ARQUIVOS -->
                                                    <div class="card mb-4">
                                                        <div class="card-header bg-primary text-white">Documentos Obrigatórios</div>
                                                        <div class="card-body">
                                                            <p class="text-danger">Segure a tecla CTRL e selecione todos os arquivos:</p>
                                                            <ul>
                                                                <li>Último contracheque</li>
                                                                <li>Carteira funcional</li>
                                                                <li>CPF</li>
                                                                <li>RG</li>
                                                            </ul>
                                                            <input type="file" name="arquivos[]" class="form-control" multiple required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card mb-4">
                                            <div class="card-header bg-warning text-dark fw-bold text-center">
                                                Autorização de Desconto em Folha
                                            </div>
                                            <div class="card-body text-center">
                                                <p class="text-danger fw-bold">
                                                    <strong>VALOR DA MENSALIDADE DE R$ 55,00 </strong><br>
                                                    Autorizo o desconto mensal em minha folha de pagamento da importância
                                                    supramencionada em favor do Sindicato  dos Funcionários
                                                    da  Polícia Civil - RJ.
                                                </p>
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" name="autorizacao_desconto" id="autorizacao_desconto" required>
                                                    <label class="form-check-label text-dark" for="autorizacao_desconto">
                                                        Confirmo minha autorização.
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- reCAPTCHA -->
                                    <div class="mb-3">
                                        <div class="g-recaptcha" data-sitekey="{{env('DATA_SITE_KEY')}}"></div>
                                        @error('g-recaptcha-response')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" id="btnEnviar" class="btn btn-success px-4" disabled>
                                            <span id="btnTexto">Enviar</span>
                                            <span id="btnSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-warning mb-3" onclick="preencherCamposTeste()">
                                        Preencher formulário automaticamente (teste)
                                    </button>

                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4">
                <!-- Popular News Start -->
                    <div class="mb-3">
                        @include('home.ultimasNoticias')
                    </div>
                <!-- Popular News End -->
                <!-- Ads Start -->
                @include('home.video')
                <!-- End Ads -->
                    <!-- Newsletter Start -->
                    <div class="mb-3">
                        @include('home.newsLetter')
                    </div>
                    <!-- Newsletter End -->
                </div>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <script src="{{URL::asset('lib/mask/imask.js')}}"></script>
    <script src="{{URL::asset('js/ficha.js')}}"></script>
@endpush


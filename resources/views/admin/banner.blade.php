@extends('admin.layouts.layout')

@section('menu')
    @include('admin.menu')
@endsection

@section('content')

    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item">Banners</li>
                <li class="breadcrumb-item active">Gerenciar Banners</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('danger'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-octagon me-1"></i> {{ session('danger') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </section>

    <!-- ===== MODAL BANNER ===== -->
    <div class="modal fade" id="modalBanner" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ route('banner.store') }}" id="bannerForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-content shadow-lg border-0">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-image me-2"></i>
                            <span id="modalBannerTitulo">Adicionar Banner</span>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body p-4">
                        <div class="row g-3">

                            <div class="col-12">
                                <label class="form-label fw-bold">Imagem do Banner</label>
                                <div class="alert alert-info py-2 px-3 mb-2 small d-flex gap-3 align-items-start">
                                    <i class="bi bi-info-circle-fill fs-5 mt-1 flex-shrink-0"></i>
                                    <div>
                                        <strong>Dimensões recomendadas:</strong> <code>1920 × 400 px</code> (largura × altura)<br>
                                        <strong>Mínimo aceitável:</strong> <code>800 × 200 px</code> — abaixo disso a imagem ficará pixelada<br>
                                        <strong>Formatos:</strong> PNG, JPG ou WEBP &nbsp;|&nbsp;
                                        <strong>Tamanho máximo:</strong> 5 MB<br>
                                        <span class="text-muted">A imagem será recortada automaticamente para preencher a largura total do site sem distorção.</span>
                                    </div>
                                </div>

                                {{-- Preview da imagem atual (edição) --}}
                                <div id="previewAtualBox" class="mb-2" style="display:none;">
                                    <p class="small text-muted mb-1"><i class="bi bi-image me-1"></i>Imagem atual:</p>
                                    <img id="previewAtualImg" src="" alt="Atual"
                                         class="img-fluid rounded border shadow-sm" style="max-height:130px;">
                                </div>

                                {{-- Área de upload com input simples --}}
                                <div id="uploadArea" style="position:relative; border:2px dashed #6ea8fe;
                                     border-radius:8px; background:#f0f4ff; padding:30px;
                                     text-align:center; cursor:pointer; transition:all .2s;">
                                    <i class="bi bi-cloud-upload fs-1 text-primary d-block mb-2"></i>
                                    <p class="mb-1 fw-semibold text-primary">Arraste a imagem ou clique para procurar</p>
                                    <p class="text-muted small mb-0">PNG, JPG, JPEG, WEBP — máx. 5MB</p>
                                    <input type="file" name="image" id="bannerImageInput"
                                           accept="image/png,image/jpeg,image/jpg,image/webp"
                                           style="position:absolute;top:0;left:0;width:100%;height:100%;opacity:0;cursor:pointer;">
                                </div>

                                {{-- Preview da nova imagem selecionada --}}
                                <div id="newImagePreview" class="mt-2" style="display:none;">
                                    <p class="small text-muted mb-1"><i class="bi bi-check-circle-fill text-success me-1"></i>Nova imagem selecionada:</p>
                                    <div class="d-flex align-items-center gap-3">
                                        <img id="newImageImg" src="" alt="Preview"
                                             class="img-fluid rounded border shadow-sm" style="max-height:120px; max-width:300px;">
                                        <button type="button" class="btn btn-sm btn-outline-danger" id="btnRemoverImagem">
                                            <i class="bi bi-x-circle me-1"></i>Remover
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="tituloBanner" class="form-label fw-bold">
                                    Título <span class="text-muted fw-normal">(Opcional)</span>
                                </label>
                                <input type="text" name="titulo" id="tituloBanner"
                                       class="form-control" placeholder="Ex: Banner Principal">
                            </div>

                            <div class="col-md-6">
                                <label for="linkBanner" class="form-label fw-bold">
                                    Link <span class="text-muted fw-normal">(Opcional)</span>
                                </label>
                                <input type="text" name="link" id="linkBanner"
                                       class="form-control" placeholder="https://...">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnSalvarBanner" class="btn btn-primary px-5" disabled>
                            <i class="bi bi-floppy me-1"></i>
                            <span id="btnSalvarTexto">Salvar Banner</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- ===== TABELA ===== -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title m-0 fw-bold">Gerenciar Banners</h5>
                        <button type="button" class="btn btn-primary px-4 shadow-sm" id="btnNovoBanner">
                            <i class="bi bi-plus-circle me-1"></i> Adicionar Novo Banner
                        </button>
                    </div>

                    <table class="table datatable table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th width="50">#</th>
                                <th width="280">Miniatura</th>
                                <th>Informações</th>
                                <th width="100">Status</th>
                                <th width="130">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($banners as $banner)
                                <tr>
                                    <th>{{ $banner->id }}</th>
                                    <td>
                                        <div class="border rounded overflow-hidden shadow-sm" style="width:240px;">
                                            <img src="{{ URL::asset('storage/banners/'.$banner->path) }}"
                                                 class="img-fluid" style="max-height:80px;width:100%;object-fit:cover;"
                                                 alt="Banner">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $banner->titulo ?: 'Sem título' }}</div>
                                        <div class="text-muted small">Link: {{ $banner->link ?: 'Nenhum' }}</div>
                                        <div class="text-muted small">Arquivo: {{ $banner->path }}</div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch d-flex justify-content-center">
                                            <input class="form-check-input statusSwitchBanner" type="checkbox"
                                                   data-id="{{ $banner->id }}"
                                                   data-rota="{{ route('atualizar-status-banner') }}"
                                                   {{ $banner->status == 0 ? '' : 'checked' }}>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group shadow-sm">
                                            <button class="btn btn-sm btn-outline-info btn-editar-banner"
                                                    data-id="{{ $banner->id }}"
                                                    data-titulo="{{ $banner->titulo }}"
                                                    data-link="{{ $banner->link }}"
                                                    data-rota-update="{{ route('banner.update', $banner->id) }}"
                                                    data-url-img="{{ URL::asset('storage/banners/'.$banner->path) }}"
                                                    title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger btn-excluir"
                                                    data-rota="{{ route('banner.destroy', $banner->id) }}"
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

@push('styles')
<style>
    #uploadArea:hover { border-color: #0d6efd !important; background: #e0eaff !important; }
    #uploadArea.dragover { border-color: #0a58ca !important; background: #ccdeff !important; }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function () {

    const csrfToken = '{{ csrf_token() }}';
    let modoEdicao = false;

    /* ─── Abre modal NOVO ─── */
    $('#btnNovoBanner').on('click', function () {
        modoEdicao = false;
        resetModal();
        $('#modalBannerTitulo').text('Adicionar Banner');
        $('#bannerForm').attr('action', '{{ route("banner.store") }}');
        $('#bannerForm input[name="_method"]').remove();
        $('#btnSalvarTexto').text('Salvar Banner');
        $('#btnSalvarBanner').prop('disabled', true);
        $('#modalBanner').modal('show');
    });

    /* ─── Abre modal EDITAR ─── */
    $(document).on('click', '.btn-editar-banner', function () {
        modoEdicao = true;
        resetModal();
        const $btn = $(this);

        $('#modalBannerTitulo').text('Editar Banner');
        $('#bannerForm').attr('action', $btn.data('rota-update'));
        $('#bannerForm input[name="_method"]').remove();
        $('#bannerForm').append('<input type="hidden" name="_method" value="PUT">');

        $('#tituloBanner').val($btn.data('titulo'));
        $('#linkBanner').val($btn.data('link'));

        $('#previewAtualImg').attr('src', $btn.data('url-img'));
        $('#previewAtualBox').show();

        // Na edição o botão fica ativo (pode salvar só o texto sem trocar imagem)
        $('#btnSalvarBanner').prop('disabled', false);
        $('#btnSalvarTexto').text('Salvar Alterações');

        $('#modalBanner').modal('show');
    });

    /* ─── Seleciona arquivo → preview e ativa Salvar ─── */
    $('#bannerImageInput').on('change', function () {
        const file = this.files[0];
        if (!file) return;

        const tiposPermitidos = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];
        if (!tiposPermitidos.includes(file.type)) {
            alert('Tipo inválido. Use PNG, JPG ou WEBP.');
            $(this).val('');
            return;
        }
        if (file.size > 5 * 1024 * 1024) {
            alert('Arquivo muito grande. Máximo 5MB.');
            $(this).val('');
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            $('#newImageImg').attr('src', e.target.result);
            $('#newImagePreview').show();
        };
        reader.readAsDataURL(file);

        $('#btnSalvarBanner').prop('disabled', false);
    });

    /* ─── Remove imagem selecionada ─── */
    $('#btnRemoverImagem').on('click', function () {
        $('#bannerImageInput').val('');
        $('#newImagePreview').hide();
        if (!modoEdicao) {
            $('#btnSalvarBanner').prop('disabled', true);
        }
    });

    /* ─── Drag & Drop ─── */
    const uploadArea = document.getElementById('uploadArea');
    uploadArea.addEventListener('dragover', function (e) {
        e.preventDefault();
        this.classList.add('dragover');
    });
    uploadArea.addEventListener('dragleave', function () {
        this.classList.remove('dragover');
    });
    uploadArea.addEventListener('drop', function (e) {
        e.preventDefault();
        this.classList.remove('dragover');
        const dt = e.dataTransfer;
        if (dt.files.length > 0) {
            // Atribui o arquivo ao input e dispara o evento change
            const input = document.getElementById('bannerImageInput');
            // DataTransfer para atribuir arquivo ao input nativo
            try {
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(dt.files[0]);
                input.files = dataTransfer.files;
                $(input).trigger('change');
            } catch(err) {
                // Fallback para navegadores mais antigos
                $(input).trigger('change');
            }
        }
    });

    /* ─── Fecha modal → limpa tudo ─── */
    $('#modalBanner').on('hidden.bs.modal', function () {
        resetModal();
    });

    function resetModal() {
        $('#bannerForm')[0].reset();
        $('#bannerForm input[name="_method"]').remove();
        $('#previewAtualBox').hide();
        $('#newImagePreview').hide();
        $('#bannerImageInput').val('');
    }

    /* ─── Loading no submit ─── */
    $('#bannerForm').on('submit', function () {
        $('#btnSalvarBanner').prop('disabled', true)
            .html('<span class="spinner-border spinner-border-sm me-2"></span>Salvando...');
    });

    /* ─── Status switch ─── */
    $(document).on('change', '.statusSwitchBanner', function () {
        $.ajax({
            url: $(this).data('rota'),
            type: 'POST',
            data: { _token: csrfToken, id: $(this).data('id'), status: $(this).prop('checked') ? 1 : 0 },
            success: function (r) {
                if (typeof toastr !== 'undefined') {
                    r.success ? toastr.success('Status atualizado!') : toastr.error('Erro ao atualizar.');
                }
            }
        });
    });

    /* ─── Excluir ─── */
    $(document).on('click', '.btn-excluir', function () {
        const rota = $(this).data('rota');
        Swal.fire({
            title: 'Excluir banner?',
            text: 'Esta ação não pode ser desfeita.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Sim, excluir'
        }).then(result => {
            if (result.isConfirmed) {
                $.ajax({
                    url: rota, type: 'POST',
                    data: { _token: csrfToken, _method: 'DELETE' },
                    success: function (r) {
                        if (r.success) {
                            if (typeof toastr !== 'undefined') toastr.success('Banner excluído!');
                            setTimeout(() => location.reload(), 800);
                        }
                    }
                });
            }
        });
    });

});
</script>
@endpush

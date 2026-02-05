
/**
 * ######################## AREA PAGINAS #####################
 * Limpa o modal
 * */
$('.btnModalPagina').on('click', function (e) {
    $("#titulo").val("");
    $("#slug").val("");
    tinymce.activeEditor.setContent("");

    $('#paginaForm').attr('action', $(this).data('rota'));

    const meuFormulario = document.getElementById('paginaForm');
    const existingMethodInput = meuFormulario.querySelector('input[name="_method"]');
    if (existingMethodInput) {
        meuFormulario.removeChild(existingMethodInput);
    }
});

/***
 * Salva a PAGINA
 * */
document.addEventListener('DOMContentLoaded', function () {
    let paginaForm = document.getElementById('paginaForm');
    if (paginaForm) {
        paginaForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const titulo = document.getElementById('titulo');

            if (titulo.value.trim() === "") {
                titulo.focus();
                Swal.fire({
                    title: 'Atenção!',
                    text: 'O Título/Identificador deve ser informado!',
                    icon: 'info',
                    confirmButtonText: 'OK'
                })
                return;
            }

            const tinymceContent = tinymce.get('tinymce_editor').getContent();
            if (tinymceContent.trim() === "") {
                Swal.fire({
                    title: 'Atenção!',
                    text: 'O Conteúdo da Página está vazio!',
                    icon: 'info',
                    confirmButtonText: 'OK'
                })
                return;
            }

            this.submit();
        });
    }

    // Auto slug generator (simple version)
    const tituloField = document.getElementById('titulo');
    const slugField = document.getElementById('slug');
    if (tituloField && slugField) {
        tituloField.addEventListener('input', function () {
            let text = this.value;
            let slug = text.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim()
                .replace(/[\s\W-]+/g, '-').replace(/^-+|-+$/g, '');
            slugField.value = slug;
        });
    }
});

/**
 * Editar a Pagina
 * */
document.querySelectorAll('.btn-editar-pagina').forEach(btn => {
    btn.addEventListener('click', function (e) {
        e.preventDefault();

        const rota = $(this).data('rota');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const meuFormulario = document.getElementById('paginaForm');

        // Remove method input if exists
        const existingMethodInput = meuFormulario.querySelector('input[name="_method"]');
        if (existingMethodInput) {
            meuFormulario.removeChild(existingMethodInput);
        }

        fetch(rota, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            }
        })
            .then(response => response.json())
            .then(response => {
                if (response.success) {
                    document.getElementById('titulo').value = response.data.titulo;
                    document.getElementById('slug').value = response.data.slug;
                    tinymce.activeEditor.setContent(response.data.conteudo);

                    meuFormulario.action = $(this).data('rota-update');

                    const hiddenMethodInput = document.createElement('input');
                    hiddenMethodInput.type = 'hidden';
                    hiddenMethodInput.name = '_method';
                    hiddenMethodInput.value = 'PUT';
                    meuFormulario.appendChild(hiddenMethodInput);

                    // Emular evento input para garantir que o slug visual esteja certo se o usuario mexer no titulo
                    // mas aqui pegamos do banco.
                } else {
                    Swal.fire({
                        title: 'Error!',
                        icon: 'error',
                        html: response.message,
                        showConfirmButton: true
                    });
                }
            })
            .catch(error => Swal.fire({
                title: 'Error!',
                icon: 'error',
                html: error,
                showConfirmButton: true
            })
            );
    });
});

/***
 * Atualiza STATUS da pagina
 */
document.querySelectorAll('.statusSwitch').forEach(function (element) {
    element.addEventListener('click', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const rota = $(this).data('rota');
        const id = $(this).data('id');
        let status = this.checked ? 1 : 0;

        fetch(rota, {
            method: 'POST',
            body: JSON.stringify({ id: id, status: status }),
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Sucesso!',
                        html: data.message,
                        icon: 'success',
                        timer: 1000
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        icon: 'error',
                        html: data.message,
                        showConfirmButton: true
                    });
                }
            })
            .catch(error => Swal.fire({
                title: 'Error!',
                icon: 'error',
                html: error,
                showConfirmButton: true
            })
            );
    });
});

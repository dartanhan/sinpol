/**
 * ######################## AREA SECAO #####################
 * */
$('.btnModalSecao').on('click', function (e) {
    $("#titulo").val("");
    tinymce.activeEditor.setContent("");

    $('#secaoForm').attr('action', $(this).data('rota'));

    const meuFormulario = document.getElementById('secaoForm');
    const existingMethodInput = meuFormulario.querySelector('input[name="_method"]');
    if (existingMethodInput) {
        meuFormulario.removeChild(existingMethodInput);
    }
});

document.addEventListener('DOMContentLoaded', function () {
    let secaoForm = document.getElementById('secaoForm');
    if (secaoForm) {
        secaoForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const tinymceContent = tinymce.get('tinymce_editor').getContent();
            if (tinymceContent.trim() === "") {
                Swal.fire({
                    title: 'Atenção!',
                    text: 'O Conteúdo está vazio!',
                    icon: 'info',
                    confirmButtonText: 'OK'
                })
                return;
            }

            tinymce.triggerSave(); // Sincroniza o editor com o textarea original
            this.submit();
        });
    }
});

document.querySelectorAll('.btn-editar-secao').forEach(btn => {
    btn.addEventListener('click', function (e) {
        e.preventDefault();

        const rota = $(this).data('rota');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const meuFormulario = document.getElementById('secaoForm');

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
                    if (document.getElementById('titulo')) {
                        document.getElementById('titulo').value = response.data.titulo;
                    }
                    tinymce.activeEditor.setContent(response.data.conteudo);

                    meuFormulario.action = $(this).data('rota-update');

                    const hiddenMethodInput = document.createElement('input');
                    hiddenMethodInput.type = 'hidden';
                    hiddenMethodInput.name = '_method';
                    hiddenMethodInput.value = 'PUT';
                    meuFormulario.appendChild(hiddenMethodInput);

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

document.querySelectorAll('.btn-excluir-secao').forEach(function (element) {
    element.addEventListener('click', function () {
        const rota = $(this).data('rota');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let confirmation = confirm("Deseja realmente excluir este conteúdo?");
        if (!confirmation) return;

        fetch(rota, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert("Erro ao excluir");
                }
            })
            .catch(error => alert("Erro ao excluir"));
    });
});

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


/**
 * ######################## AREA DIRETORIA #####################
 * Limpa o modal
 * */
$('.btnModalDiretoria').on('click', function(e) {

    // Limpar o conteúdo do modal
    $("#titulo").val("");
    $("#slug").val("");
    tinymce.activeEditor.setContent("");

    $('#diretoriaForm').attr('action', $(this).data('rota')); // Substitua 'url_padrao' pela URL original
    //para quando for nova notícia ajusta o form devido a ação de edição
    const meuFormulario = document.getElementById('diretoriaForm');
    // Remova o input _method existente, se houver caso tenha ocorrido edição, pois o form é o mesmo
    const existingMethodInput = meuFormulario.querySelector('input[name="_method"]');
    if (existingMethodInput) {
        meuFormulario.removeChild(existingMethodInput);
    }
});

/***
 * Salva a DIRETORIA
 * */
document.addEventListener('DOMContentLoaded', function() {
    let diretoriaForm = document.getElementById('diretoriaForm');
    if (diretoriaForm) {
        diretoriaForm.addEventListener('submit', function (event) {
            // Evita o envio padrão do formulário
            event.preventDefault();

            // Realize aqui suas verificações de validação
            const titulo = document.getElementById('titulo');
            const slug = document.getElementById('slug');

            if (titulo.value.trim() === "") {
                titulo.focus();
                Swal.fire({
                    title: 'Atenção!',
                    text: 'O Titulo deve ser informado!',
                    icon: 'info',
                    confirmButtonText: 'OK'
                })
                return;
            }

            if (slug.value.trim() === "") {
                slug.focus();
                Swal.fire({
                    title: 'Atenção!',
                    text: 'O slug deve ser preenchido',
                    icon: 'info',
                    confirmButtonText: 'OK'
                })
                return;
            }

            const tinymceContent = tinymce.get('tinymce_editor').getContent();
            if (tinymceContent.trim() === "") {
                Swal.fire({
                    title: 'Atenção!',
                    text: 'O Conteúdo da Diretoria está vazio!',
                    icon: 'info',
                    confirmButtonText: 'OK'
                })
                return;
            }

            // Se a validação passar, submeta o formulário
            this.submit();
        });
    }
});

/**
 * Editar a Diretoria
 * */
document.querySelectorAll('.btn-editar-diretoria').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();

        const rota = $(this).data('rota');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const meuFormulario = document.getElementById('diretoriaForm');

        // Remova o input _method existente, se houver
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
               // console.log(response);

                if (response.success) {

                    // Preencher os campos do modal com os dados obtidos
                    document.getElementById('titulo').value = response.data.titulo;
                    document.getElementById('slug').value = response.data.slug;
                    tinymce.activeEditor.setContent(response.data.conteudo);

                    // Defina a URL de ação
                    meuFormulario.action = $(this).data('rota-update');

                    // Crie um novo input _method apenas uma vez
                    const hiddenMethodInput = document.createElement('input');
                    hiddenMethodInput.type = 'hidden';
                    hiddenMethodInput.name = '_method';
                    hiddenMethodInput.value = 'PUT';
                    meuFormulario.appendChild(hiddenMethodInput);

                    // Abrir o modal
                    // $('#modalDiretoria').modal('show');
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

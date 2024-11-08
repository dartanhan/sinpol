$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    const tituloField = document.getElementById('titulo');
    const slugField = document.getElementById('slug');

    // Evento para monitorar alterações no campo título
    if (tituloField && slugField) {
        // Evento para monitorar alterações no campo título
        tituloField.addEventListener('input', function () {
            const title = this.value;
            slugField.value = generateSlug(title);
        });
    }

    function generateSlug(text) {
        return text
            .normalize('NFD')                          // Normaliza o texto
            .replace(/[\u0300-\u036f]/g, '')           // Remove os acentos
            .toLowerCase()                             // Converte para minúsculas
            .trim()                                    // Remove espaços no início e no final
            .replace(/[\s\W-]+/g, '-')                 // Substitui espaços e caracteres especiais por '-'
            .replace(/^-+|-+$/g, '');                  // Remove '-' no início e no final
    }

})
$('.imagem-selecao').click(function() {
    // Obtém o caminho da imagem clicada
    let caminhoImagem = $(this).attr('src');

    // Preenche o input com o ID da imagem
    $('#idImagemDestaque').val( $(this).data('id'));

    // Atualiza o preview da imagem
    $('#previewImagem').attr('src', caminhoImagem);

    var previewImagem = document.getElementById('previewImagem');
    previewImagem.style.display = 'block';

    // Fecha o modal
    $('#imagemModal').modal('hide');
});

$('#modalImage').click(function() {
 //   $('#previewImagem').attr('src', "");
   // $('#destaque').prop('checked', false);
   // $("#editorContainer").css('display','none');
    $('#imagemModal').modal('show');
});


/**
 * Limpa o modal
 * */
$('.btnModal').on('click', function(e) {
    // Limpar o conteúdo do modal
    $("#titulo").val("");
    $("#subtitulo").val("");
    $("#slug").val("");
    tinymce.activeEditor.setContent("");
    $('#noticiaForm').attr('action', $(this).data('rota')); // Substitua 'url_padrao' pela URL original
    //para quando for nova notícia ajusta o form devido a ação de edição
    const meuFormulario = document.getElementById('noticiaForm');
    // Remova o input _method existente, se houver caso tenha ocorrido edição, pois o form é o mesmo
    const existingMethodInput = meuFormulario.querySelector('input[name="_method"]');
    if (existingMethodInput) {
        meuFormulario.removeChild(existingMethodInput);
    }
    $('#destaque').prop('checked', false);
    $('#previewImagem').attr('src', "");
    $('#previewImagem').addClass("img-thumbnail-none");
    $("#editorContainer").css('display','none');
    $("#idImagemDestaque").val("");
});

/***
 *
 * */
$(".resize-image-gallery").on('click',function(e){
    e.preventDefault();
    const image = e.target;
    const imageHtml = `<img src="${image.src}" alt="${image.alt}" width="400">`;
    tinymce.get('tinymce_editor').execCommand('mceInsertContent',false,imageHtml);
});

/****
 * Joga o conteudo no modal de visualização
 * */

document.querySelectorAll('.btn-view').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();

        let conteudo = $(this).data('conteudo');
        let imgDestaque = $(this).data('img-destaque');
        let imgDest = "<img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\""+imgDestaque+"\" alt=\"\" width=\"400\"'>";

        let conteudoRetorno = '<div class="card">';
        conteudoRetorno += '<div class="card-header bg-secondary text-white">';
        conteudoRetorno += 'Imagem de Destaque';
        conteudoRetorno += '</div>';
        conteudoRetorno += '<div class="card-body">';
        conteudoRetorno += imgDest;
        conteudoRetorno += '</div>';
        conteudoRetorno += '<div class="card-header bg-secondary text-white">';
        conteudoRetorno += 'Conteúdo da Notícia';
        conteudoRetorno += '</div>';
        conteudoRetorno += '<div class="card-body">';
        conteudoRetorno += conteudo;
        conteudoRetorno += '</div>';
        conteudoRetorno += '</div>';

        $('#modal-conteudo').html(conteudoRetorno);

        // Abrir o modal
        $('#modalConteudoNoticia').modal('show');
    });
});

// $('.ler-mais').on('click', function(e) {
//     e.preventDefault();
//     let conteudo = $(this).data('conteudo');
//     let imgDestaque = $(this).data('img-destaque');
//     let imgDest = "<img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\""+imgDestaque+"\" alt=\"\" width=\"400\"'>";
//
//     let conteudoRetorno = '<div class="card">';
//             conteudoRetorno += '<div class="card-header bg-secondary text-white">';
//                 conteudoRetorno += 'Imagem de Destaque';
//             conteudoRetorno += '</div>';
//             conteudoRetorno += '<div class="card-body">';
//                 conteudoRetorno += imgDest;
//             conteudoRetorno += '</div>';
//             conteudoRetorno += '<div class="card-header bg-secondary text-white">';
//                 conteudoRetorno += 'Conteúdo da Notícia';
//             conteudoRetorno += '</div>';
//             conteudoRetorno += '<div class="card-body">';
//                 conteudoRetorno += conteudo;
//             conteudoRetorno += '</div>';
//         conteudoRetorno += '</div>';
//
//     $('#modal-conteudo').html(conteudoRetorno);
// });

/***
 * Salva a notícia
 * */
document.addEventListener('DOMContentLoaded', function() {
    let noticiaForm = document.getElementById('noticiaForm');
    if (noticiaForm) {
        noticiaForm.addEventListener('submit', function (event) {
            // Evita o envio padrão do formulário
            event.preventDefault();

            // Realize aqui suas verificações de validação
            const titulo = document.getElementById('titulo');
            const slug = document.getElementById('slug');

            if (titulo.value.trim() === "") {
                titulo.focus();
                Swal.fire({
                    title: 'Atenção!',
                    text: 'O Título da noticia deve ser informado!',
                    icon: 'info',
                    confirmButtonText: 'OK'
                })
                return;
            }

            if (slug.value.trim() === "") {
                slug.focus();
                Swal.fire({
                    title: 'Atenção!',
                    text: 'O Slug da noticia deve ser informado!',
                    icon: 'info',
                    confirmButtonText: 'OK'
                })
                return;
            }

            if ($('#destaque').is(':checked') && $("#imagemDestaque").val() === "") {
                Swal.fire({
                    title: 'Atenção!',
                    text: 'Para colcoar a Notícia em destaque é necessário uma Imagem!',
                    icon: 'info',
                    confirmButtonText: 'OK'
                })
                return;
            }

            const tinymceContent = tinymce.get('tinymce_editor').getContent();
            if (tinymceContent.trim() === "") {
                Swal.fire({
                    title: 'Atenção!',
                    text: 'O Conteúdo da Notícia está está vazio!',
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


/*$('#noticiaForm').submit(function(e){
    e.preventDefault();
    const tinymceContent = tinymce.get('tinymce_editor').getContent();


    if($("#titulo").val() === "") {
        Swal.fire({
            title: 'Atenção!',
            text: 'O texto da noticia deve ser informado!',
            icon: 'info',
            confirmButtonText: 'OK'
        }).then((result) => {

            if (result.isConfirmed) {
                $("#titulo").addClass('error-input');
            }
        });
        return false;
    }

    if ($('#destaque').is(':checked')){
        console.log('Nenhum arquivo carregado no FilePond');
        if(filepondInput && filepondInput.files && filepondInput.files.length > 0) {
            Swal.fire({
                title: 'Atenção!',
                text: 'Para colocar em destaque é necessário informar a imagem!',
                icon: 'info',
                confirmButtonText: 'OK'
            }).then((result) => {

                if (result.isConfirmed) {
                    return false;
                }
            });
        }
        return false;
    }

    if (tinymceContent.trim() === '') {
        Swal.fire({
            title: 'Atenção!',
            text: 'O conteúdo da Notícia está está vazio!',
            icon: 'info',
            confirmButtonText: 'OK'
        }).then((result) => {

            if (result.isConfirmed) {
                return false;
            }
        })
    }else{
        // Submit the form
        this.submit();
    }
});

 */

/***
 * Adicione um ouvinte de eventos para o Excluir
 * */
document.querySelectorAll('.btn-excluir').forEach(btn => {
    btn.addEventListener('click', function(e) {
    e.preventDefault();

    const rota = $(this).data('rota');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    Swal.fire({
        title: 'Atenção?',
        text: "Deseja mesmo deleter esta informação?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim!'
    }).then((result) => {
        if (result.isConfirmed) {
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
                        Swal.fire({
                            title: 'Sucesso!',
                            html: data.message,
                            icon: 'success',
                            timer: 2000,
                            willClose: () => {
                                location.reload();
                            }
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
         }
        });
    });
});



/***
 * Adicione um ouvinte de eventos para o Atualiza o status da noticia
 * */
document.querySelectorAll('.statusSwitch').forEach( function(element) {
    element.addEventListener('click', function() {
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
                        timer: 2000,
                        willClose: () => {
                            location.reload();
                        }
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

/***
 * Adicione um ouvinte de eventos para o Atualiza o destaque da noticia
 * */
document.querySelectorAll('.destaqueSwitch').forEach( function(element) {
    element.addEventListener('click', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const rota = $(this).data('rota');
        const id = $(this).data('id');
        let status = this.checked ? 1 : 0;

        fetch(rota, {
            method: 'POST',
            body: JSON.stringify({ id: id, destaque: status }),
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
                        timer: 2000,
                        willClose: () => {
                            location.reload();
                        }
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

/***
 * Adicione um ouvinte de eventos para o btn-editar
 * */
document.querySelectorAll('.btn-editar').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();

        const rota = $(this).data('rota');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const meuFormulario = document.getElementById('noticiaForm');

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
                //console.log(response);

                if (response.success) {

                    let imagem = response.data.imagem_id !== null ? response.data.imagens[0].path : "";

                    // Preencher os campos do modal com os dados obtidos
                    document.getElementById('idImagemDestaque').value = response.data.imagem_id !== null ? response.data.imagens[0].id : "";
                    document.getElementById('titulo').value = response.data.titulo;
                    document.getElementById('subtitulo').value = response.data.subtitulo;
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

                    if(imagem !== ""){
                        $('#previewImagem').attr('src', "../public/storage/posts/files/"+imagem);
                        $("#editorContainer").css('display','block');
                        $('#destaque').prop('checked', true);
                        $('#previewImagem').removeClass("img-thumbnail-none");
                    }else{
                        $('#destaque').prop('checked', false);
                        $('#previewImagem').addClass("img-thumbnail-none");
                        $("#editorContainer").css('display','none');
                    }
                    // Abrir o modal
                    $('#modalNoticia').modal('show');
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
 * Adicione um ouvinte de eventos para o btn-editar-convencao
 * */
document.querySelectorAll('.btn-editar-convencao').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();

        const rota = $(this).data('rota');
        const fileId = $(this).data('file-id');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


        fetch(rota, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            }
        })
            .then(response => response.json())
            .then(response => {
                console.log(response);

                if (response.success) {

                    // Preencher os campos do modal com os dados obtidos
                    document.getElementById('titulo').value = response.data.titulo_cct;
                    document.getElementById('data_cct').value = response.data.data_cct;
                    //  document.getElementById('descricao_cct').value = response.data.descricao_cct;
                    tinymce.activeEditor.setContent(response.data.descricao_cct !== null ? response.data.descricao_cct.descricao : '');


                    let meuFormulario = document.getElementById('uploadForm');
                    meuFormulario.action = $(this).data('rota-update'); // pega a url de update que está no objeto clicado

                    let hiddenMethodInput = document.createElement('input');
                    hiddenMethodInput.type = 'hidden';
                    hiddenMethodInput.name = '_method';
                    hiddenMethodInput.value = 'PUT';
                    meuFormulario.appendChild(hiddenMethodInput);

                    //id da tabela convenção
                    hiddenMethodInput = document.createElement('input');
                    hiddenMethodInput.type = 'hidden';
                    hiddenMethodInput.name = 'convencao-id';
                    hiddenMethodInput.value = response.data.id;
                    meuFormulario.appendChild(hiddenMethodInput);

                    //id data table de descrição da convenção
                    if(response.data.descricao_cct !== null){
                        hiddenMethodInput = document.createElement('input');
                        hiddenMethodInput.type = 'hidden';
                        hiddenMethodInput.name = 'convencao_descricao_id';
                        hiddenMethodInput.value = response.data.descricao_cct.id;
                        meuFormulario.appendChild(hiddenMethodInput);
                    }

                    //id do arquivo
                    hiddenMethodInput = document.createElement('input');
                    hiddenMethodInput.type = 'hidden';
                    hiddenMethodInput.name = 'file_id';
                    hiddenMethodInput.value = fileId;
                    meuFormulario.appendChild(hiddenMethodInput);

                    // Abrir o modal
                    $('#convencaoModal').modal('show');
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

/**
 *Adicione um ouvinte de eventos para o switch
  */

document.addEventListener('DOMContentLoaded', function() {
    let destaque = document.getElementById('destaque');
    if (destaque) {
        destaque.addEventListener('change', function (event) {
            let editorContainer = document.getElementById('editorContainer');

            // Verifique se o switch está marcado
            if (this.checked) {
                editorContainer.style.display = 'block'; // Exiba o campo de texto
            } else {
                editorContainer.style.display = 'none'; // Oculte o campo de texto
                $("#caminhoImagem").val('');
                $('#previewImagem').attr('src', '');
                let previewImagem = document.getElementById('previewImagem');
                previewImagem.style.display = 'none';
            }
        });
    }
});



/***
 * REmove o item selecionado
 * */
document.querySelectorAll('.btnRemove').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();

        const rota = $(this).data('rota');
        const imageId = $(this).data('id');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: 'Atenção?',
            text: "Deseja mesmo deleter esta arquivo?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(rota, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        image_id: imageId
                    })
                })
                    .then(response => response.json())
                    .then(response => {
                        console.log(response);

                        if (response.success) {
                            Swal.fire({
                                title: 'Sucesso!',
                                icon: 'success',
                                html: response.message,
                                showConfirmButton: true
                            });
                            // Remover o contêiner .product-card do DOM
                            btn.closest('.product-card').remove();
                        } else {
                            Swal.fire({
                                title: 'Atenção!',
                                icon: 'warning',
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
            }
        });
    });
});


/**
 * * ######################## AREA VIDEOS #####################
 *
 * Limpa o modal video
 * */
$('.btnModalVideo').on('click', function(e) {
    // Limpar o conteúdo do modal
    $("#titulo").val("");
    $("#slug").val("");
    $("#link").val("");
    $("#subtitulo").val("");
    $('#videoForm').attr('action', $(this).data('rota')); // Substitua 'url_padrao' pela URL original
    //para quando for nova notícia ajusta o form devido a ação de edição
    const meuFormulario = document.getElementById('videoForm');
    // Remova o input _method existente, se houver caso tenha ocorrido edição, pois o form é o mesmo
    const existingMethodInput = meuFormulario.querySelector('input[name="_method"]');
    if (existingMethodInput) {
        meuFormulario.removeChild(existingMethodInput);
    }
    $('#destaque').prop('checked', false);
});

/***
 * Salva o video
 * */
document.addEventListener('DOMContentLoaded', function() {
    let videoForm = document.getElementById('videoForm');
    if (videoForm) {
        videoForm.addEventListener('submit', function (event) {
            // Evita o envio padrão do formulário
            event.preventDefault();

            // Realize aqui suas verificações de validação
            const titulo = document.getElementById('titulo');
            const slug = document.getElementById('slug');
            const link = document.getElementById('link');

            if (link.value.trim() === "") {
                link.focus();
                Swal.fire({
                    title: 'Atenção!',
                    text: 'O Link deve ser informado!',
                    icon: 'info',
                    confirmButtonText: 'OK'
                })
                return;
            }

            if (titulo.value.trim() === "") {
                titulo.focus();
                Swal.fire({
                    title: 'Atenção!',
                    text: 'O Título deve ser informado!',
                    icon: 'info',
                    confirmButtonText: 'OK'
                })
                return;
            }

            if (slug.value.trim() === "") {
                slug.focus();
                Swal.fire({
                    title: 'Atenção!',
                    text: 'O Slug deve ser informado!',
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
 * Editar o vídeo
 * */
document.querySelectorAll('.btn-editar-video').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();

        const rota = $(this).data('rota');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const meuFormulario = document.getElementById('videoForm');

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
                console.log(response);

                if (response.success) {

                    // Preencher os campos do modal com os dados obtidos
                    document.getElementById('titulo').value = response.data.titulo;
                    document.getElementById('subtitulo').value = response.data.subtitulo;
                    document.getElementById('slug').value = response.data.slug;
                    document.getElementById('link').value = response.data.link;

                    // Defina a URL de ação
                    meuFormulario.action = $(this).data('rota-update');

                    // Crie um novo input _method apenas uma vez
                    const hiddenMethodInput = document.createElement('input');
                    hiddenMethodInput.type = 'hidden';
                    hiddenMethodInput.name = '_method';
                    hiddenMethodInput.value = 'PUT';
                    meuFormulario.appendChild(hiddenMethodInput);

                    // Abrir o modal
                   // $('#modalVideo').modal('show');
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

/**
 * ######################## AREA BENEFICIOS #####################
 * Limpa o modal
 * */
$('.btnModalBeneficio').on('click', function(e) {
    // Limpar o conteúdo do modal
    $("#titulo").val("");
    $("#slug").val("");
    tinymce.activeEditor.setContent("");
    $('#beneficioForm').attr('action', $(this).data('rota')); // Substitua 'url_padrao' pela URL original
    //para quando for nova notícia ajusta o form devido a ação de edição
    const meuFormulario = document.getElementById('beneficioForm');
    // Remova o input _method existente, se houver caso tenha ocorrido edição, pois o form é o mesmo
    const existingMethodInput = meuFormulario.querySelector('input[name="_method"]');
    if (existingMethodInput) {
        meuFormulario.removeChild(existingMethodInput);
    }
    $('#destaque').prop('checked', false);
});

/***
 * Salva o beneficio
 * */
document.addEventListener('DOMContentLoaded', function() {
    let beneficioForm = document.getElementById('beneficioForm');
    if (beneficioForm) {
        beneficioForm.addEventListener('submit', function (event) {
            // Evita o envio padrão do formulário
            event.preventDefault();

            // Realize aqui suas verificações de validação
            const titulo = document.getElementById('titulo');
            const slug = document.getElementById('slug');

            if (titulo.value.trim() === "") {
                titulo.focus();
                Swal.fire({
                    title: 'Atenção!',
                    text: 'O Título deve ser informado!',
                    icon: 'info',
                    confirmButtonText: 'OK'
                })
                return;
            }

            if (slug.value.trim() === "") {
                slug.focus();
                Swal.fire({
                    title: 'Atenção!',
                    text: 'O Slug deve ser informado!',
                    icon: 'info',
                    confirmButtonText: 'OK'
                })
                return;
            }
            const tinymceContent = tinymce.get('tinymce_editor').getContent();
            if (tinymceContent.trim() === "") {
                Swal.fire({
                    title: 'Atenção!',
                    text: 'O Conteúdo deve ser informado!',
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
 * Editar o beneficio
 * */
document.querySelectorAll('.btn-editar-beneficio').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();

        const rota = $(this).data('rota');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const meuFormulario = document.getElementById('beneficioForm');

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
                console.log(response);

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
                    // $('#modalVideo').modal('show');
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

/**
 * ######################## AREA CONVÊNIOS #####################
 * Limpa o modal
 * */
$('.btnModalConvenio').on('click', function(e) {
    // Limpar o conteúdo do modal
    $("#titulo").val("");
    $("#slug").val("");
    tinymce.activeEditor.setContent("");
    $('#convenioForm').attr('action', $(this).data('rota')); // Substitua 'url_padrao' pela URL original
    //para quando for nova notícia ajusta o form devido a ação de edição
    const meuFormulario = document.getElementById('convenioForm');
    // Remova o input _method existente, se houver caso tenha ocorrido edição, pois o form é o mesmo
    const existingMethodInput = meuFormulario.querySelector('input[name="_method"]');
    if (existingMethodInput) {
        meuFormulario.removeChild(existingMethodInput);
    }
});

/***
 * Salva o CONVÊNIOS
 * */
document.addEventListener('DOMContentLoaded', function() {
    let convenioForm = document.getElementById('convenioForm');
    if (convenioForm) {
        convenioForm.addEventListener('submit', function (event) {
            // Evita o envio padrão do formulário
            event.preventDefault();

            // Realize aqui suas verificações de validação
            const titulo = document.getElementById('titulo');
            const slug = document.getElementById('slug');

            if (titulo.value.trim() === "") {
                titulo.focus();
                Swal.fire({
                    title: 'Atenção!',
                    text: 'O Título deve ser informado!',
                    icon: 'info',
                    confirmButtonText: 'OK'
                })
                return;
            }

            if (slug.value.trim() === "") {
                slug.focus();
                Swal.fire({
                    title: 'Atenção!',
                    text: 'O Slug deve ser informado!',
                    icon: 'info',
                    confirmButtonText: 'OK'
                })
                return;
            }
            const tinymceContent = tinymce.get('tinymce_editor').getContent();
            if (tinymceContent.trim() === "") {
                Swal.fire({
                    title: 'Atenção!',
                    text: 'O Conteúdo deve ser informado!',
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
 * Editar o CONVÊNIOS
 * */
document.querySelectorAll('.btn-editar-convenio').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();

        const rota = $(this).data('rota');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const meuFormulario = document.getElementById('convenioForm');

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
                console.log(response);

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
                    // $('#modalVideo').modal('show');
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

/**
 * ######################## AREA USUARIOS #####################
 * Limpa o modal
 * */
$('.btnModalUser').on('click', function(e) {
    // Limpar o conteúdo do modal
    $("#name").val("");
    $("#email").val("");
    $("#password").val("");
    $("#password_confirmation").val("");

    $('#register').attr('action', $(this).data('rota')); // Substitua 'url_padrao' pela URL original
    //para quando for nova notícia ajusta o form devido a ação de edição
    const meuFormulario = document.getElementById('register');
    // Remova o input _method existente, se houver caso tenha ocorrido edição, pois o form é o mesmo
    const existingMethodInput = meuFormulario.querySelector('input[name="_method"]');
    if (existingMethodInput) {
        meuFormulario.removeChild(existingMethodInput);
    }
});

/***
 * Salva o USUARIO
 * */
document.addEventListener('DOMContentLoaded', function() {
    let register = document.getElementById('register');
    if (register) {
        register.addEventListener('submit', function (event) {
            // Evita o envio padrão do formulário
            event.preventDefault();

            // Realize aqui suas verificações de validação
            const name = document.getElementById('name');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const password_confirmation = document.getElementById('password_confirmation');

            if (name.value.trim() === "") {
                name.focus();
                Swal.fire({
                    title: 'Atenção!',
                    text: 'O Nome deve ser informado!',
                    icon: 'info',
                    confirmButtonText: 'OK'
                })
                return;
            }

            if (email.value.trim() === "") {
                email.focus();
                Swal.fire({
                    title: 'Atenção!',
                    text: 'O Email deve ser informado!',
                    icon: 'info',
                    confirmButtonText: 'OK'
                })
                return;
            }

            if (password.value.trim() === "") {
                password.focus();
                Swal.fire({
                    title: 'Atenção!',
                    text: 'A senha deve ser informada! Mínimo de 8 caracteres',
                    icon: 'info',
                    confirmButtonText: 'OK'
                })
                return;
            }

           if (password_confirmation.value.trim() === "") {
                password_confirmation.focus();
                Swal.fire({
                    title: 'Atenção!',
                    text: 'A senha confirmação deve ser informada! Mínimo de 8 caracteres',
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
 * Editar o Usuário
 * */
document.querySelectorAll('.btn-editar-usuario').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();

        const rota = $(this).data('rota');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const meuFormulario = document.getElementById('register');

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
                console.log(response);

                if (response.success) {

                    // Preencher os campos do modal com os dados obtidos
                    document.getElementById('name').value = response.data.name;
                    document.getElementById('email').value = response.data.email;

                    // Defina a URL de ação
                    meuFormulario.action = $(this).data('rota-update');

                    // Crie um novo input _method apenas uma vez
                    const hiddenMethodInput = document.createElement('input');
                    hiddenMethodInput.type = 'hidden';
                    hiddenMethodInput.name = '_method';
                    hiddenMethodInput.value = 'PUT';
                    meuFormulario.appendChild(hiddenMethodInput);

                    // Abrir o modal
                    // $('#modalVideo').modal('show');
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

/**
 * ######################## AREA SOCIAL MEDIA #####################
 * Limpa o modal
 * */
$('.btnModalSocialMedia').on('click', function(e) {
    // Limpar o conteúdo do modal
    $("#titulo").val("");
    $("#link").val("");

    $('#socialmediaForm').attr('action', $(this).data('rota')); // Substitua 'url_padrao' pela URL original
    //para quando for nova notícia ajusta o form devido a ação de edição
    const meuFormulario = document.getElementById('socialmediaForm');
    // Remova o input _method existente, se houver caso tenha ocorrido edição, pois o form é o mesmo
    const existingMethodInput = meuFormulario.querySelector('input[name="_method"]');
    if (existingMethodInput) {
        meuFormulario.removeChild(existingMethodInput);
    }
});

/***
 * Salva o USUARIO
 * */
document.addEventListener('DOMContentLoaded', function() {
    let socialmediaForm = document.getElementById('socialmediaForm');
    if (socialmediaForm) {
        socialmediaForm.addEventListener('submit', function (event) {
            // Evita o envio padrão do formulário
            event.preventDefault();

            // Realize aqui suas verificações de validação
            const titulo = document.getElementById('titulo');
            const link = document.getElementById('link');
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

            if (link.value.trim() === "") {
                link.focus();
                Swal.fire({
                    title: 'Atenção!',
                    text: 'O Link deve ser informado!',
                    icon: 'info',
                    confirmButtonText: 'OK'
                })
                return;
            }

            if (slug.value.trim() === "") {
                slug.focus();
                Swal.fire({
                    title: 'Atenção!',
                    text: 'O slug deve seer preenchido',
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
 * Editar o Usuário
 * */
document.querySelectorAll('.btn-editar-socialmedia').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();

        const rota = $(this).data('rota');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const meuFormulario = document.getElementById('socialmediaForm');

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
                console.log(response);

                if (response.success) {

                    // Preencher os campos do modal com os dados obtidos
                    document.getElementById('titulo').value = response.data.titulo;
                    document.getElementById('link').value = response.data.link;
                    document.getElementById('slug').value = response.data.slug;

                    // Defina a URL de ação
                    meuFormulario.action = $(this).data('rota-update');

                    // Crie um novo input _method apenas uma vez
                    const hiddenMethodInput = document.createElement('input');
                    hiddenMethodInput.type = 'hidden';
                    hiddenMethodInput.name = '_method';
                    hiddenMethodInput.value = 'PUT';
                    meuFormulario.appendChild(hiddenMethodInput);

                    // Abrir o modal
                    // $('#modalVideo').modal('show');
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

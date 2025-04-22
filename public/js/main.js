(function ($) {
    "use strict";

    // Dropdown on mouse hover
    $(document).ready(function () {
        function toggleNavbarMethod() {
            if ($(window).width() > 992) {
                $('.navbar .dropdown').on('mouseover', function () {
                    $('.dropdown-toggle', this).trigger('click');
                }).on('mouseout', function () {
                    $('.dropdown-toggle', this).trigger('click').blur();
                });
            } else {
                $('.navbar .dropdown').off('mouseover').off('mouseout');
            }
        }
        toggleNavbarMethod();
        $(window).resize(toggleNavbarMethod);
    });


    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Main News carousel
    $(".main-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        items: 1,
        dots: true,
        loop: true,
        center: true,
    });


    // Tranding carousel
    $(".tranding-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 2000,
        items: 1,
        dots: false,
        loop: true,
        nav : true,
        navText : [
            '<i class="fa fa-angle-left"></i>',
            '<i class="fa fa-angle-right"></i>'
        ]
    });


    // Carousel item 1
    $(".carousel-item-1").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        items: 1,
        dots: false,
        loop: true,
        nav : true,
        navText : [
            '<i class="fa fa-angle-left" aria-hidden="true"></i>',
            '<i class="fa fa-angle-right" aria-hidden="true"></i>'
        ]
    });

    // Carousel item 2
    $(".carousel-item-2").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        margin: 30,
        dots: false,
        loop: true,
        nav : true,
        navText : [
            '<i class="fa fa-angle-left" aria-hidden="true"></i>',
            '<i class="fa fa-angle-right" aria-hidden="true"></i>'
        ],
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:2
            }
        }
    });


    // Carousel item 3
    $(".carousel-item-3").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        margin: 30,
        dots: false,
        loop: true,
        nav : true,
        navText : [
            '<i class="fa fa-angle-left" aria-hidden="true"></i>',
            '<i class="fa fa-angle-right" aria-hidden="true"></i>'
        ],
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:3
            }
        }
    });


    // Carousel item 4
    $(".carousel-item-4").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        margin: 30,
        dots: false,
        loop: true,
        nav : true,
        navText : [
            '<i class="fa fa-angle-left" aria-hidden="true"></i>',
            '<i class="fa fa-angle-right" aria-hidden="true"></i>'
        ],
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:3
            },
            1200:{
                items:4
            }
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
})(jQuery);


document.getElementById('cep').addEventListener('blur', function () {
    let cep = this.value.replace(/\D/g, '');
    const erroEl = document.getElementById('cep-erro');

    if (cep.length === 8) {
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (!data.erro) {
                    document.getElementById('endereco').value = data.logradouro;
                    document.getElementById('bairro').value = data.bairro;
                    document.getElementById('municipio').value = data.localidade;
                    document.getElementById('uf').value = data.uf;

                    erroEl.classList.add('d-none'); // Esconde a mensagem de erro
                } else {
                    erroEl.classList.remove('d-none'); // Mostra erro
                    document.getElementById('endereco').value = "";
                    document.getElementById('bairro').value = "";
                    document.getElementById('municipio').value = "";
                    document.getElementById('uf').value = "";
                }
            })
            .catch(() => {
                erroEl.textContent = "Erro ao consultar o CEP.";
                erroEl.classList.remove('d-none');
            });
    } else {
        erroEl.textContent = "CEP inválido. Digite 8 números.";
        erroEl.classList.remove('d-none');
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const cpfInput = document.getElementById("cpf");
    const cpfErro = document.getElementById("cpfErro");
    const btnEnviar = document.getElementById("btnEnviar");
    const autorizacao = document.getElementById("autorizacao_desconto");
    const form = document.querySelector("form");
    const textoBotao = document.getElementById("btnTexto");
    const spinnerBotao = document.getElementById("btnSpinner");

    // Função de validação combinada
    function validarFormulario() {
        const cpfValido = validarCPF(cpfInput.value);
        const autorizacaoMarcada = autorizacao.checked;

        if (!cpfValido) {
            cpfErro.classList.remove("d-none");
        } else {
            cpfErro.classList.add("d-none");
        }

        btnEnviar.disabled = !(cpfValido && autorizacaoMarcada);
    }

    // Valida ao sair do campo CPF
    if (cpfInput) {
        cpfInput.addEventListener("blur", validarFormulario);
    }

    // Valida ao clicar no checkbox
    if (autorizacao) {
        autorizacao.addEventListener("change", validarFormulario);
    }

    // Spinner no envio
    if (form) {
        form.addEventListener("submit", function () {
            btnEnviar.disabled = true;
            textoBotao.textContent = "Enviando...";
            spinnerBotao.classList.remove("d-none");
        });
    }

    // Função de validação de CPF
    function validarCPF(cpf) {
        cpf = cpf.replace(/[^\d]+/g, '');

        if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false;

        let soma = 0, resto;

        for (let i = 1; i <= 9; i++) {
            soma += parseInt(cpf.substring(i - 1, i)) * (11 - i);
        }

        resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) resto = 0;
        if (resto !== parseInt(cpf.charAt(9))) return false;

        soma = 0;
        for (let i = 1; i <= 10; i++) {
            soma += parseInt(cpf.substring(i - 1, i)) * (12 - i);
        }

        resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) resto = 0;

        return resto === parseInt(cpf.charAt(10));
    }
});


function preencherCamposTeste() {
    // Dados Pessoais
    document.querySelector('[name="nome"]').value = "João da Silva";
    document.querySelector('[name="cpf"]').value = "12345678901";
    document.querySelector('[name="email"]').value = "joao@teste.com";
    document.querySelector('[name="nacionalidade"]').value = "Brasileira";
    document.querySelector('[name="naturalidade"]').value = "São Paulo";
    document.querySelector('[name="sexo"]').value = "Masculino";
    document.querySelector('[name="data_nascimento"]').value = "1990-05-20";
    document.querySelector('[name="estado_civil"]').value = "Solteiro";
    document.querySelector('[name="telefone"]').value = "(11) 99999-0000";

    // Endereço (CEP consulta depois)
    document.querySelector('[name="cep"]').value = "01001000";
    document.querySelector('[name="endereco"]').value = "Praça da Sé";
    document.querySelector('[name="bairro"]').value = "Sé";
    document.querySelector('[name="municipio"]').value = "São Paulo";
    document.querySelector('[name="estado"]').value = "SP";

    // Identificação
    document.querySelector('[name="filiacao"]').value = "Maria de Souza";
    document.querySelector('[name="identidade"]').value = "12345678";
    document.querySelector('[name="orgao_emissor"]').value = "SSP";

    // Funcionais
    document.querySelector('[name="cargo"]').value = "Agente de Polícia";
    document.querySelector('[name="data_admissao"]').value = "2010-02-15";
    document.querySelector('[name="lotacao"]').value = "Delegacia Central";
    document.querySelector('[name="matricula"]').value = "12345";
    document.querySelector('[name="id_funcional"]').value = "FUNC123";
        document.querySelector('[name="aposentado"]').value = "Não";

    // Beneficiários
    document.querySelector('[name="beneficiarios[]"][value="conjuge"]').checked = true;
    document.querySelector('[name="beneficiarios[]"][value="filho"]').checked = true;


    document.querySelector('[name="data_aposentadoria"]').value = "2025-04-22";

    // Campos visuais com delay se quiser esperar DOM carregar
    setTimeout(() => {
        document.getElementById('cep').dispatchEvent(new Event('blur'));
    }, 300);
}


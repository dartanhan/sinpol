document.addEventListener("DOMContentLoaded", function () {
    const cpf = document.getElementById('cpf');
    const telefone = document.getElementById('telefone');
    const cep = document.getElementById('cep');

    if (cpf) {
        IMask(cpf, { mask: '000.000.000-00' });
    }

    if (telefone) {
        IMask(telefone, {
            mask: [
                { mask: '(00) 0000-0000' },
                { mask: '(00) 00000-0000' }
            ]
        });
    }

    if (cep) {
        IMask(cep, { mask: '00000-000' });
    }
});

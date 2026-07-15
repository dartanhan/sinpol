document.addEventListener('DOMContentLoaded', function () {
    // Excluir post com SweetAlert2
    document.querySelectorAll('.btn-excluir-secao').forEach(function (element) {
        element.addEventListener('click', function () {
            const rota = this.getAttribute('data-rota');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            Swal.fire({
                title: 'Tem certeza?',
                text: "Deseja realmente excluir este conteúdo?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Excluindo...',
                        html: 'Por favor, aguarde.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });

                    const originalHtml = element.innerHTML;
                    element.disabled = true;
                    element.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

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
                                title: 'Excluído!',
                                text: data.message || 'Excluído com sucesso.',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            element.disabled = false;
                            element.innerHTML = originalHtml;
                            Swal.fire('Erro!', data.message || 'Erro ao excluir.', 'error');
                        }
                    })
                    .catch(error => {
                        element.disabled = false;
                        element.innerHTML = originalHtml;
                        Swal.fire('Erro!', 'Erro ao excluir.', 'error');
                    });
                }
            });
        });
    });

    // Alterar status com SweetAlert2
    document.querySelectorAll('.statusSwitch').forEach(function (element) {
        element.addEventListener('click', function () {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const rota = this.getAttribute('data-rota');
            const id = this.getAttribute('data-id');
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
                        timer: 1000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        title: 'Erro!',
                        icon: 'error',
                        html: data.message,
                        showConfirmButton: true
                    });
                }
            })
            .catch(error => Swal.fire({
                title: 'Erro!',
                icon: 'error',
                html: error.message || error,
                showConfirmButton: true
            }));
        });
    });
});

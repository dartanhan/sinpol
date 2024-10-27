/**
 * Arquivo é usado na tela SITE de convenções
 * */
$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    /**
     * Initiate Datatables
     */

    let table = new DataTable('#dataTableConvencao',
        {
            responsive: true,
            searching: false, // Desabilita a funcionalidade de pesquisa
            lengthChange: false, // Desabilita o seletor de resultados por página
            language: {
                "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "_MENU_ resultados por página",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisar",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                },
                "select": {
                    "rows": {
                        "_": "Selecionado %d linhas",
                        "0": "Nenhuma linha selecionada",
                        "1": "Selecionado 1 linha"
                    }
                }
            },
            "order": [[0, "asc"]],
            "columnDefs": [
                {
                    "targets": [0,3],
                    "visible": false,
                    "searchable": false
                }
            ]
    });
});

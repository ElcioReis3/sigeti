$(document).ready(function () {
    if ($('#table1').length > 0 && $('#table1 tbody tr').length > 0 && $('#table1 tbody td[colspan]').length === 0) {
        $('#table1').DataTable({
            order: [],
            columnDefs: [
                {orderable: false, targets: -1}
            ],
            language: {
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_ registros",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoEmpty: "Mostrando 0 a 0 de 0 registros",
                infoFiltered: "(filtrado de _MAX_ registros no total)",
                zeroRecords: "Nenhum registro encontrado",
                paginate: {
                    first: "Primeiro",
                    last: "Último",
                    next: "Próximo",
                    previous: "Anterior"
                }
            }
        });
    }
});
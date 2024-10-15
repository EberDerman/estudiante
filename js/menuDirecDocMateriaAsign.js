$('.AllDataTables').DataTable({
    "columnDefs": [
        { "visible": false, "targets": 0 }
    ],
    "order": [[0, 'asc']],
    "drawCallback": function (settings) {
        var api = this.api();
        var rows = api.rows({ page: 'current' }).nodes();
        var last = null;

        api.column(0, { page: 'current' }).data().each(function (group, i) {
            if (last !== group) {
                $(rows).eq(i).before(
                    '<tr class="group"><td colspan="4" style= "font-weight: bold">' + group + '</td></tr>'
                );
                last = group;
            }
        });
    },
    language: {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty": "Mostrando 0 al 0 de un total de 0 registros",
        "sInfoFiltered": "",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    },
    "pageLength": 12
});

function asignarMateria(idDoc, id_Materia, nombreDoc, apellidoDoc, materia, nombreTec) {
    if (confirm(`¿Desea asignar la materia ${materia} de la carrera ${nombreTec} al docente ${nombreDoc} ${apellidoDoc}`)) {
        $.post('menuDirecDocMateriaAsignDB.php', {
            idDoc: idDoc,
            id_Materia: id_Materia
        })
            .done(function (response) {
                alert(response);
                window.location.href = `menuDirecDocMateria.php?idDoc=${idDoc}&nombreDoc=${nombreDoc}&apellidoDoc=${apellidoDoc}`;
            })
            .fail(function () {
                alert('Error al asignar la materia.');
            });
    }
    return;
}
<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sitmdm";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta para obtener tecnicaturas y materias
$sql = "
  SELECT 
    t.id_Tecnicatura, 
    t.nombreTec AS tecnicatura_nombre, 
    m.id_Materia, 
    m.Materia AS materia_nombre,
    f.fecha1,
    f.fecha2
  FROM 
    tecnicaturas t 
  LEFT JOIN 
    materias m ON m.idTec = t.id_Tecnicatura 
  LEFT JOIN 
    fechas_materias f ON f.id_Tecnicatura = t.id_Tecnicatura AND f.id_Materia = m.id_Materia
  ORDER BY 
    t.nombreTec, m.Materia;
";

$result = $conn->query($sql);
$materias = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $materias[$row['tecnicatura_nombre']][] = [
            'id_Materia' => $row['id_Materia'],
            'materia_nombre' => $row['materia_nombre'],
            'id_Tecnicatura' => $row['id_Tecnicatura'],
            'fecha1' => $row['fecha1'],
            'fecha2' => $row['fecha2']
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <title>Materias por Tecnicaturas</title>
    <style>
        .materias-table {
            display: none;
        }

        .message {
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <h1 class="text-center">Materias por Tecnicaturas</h1>

        <div id="filter" class="mb-4">
            <select id="tecnicaturaFilter" class="form-select">
                <option value="">Selecciona una tecnicatura</option>
                <?php foreach (array_keys($materias) as $tecnicatura): ?>
                    <option value="<?= htmlspecialchars($tecnicatura) ?>"><?= htmlspecialchars($tecnicatura) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div id="materiasList" class="mt-4">
            <?php foreach ($materias as $tecnicatura => $materias): ?>
                <div class="card mb-3" data-tecnicatura="<?= htmlspecialchars($tecnicatura) ?>">
                    <div class="card-header">
                        <a href="#" class="toggle-materias" data-toggle="false"><?= htmlspecialchars($tecnicatura) ?></a>
                    </div>
                    <div class="table-responsive materias-table">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Materia</th>
                                    <th>Fecha 1</th>
                                    <th>Fecha 2</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($materias as $materia): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($materia['materia_nombre']) ?></td>
                                        <td>
                                            <input type="text" class="form-control datepicker fecha1"
                                                data-tecnicatura="<?= htmlspecialchars($materia['id_Tecnicatura']) ?>"
                                                data-idmateria="<?= htmlspecialchars($materia['id_Materia']) ?>"
                                                value="<?= htmlspecialchars($materia['fecha1']) ?>" readonly>
                                            <button class="btn btn-danger remove-date mt-1">Eliminar</button>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control datepicker fecha2"
                                                data-tecnicatura="<?= htmlspecialchars($materia['id_Tecnicatura']) ?>"
                                                data-idmateria="<?= htmlspecialchars($materia['id_Materia']) ?>"
                                                value="<?= htmlspecialchars($materia['fecha2']) ?>" readonly>
                                            <button class="btn btn-danger remove-date mt-1">Eliminar</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="message" id="message"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            let ocupadasPorTecnicatura = {};

            $('.toggle-materias').click(function(e) {
                e.preventDefault();
                const materiasTable = $(this).closest('.card').find('.materias-table');
                materiasTable.slideToggle();
            });

            $('#tecnicaturaFilter').change(function() {
                const selectedTecnicatura = $(this).val();
                $('.card').each(function() {
                    const tecnicatura = $(this).data('tecnicatura');
                    if (selectedTecnicatura === "" || tecnicatura === selectedTecnicatura) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            $('.datepicker').each(function() {
                const idTecnicatura = $(this).data('tecnicatura');
                const idMateria = $(this).data('idmateria');

                $.get('consultar_fechas.php', {
                    id_Tecnicatura: idTecnicatura,
                    id_Materia: idMateria
                }, function(response) {
                    if (response.success) {
                        const ocupadas = response.fechas;
                        ocupadasPorTecnicatura[idTecnicatura] = ocupadas;

                        $(this).datepicker({
                            dateFormat: 'yy-mm-dd',
                            showOn: "focus",
                            beforeShowDay: function(date) {
                                const string = $.datepicker.formatDate('yy-mm-dd', date);
                                return [ocupadas.indexOf(string) === -1];
                            },
                            onSelect: function(selectedDate) {
                                const fechaCampo = $(this).hasClass('fecha1') ? 'fecha1' : 'fecha2';
                                const existingDate = $(this).val();

                                if (existingDate) {
                                    swal({
                                        title: "Confirmar cambio de fecha",
                                        text: "¿Deseas reemplazar la fecha actual?",
                                        type: "warning",
                                        showCancelButton: true,
                                        confirmButtonColor: "#DD6B55",
                                        confirmButtonText: "Sí, cambiar",
                                        cancelButtonText: "No, cancelar",
                                        closeOnConfirm: false
                                    }, function() {
                                        const idTecnicatura = $(this).data('tecnicatura');
                                        const idMateria = $(this).data('idmateria');

                                        $.post('eliminar_fecha.php', {
                                            id_Tecnicatura: idTecnicatura,
                                            id_Materia: idMateria,
                                            fecha: existingDate
                                        }, function(response) {
                                            if (response.success) {
                                                $(this).val(selectedDate).prop('readonly', true);

                                                $.post('guardar_fecha.php', {
                                                    id_Tecnicatura: idTecnicatura,
                                                    id_Materia: idMateria,
                                                    fecha: selectedDate,
                                                    fechaCampo: fechaCampo
                                                }, function(response) {
                                                    $('#message').html(''); // Limpiar el mensaje anterior
                                                    if (response.success) {
                                                        $('#message').html('<div class="alert alert-success">Fecha guardada con éxito</div>');
                                                    } else {
                                                        $('#message').html('<div class="alert alert-danger">Error al guardar la fecha: ' + response.error + '</div>');
                                                    }
                                                }, 'json');

                                                swal("Cambio realizado", "La fecha ha sido cambiada.", "success");
                                            } else {
                                                $('#message').html('<div class="alert alert-danger">Error al eliminar la fecha: ' + response.error + '</div>');
                                                swal("Error", "No se pudo eliminar la fecha.", "error");
                                            }
                                        }.bind(this), 'json');
                                    }.bind(this));
                                } else {
                                    $(this).val(selectedDate).prop('readonly', true);

                                    $.post('guardar_fecha.php', {
                                        id_Tecnicatura: idTecnicatura,
                                        id_Materia: idMateria,
                                        fecha: selectedDate,
                                        fechaCampo: fechaCampo
                                    }, function(response) {
                                        $('#message').html(''); // Limpiar el mensaje anterior
                                        if (response.success) {
                                            $('#message').html('<div class="alert alert-success">Fecha guardada con éxito</div>');
                                        } else {
                                            $('#message').html('<div class="alert alert-danger">Error al guardar la fecha: ' + response.error + '</div>');
                                        }
                                    }, 'json');
                                }
                            }
                        });
                    }
                }.bind(this), 'json');
            });

            $(document).on('click', '.remove-date', function() {
                const dateInput = $(this).closest('td').find('.datepicker');
                const selectedDate = dateInput.val();
                const idTecnicatura = dateInput.data('tecnicatura');
                const idMateria = dateInput.data('idmateria');

                if (selectedDate) {
                    swal({
                        title: "¿Estás seguro?",
                        text: "¿Deseas eliminar esta fecha?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Sí, eliminar",
                        cancelButtonText: "No, cancelar",
                        closeOnConfirm: false
                    }, function() {
                        $.post('eliminar_fecha.php', {
                            id_Tecnicatura: idTecnicatura,
                            id_Materia: idMateria,
                            fecha: selectedDate
                        }, function(response) {
                            if (response.success) {
                                dateInput.val('').prop('readonly', true);
                                $(this).hide();
                                $('#message').html(''); // Limpiar el mensaje anterior
                                $('#message').html('<div class="alert alert-success">Fecha eliminada con éxito</div>');
                                ocupadasPorTecnicatura[idTecnicatura] = ocupadasPorTecnicatura[idTecnicatura].filter(date => date !== selectedDate);
                                swal("Eliminado", "La fecha ha sido eliminada.", "success");
                            } else {
                                $('#message').html('<div class="alert alert-danger">Error al eliminar la fecha: ' + response.error + '</div>');
                                swal("Error", "No se pudo eliminar la fecha.", "error");
                            }
                        }.bind(this), 'json');
                    });
                }
            });
        });
    </script>

</body>

</html>
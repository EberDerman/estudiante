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
            'fecha1' => $row['fecha1'], // Agregar fecha1
            'fecha2' => $row['fecha2']  // Agregar fecha2
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
    <title>Materias por Tecnicaturas</title>
    <style>
        .materias-table {
            display: none;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <h1 class="text-center">Materias por Tecnicaturas</h1>
        <div id="materiasList" class="mt-4">
            <?php foreach ($materias as $tecnicatura => $materias): ?>
                <div class="card mb-3">
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
                                            <button class="btn btn-primary change-date" style="display:none;">Cambiar</button>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control datepicker fecha2"
                                                data-tecnicatura="<?= htmlspecialchars($materia['id_Tecnicatura']) ?>"
                                                data-idmateria="<?= htmlspecialchars($materia['id_Materia']) ?>"
                                                value="<?= htmlspecialchars($materia['fecha2']) ?>" readonly>
                                            <button class="btn btn-primary change-date" style="display:none;">Cambiar</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            let ocupadasPorTecnicatura = {}; // Objeto para almacenar fechas ocupadas por cada tecnicatura

            $('.toggle-materias').click(function(e) {
                e.preventDefault();
                const materiasTable = $(this).closest('.card').find('.materias-table');
                materiasTable.slideToggle();
            });

            $('.datepicker').each(function() {
                const idTecnicatura = $(this).data('tecnicatura');
                const idMateria = $(this).data('idmateria');

                // Consultar fechas ocupadas
                $.get('consultar_fechas.php', {
                    id_Tecnicatura: idTecnicatura,
                    id_Materia: idMateria
                }, function(response) {
                    if (response.success) {
                        const ocupadas = response.fechas;
                        ocupadasPorTecnicatura[idTecnicatura] = ocupadas; // Guardar fechas ocupadas

                        $(this).datepicker({
                            dateFormat: 'yy-mm-dd',
                            showOn: "focus",
                            beforeShowDay: function(date) {
                                const string = $.datepicker.formatDate('yy-mm-dd', date);
                                return [ocupadas.indexOf(string) === -1]; // Deshabilita fechas ya seleccionadas
                            },
                            onSelect: function(selectedDate) {
                                const fechaCampo = $(this).hasClass('fecha1') ? 'fecha1' : 'fecha2';

                                $(this).val(selectedDate);
                                $(this).prop('readonly', true);
                                $(this).next('.change-date').show();

                                // Agregar la fecha ocupada al registro
                                if (!ocupadasPorTecnicatura[idTecnicatura].includes(selectedDate)) {
                                    ocupadasPorTecnicatura[idTecnicatura].push(selectedDate);
                                }

                                // Actualizar otros datepickers de la misma tecnicatura
                                $('.datepicker[data-tecnicatura="' + idTecnicatura + '"]').each(function() {
                                    $(this).datepicker('option', 'beforeShowDay', function(date) {
                                        const string = $.datepicker.formatDate('yy-mm-dd', date);
                                        return [ocupadasPorTecnicatura[idTecnicatura].indexOf(string) === -1]; // Deshabilita fechas ocupadas
                                    });
                                });

                                // Guardar fecha en la base de datos
                                $.post('guardar_fecha.php', {
                                    id_Tecnicatura: idTecnicatura,
                                    id_Materia: idMateria,
                                    fecha: selectedDate,
                                    fechaCampo: fechaCampo
                                }, function(response) {
                                    if (response.success) {
                                        console.log('Fecha guardada con éxito');
                                    } else {
                                        console.error('Error al guardar la fecha:', response.error);
                                    }
                                }, 'json');
                            }
                        });
                    }
                }.bind(this), 'json');
            });

            $(document).on('click', '.change-date', function() {
                const dateInput = $(this).closest('td').find('.datepicker');
                dateInput.prop('readonly', false).datepicker('show');
                $(this).hide();
            });
        });
    </script>
</body>

</html>
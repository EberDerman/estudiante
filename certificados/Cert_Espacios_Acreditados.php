<?php
include("../sesion.php");
requireAuth();
// Incluir el archivo de conexión
include '../sql/conexion.php';

$id_estudiante = getIdEstudiante();
$id_tecnicatura = null; // Inicializa la variable

// Query para obtener el id_Tecnicatura del estudiante
$sql_tecnicatura = "
    SELECT id_Tecnicatura 
    FROM estudiante_tecnicatura 
    WHERE id_estudiante = $id_estudiante
";

// Ejecutar la consulta para obtener id_Tecnicatura
if ($resultado_tecnicatura = $mysqli->query($sql_tecnicatura)) {
    if ($fila_tecnicatura = $resultado_tecnicatura->fetch_assoc()) {
        // Almacenar el resultado en la variable
        $id_tecnicatura = $fila_tecnicatura['id_Tecnicatura'];
    }
    $resultado_tecnicatura->free();
} else {
    echo "Error en la consulta de tecnicatura: " . $mysqli->error;
}

// Resto del código
// Variables para almacenar los resultados
$nombre = '';
$apellido = '';
$dni = '';
$tecnicatura = '';
$resolucion = '';
$resultados = array(); // Array para almacenar las materias y calificaciones

// Query para obtener los datos del estudiante, materias, tecnicatura y finales
$sql = "
    SELECT 
        e.nombre,
        e.apellido,
        e.dni_numero,
        m.AnioCursada AS AnioCurso,
        m.Materia,
        f.fecha,
        f.nota,
        t.nombreTec AS tecnicatura,
        t.Resolucion AS resolucion
    FROM 
        estudiantes e
    JOIN 
        estudiante_tecnicatura et ON e.id_estudiante = et.id_estudiante
    JOIN 
        materias m ON et.id_Tecnicatura = m.IdTec
    JOIN 
        (
            SELECT 
                f1.id_estudiante,
                f1.id_tecnicatura,
                f1.id_materia,
                f1.fecha,
                f1.nota
            FROM 
                finales f1
            JOIN 
                (
                SELECT 
                    id_estudiante, 
                    id_tecnicatura, 
                    id_materia, 
                    MAX(fecha) AS max_fecha
                FROM 
                    finales
                GROUP BY 
                    id_estudiante, 
                    id_tecnicatura, 
                    id_materia
                ) f2 ON f1.id_estudiante = f2.id_estudiante 
                AND f1.id_tecnicatura = f2.id_tecnicatura 
                AND f1.id_materia = f2.id_materia 
                AND f1.fecha = f2.max_fecha
        ) f ON f.id_estudiante = e.id_estudiante 
          AND f.id_tecnicatura = m.IdTec 
          AND f.id_materia = m.id_Materia
    JOIN
        tecnicaturas t ON t.id_Tecnicatura = et.id_Tecnicatura
    WHERE 
        e.id_estudiante = $id_estudiante AND et.id_Tecnicatura = $id_tecnicatura
    ORDER BY 
        m.AnioCursada
";


// Ejecutar la consulta
if ($resultado = $mysqli->query($sql)) {
    // Si hay resultados
    while ($fila = $resultado->fetch_assoc()) {
        // Llenamos las variables con el primer resultado
        if (empty($nombre)) {
            $nombre = $fila['nombre'];
            $apellido = $fila['apellido'];
            $dni = $fila['dni_numero'];
            $tecnicatura = $fila['tecnicatura']; // Nombre de la tecnicatura
            $resolucion = $fila['resolucion'];   // Resolución de la tecnicatura
        }

        // Convertir nota a texto
        $notaTexto = convertirNumeroATexto($fila['nota']);

        // Almacenar en el array de resultados
        $resultados[] = array(
            'AnioCurso' => $fila['AnioCurso'],
            'Materia' => $fila['Materia'],
            'fecha' => $fila['fecha'],
            'nota' => $fila['nota'],
            'notaTexto' => $notaTexto
        );
    }

    $resultado->free();
} else {
    echo "Error en la consulta: " . $mysqli->error;
}

// Función para convertir la nota a texto
function convertirNumeroATexto($nota)
{
    // Array de números para la parte entera
    $numeros = array(
        'cero',
        'uno',
        'dos',
        'tres',
        'cuatro',
        'cinco',
        'seis',
        'siete',
        'ocho',
        'nueve',
        'diez',
        'once',
        'doce',
        'trece',
        'catorce',
        'quince',
        'dieciséis',
        'diecisiete',
        'dieciocho',
        'diecinueve'
    );
    // Array de decenas
    $decenas = array(
        2 => 'veinte',
        3 => 'treinta',
        4 => 'cuarenta',
        5 => 'cincuenta',
        6 => 'sesenta',
        7 => 'setenta',
        8 => 'ochenta',
        9 => 'noventa'
    );

    // Dividimos el número en entero y decimal
    $partes = explode('.', $nota);
    $entero = intval($partes[0]);  // Parte entera
    $decimal = isset($partes[1]) ? str_pad($partes[1], 2, '0', STR_PAD_RIGHT) : '00'; // Parte decimal con dos dígitos

    // Conversión de la parte entera
    $texto = isset($numeros[$entero]) ? $numeros[$entero] : 'número no soportado';

    // Procesamos la parte decimal
    if ($decimal === '00') {
        // Si la parte decimal es 00, solo regresamos el número entero
        return $texto;
    }

    // Convertimos la parte decimal
    $decena = intval($decimal[0]); // Primer dígito decimal
    $unidad = intval($decimal[1]); // Segundo dígito decimal

    if ($decena === 0) {
        // Si es algo como 0X (ej: 01, 02), añadimos "con" + número
        $texto .= ' con ' . $numeros[$unidad];
    } elseif ($decena === 1) {
        // Si es de 10 a 19
        $texto .= ' con ' . $numeros[10 + $unidad];
    } elseif ($decena >= 2) {
        // Si es 20 a 99
        $texto .= ' con ' . $decenas[$decena];
        if ($unidad > 0) {
            // Si hay una unidad, añadimos "y" + unidad (ej: veintiuno, treinta y dos)
            $texto .= ($decena == 2 && $unidad == 1 ? 'i' : ' y ') . $numeros[$unidad];
        }
    }

    return $texto;
}
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/sitmdm/css/bootstrap.css">
    <title>Certificado De Espacios Acreditados</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgEEH2u-pWXkNnvQX6Mg4Hw8iI-aTkz50ywz_AZOxn0NvFfp9ZX_aCt8pFQhd84dQ3pKpw1J4CWvTUPCag5LraitxjS47dEPODzxeN_ehOF6xsmRyq6DDYFIyG32VftRaijhL-diR2P74H3/s1600/logo%252520des.jpg" class="logo">
            <div class="contenttitle">
                <p>_____________________________</p>
                <p><b>DIRECCION DE EDUCACION SUPERIOR <br>
                        INSTITUTO SUPERIOR DE
                        <br>FORMACION TECNICA N°135</b> </p>
            </div>
            <h2>Certificado De Espacios Acreditados</h2>
        </div>
        <div class="content">
            <h3>ESTABLECIMIENTO: INSTITUTO SUPERIOR DE FORMACIÓN TECNICA Nº 135 (BA)</h3>
            <p>Conste que <?php echo ($nombre . ' ' . $apellido); ?>, DNI N° <?php echo ($dni); ?> ha aprobado los Espacios curriculares, con las respectivas calificaciones que abajo se registran, correspondientes a la Carrera <strong><?php echo ($tecnicatura); ?></strong>, Resolución Nº <?php echo ($resolucion); ?>.</p>
        </div>

        <div class="datatable">
            <div class="tabla-contenedor">
                <table id="tablaDatos" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>CURSO</th>
                            <th>ESPACIO CURRICULAR</th>
                            <th>FECHA DE APROBACIÓN</th>
                            <th>CALIFICACIÓN En Nros</th>
                            <th>CALIFICACIÓN En Letras</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultados as $fila): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($fila['AnioCurso']); ?></td>
                                <td><?php echo htmlspecialchars($fila['Materia']); ?></td>
                                <td><?php echo htmlspecialchars($fila['fecha']); ?></td>
                                <td><?php echo htmlspecialchars($fila['nota']); ?></td>
                                <td><?php echo htmlspecialchars($fila['notaTexto']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="signature">
            <p>.......................................................</p>
            <p>Firma y sello aclaratorio del Director/a Secretario/a</p>
        </div>
        <div class="footer">
            <p>Sello del establecimiento</p>
        </div>
    </div>
</body>

</html>
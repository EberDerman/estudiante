<?php
include("../sesion.php");
requireAuth();
ob_start();
require_once '../dompdf/vendor/autoload.php'; // Asegúrate de que el path es correcto

use Dompdf\Dompdf;
use Dompdf\Options;

// Configuración de Dompdf
$options = new Options();
$options->set('defaultFont', 'Courier');
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
include("../sql/conexion.php"); // Cambia la ruta de inclusión a la correcta

date_default_timezone_set('America/Argentina/Buenos_Aires');

// Definir el id del estudiante
$id_estudiante = getIdEstudiante();
$id_tecnicatura = null; // Inicializamos la variable para el id de la tecnicatura

try {
    // Query para obtener el id_Tecnicatura
    $sqlTecnicatura = "SELECT id_Tecnicatura FROM estudiantes WHERE id_usuario = :id_estudiante";
    $stmtTec = $conexiones->prepare($sqlTecnicatura);
    
    // Vincular el parámetro
    $stmtTec->bindParam(':id_estudiante', $id_estudiante, PDO::PARAM_INT);
    
    // Ejecutar la consulta
    $stmtTec->execute();
    
    // Obtener el resultado
    if ($stmtTec->rowCount() > 0) {
        $id_tecnicatura = $stmtTec->fetchColumn(); // Almacena solo el id_Tecnicatura
    } else {
        echo "No se encontró la tecnicatura para el estudiante con ID $id_estudiante.";
    }
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}

// Resto del código...

try {
    // Preparar la consulta
    $sql = "SELECT nombre, apellido, dni_numero AS dni FROM estudiantes WHERE id_estudiante = :id_estudiante";
    $stmt = $conexiones->prepare($sql);

    // Vincular el parámetro
    $stmt->bindParam(':id_estudiante', $id_estudiante, PDO::PARAM_INT);

    // Ejecutar la consulta
    $stmt->execute();

    // Verificar si se obtuvo un resultado
    if ($stmt->rowCount() > 0) {
        // Obtener los datos del estudiante
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $nombre = $row['nombre'];
        $apellido = $row['apellido'];
        $dni = $row['dni'];
    } else {
        echo "No se encontraron resultados para el estudiante con ID $id_estudiante.";
    }
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constancia del porcentaje de perspectivas</title>
    <link rel="stylesheet" href="/sitmdm/css/bootstrap.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgEEH2u-pWXkNnvQX6Mg4Hw8iI-aTkz50ywz_AZOxn0NvFfp9ZX_aCt8pFQhd84dQ3pKpw1J4CWvTUPCag5LraitxjS47dEPODzxeN_ehOF6xsmRyq6DDYFIyG32VftRaijhL-diR2P74H3/s320/logo%252520des.jpg" alt="Logo de la Institución" class="logo">
            <div class="contenttitle">
                <p><b>DIRECCION DE EDUCACION SUPERIOR <br>
                        INSTITUTO SUPERIOR DE <br>FORMACION TECNICA N°135</b> </p>
            </div>
            <br>
            <h3>CONSTANCIA DEL PORCENTAJE DE PERSPECTIVAS</h3>
        </div>
        <center>
            <h4>ESPACIOS O AREAS APROBADAS</h4>
        </center>
        <div class="content">
            <p>Se deja constancia de que <strong><?php echo htmlspecialchars($nombre); ?> <?php echo htmlspecialchars($apellido); ?></strong> DNI: <?php echo htmlspecialchars($dni); ?> es alumna/o de este <strong>INSTITUTO SUPERIOR DE FORMACION TECNICA N°135</strong>, dispuesta por la resolución <strong>N° 5847/19</strong> de la DGCyE ha rendido y aprobado hasta el día de la fecha el siguiente número de asignaturas.</p>
        </div>

        <?php
        // Query para obtener los datos
        $sql = "
        SELECT 
            CONCAT('Curso ', m.AnioCursada) AS Curso,               
            COUNT(m.id_Materia) AS AsignaturasPlanEstudio,         
            SUM(CASE WHEN f.nota >= 4 THEN 1 ELSE 0 END) AS AsignaturasRendidas,
            (COUNT(m.id_Materia) - SUM(CASE WHEN f.nota >= 4 THEN 1 ELSE 0 END)) AS FaltaRendir
        FROM 
            materias m
        LEFT JOIN 
            finales f ON m.id_Materia = f.id_materia 
            AND f.id_estudiante = :id_estudiante
            AND f.id_tecnicatura = $id_tecnicatura
        WHERE 
            m.IdTec = 1              
        GROUP BY 
            m.AnioCursada                                          
        ORDER BY 
            m.AnioCursada
        ";

        try {
            // Prepara la consulta y ejecuta
            $stmt = $conexiones->prepare($sql);
            $stmt->bindParam(':id_estudiante', $id_estudiante, PDO::PARAM_INT);
            $stmt->execute();

            // Obtén todos los resultados
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Comprueba si hay resultados
            if (count($resultados) > 0) {
                echo '<table>';
                echo '<thead>
                <tr>
                    <th>Curso</th>
                    <th>Asignaturas plan de estudio</th>
                    <th>Asignaturas rendidas</th>
                    <th>Falta rendir</th>
                </tr>
              </thead>';
                echo '<tbody>';

                // Recorre los resultados y genera las filas
                foreach ($resultados as $row) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row["Curso"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["AsignaturasPlanEstudio"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["AsignaturasRendidas"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["FaltaRendir"]) . '</td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
            } else {
                echo "No se encontraron resultados.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        // Query para obtener el nombre de la tecnicatura y la cantidad de años (cursos)
        $sqlTecnicatura = "
        SELECT 
            t.nombreTec AS NombreTecnicatura, 
            COUNT(DISTINCT m.AnioCursada) AS CantidadAnios
        FROM 
            tecnicaturas t
        JOIN 
            materias m ON t.id_Tecnicatura = m.IdTec
        WHERE 
            t.id_Tecnicatura =  $id_tecnicatura  
        ";

        // Prepara y ejecuta la consulta
        try {
            $stmtTec = $conexiones->prepare($sqlTecnicatura);
            $stmtTec->execute();
            $tecnicaturaInfo = $stmtTec->fetch(PDO::FETCH_ASSOC);

            if ($tecnicaturaInfo) {
                // Variables con los datos obtenidos
                $nombreTecnicatura = $tecnicaturaInfo['NombreTecnicatura'];
                $cantidadAnios = $tecnicaturaInfo['CantidadAnios'];
            } else {
                // Valores por defecto en caso de no encontrar información
                $nombreTecnicatura = 'Nombre no disponible';
                $cantidadAnios = 0;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        // Calcular el porcentaje de materias aprobadas
        $totalAsignaturas = 0;
        $totalRendidas = 0;

        foreach ($resultados as $row) {
            $totalAsignaturas += $row['AsignaturasPlanEstudio'];
            $totalRendidas += $row['AsignaturasRendidas'];
        }

        $porcentajeAprobadas = ($totalAsignaturas > 0) ? ($totalRendidas / $totalAsignaturas) * 100 : 0;
        $textoPorcentaje = ($porcentajeAprobadas > 0) ? round($porcentajeAprobadas, 2) . "%" : "No hay materias aprobadas.";

        ?>

        <br>
        <table>
            <tr>
                <td colspan="4">
                    Ingresante a <?php echo htmlspecialchars($nombreTecnicatura); ?> - PLAN DE ESTUDIO DE <?php echo htmlspecialchars($cantidadAnios); ?> AÑOS
                </td>
            </tr>
            <tr>
                <td>
                    PORCENTAJE DE MATERIAS APROBADAS: <span style="color: blue;"><?php echo $textoPorcentaje; ?></span>
                </td>
            </tr>
        </table>

        <br>

    </div>

    <div class="contentt">
        <?php
        // Obtener la fecha actual
        $dia = date("d"); // Obtener el día
        $mes = date("F"); // Obtener el mes en texto
        $anio = date("Y"); // Obtener el año

        // Crear un mensaje de fecha
        echo "<p style='text-align: center;'>Fecha: $dia de $mes de $anio</p>";
        ?>
    </div>

</body>

</html>

<?php
// Generar el PDF
$html = ob_get_clean();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("constancia_porcentaje_perspectivas.pdf", array("Attachment" => false));
exit(0);
?>

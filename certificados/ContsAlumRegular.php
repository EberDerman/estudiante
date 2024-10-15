<?php
include("../sesion.php");
requireAuth();
ob_start();
require_once '../dompdf/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Configuración de Dompdf
$options = new Options();
$options->set('defaultFont', 'Courier');
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
include("../sql/conexion.php");


$id_estudiante = getIdEstudiante();

// Inicializar variables
$nombre = '';
$apellido = '';
$dni = '';
$tecnicatura = '';
$fecha = date('Y-m-d'); // Fecha actual en formato Y-m-d

// Función para formatear la fecha
function formatoFecha($fecha) {
    // Convertir la fecha a un objeto DateTime
    $date = new DateTime($fecha);

    // Obtener el día, mes y año
    $dia = $date->format('j'); // Día sin ceros a la izquierda
    $mes = $date->format('n'); // Mes sin ceros a la izquierda
    $anio = $date->format('Y'); // Año completo

    // Array de nombres de los meses
    $meses = [
        1 => "enero",
        2 => "febrero",
        3 => "marzo",
        4 => "abril",
        5 => "mayo",
        6 => "junio",
        7 => "julio",
        8 => "agosto",
        9 => "septiembre",
        10 => "octubre",
        11 => "noviembre",
        12 => "diciembre"
    ];

    // Formatear la fecha
    return "$dia días del mes de " . $meses[$mes] . " del año $anio.";
}

// Formatear la fecha para usar en el documento
$fechaFormateada = formatoFecha($fecha);

// Consulta para obtener los datos del estudiante y la tecnicatura
$sql = "
    SELECT 
        e.nombre,
        e.apellido,
        e.dni_numero,
        t.nombreTec AS tecnicatura
    FROM 
        estudiantes e
    JOIN 
        estudiante_tecnicatura et ON e.id_estudiante = et.id_estudiante
    JOIN 
        tecnicaturas t ON t.id_Tecnicatura = et.id_Tecnicatura
    WHERE 
        e.id_estudiante = $id_estudiante
";

// Ejecutar la consulta
if ($resultado = $mysqli->query($sql)) {
    // Si hay resultados, obtener los datos
    if ($fila = $resultado->fetch_assoc()) {
        $nombre = $fila['nombre'];
        $apellido = $fila['apellido'];
        $dni = $fila['dni_numero'];
        $tecnicatura = $fila['tecnicatura'];
    }

    $resultado->free();
} else {
    echo "Error en la consulta: " . $mysqli->error;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <title>Constancia de Alumno Regular</title>
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
        <h2>Constancia de Alumno Regular</h2>
    </div>
    <div class="content">
        <p>Se deja constancia de que, a la fecha, el Sr <?php echo $nombre; ?> <?php echo $apellido; ?> con DNI N°: <?php echo $dni; ?>, es alumno
        regular del Instituto Superior de Formación Técnica N°135, de la especialidad <strong> <?php echo $tecnicatura; ?>.</strong>A pedido del interesado/a y para ser presentada
        ante quien corresponda, se extiende la presente en la ciudad de Saladillo a los <?php echo $fechaFormateada; ?>.</p>
    </div>
    <div class="signature">
        <p>.......................................................</p>
        <p>Firma y sello aclaratorio del Director/a Secretario/a</p>
    </div>
    <div class="footer">
        <p>Sello del establecimiento</p>
    </div>
</div>
<?php
// Captura el contenido del buffer
$html = ob_get_clean();

// Carga el HTML en Dompdf
$dompdf->loadHtml($html);

// Configura el tamaño y la orientación del papel
$dompdf->setPaper('A4', 'portrait');

// Renderiza el HTML como PDF
$dompdf->render();

// Envía el PDF al navegador
$dompdf->stream("Constancia_Alumno_Regular.pdf", array("Attachment" => false));
?>
</body>
</html>

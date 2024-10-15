<?php
// Iniciar la sesión
include("sesion.php");
requireAuth();

// Verificar si los datos están disponibles en la sesión
if (isset($_SESSION['username'])) {
    $usuario = $_SESSION['usuario'];
    $materia = $usuario['materia'];
    $fecha = $usuario['fecha'];
    // Aquí puedes usar $materia y $fecha como desees
} else {
    echo 'No se encontraron datos en la sesión.';
}



ob_start();

require_once 'dompdf/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Configuración de Dompdf
$options = new Options();
$options->set('defaultFont', 'Courier');
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

// Obtener el parámetro 'tipo' de la URL
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';

// Generar el contenido HTML con el valor del tipo
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Inscripción</title>
    <style>
        .header {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
        }

        .logo {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 100px;
            height: auto;
        }

        .contenttitle {
            text-align: right;
            font-size: 15px;
        }

        .header h2 {
            margin: 20px 0 10px 0;
        }

        .content {
            margin-bottom: 40px;
            text-align: justify;
        }

        .signatures {
            display: table;
            width: 100%;
            margin-top: 40px;
        }

        .signature,
        .signature-central {
            display: table-cell;
            text-align: center;
            vertical-align: bottom;
            width: 33%;
        }

        .footer {
            text-align: center;
        }

        @media (max-width: 600px) {
            .logo {
                position: static;
                display: block;
                margin: 0 auto 20px;
                width: 150px;
            }

            .contenttitle {
                text-align: center;
                font-size: 14px;
            }

            .signatures {
                display: block;
                margin-top: 20px;
            }

            .signature,
            .signature-central {
                display: block;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ7t1Aznz-fl0Qj_aWrYm7kKIssn3hfD9b7Gw&s" alt="Logo de la Institución" class="logo">
            <div class="contenttitle">
                <p>______________________________</p>
                <p><b>DIRECCIÓN DE EDUCACIÓN SUPERIOR<br>
                        INSTITUTO SUPERIOR DE<br>
                        FORMACIÓN TÉCNICA N°135</b></p>
            </div>
            <h2>Comprobante de Inscripción de Exámenes</h2>
        </div>
        <div class="content">
            <p>Se informa que el alumno _______________ de la carrera de _________________. Ha completado exitosamente su inscripción para para la <?php echo htmlspecialchars($fecha);?> fecha del examen de  <?php echo htmlspecialchars($materia);?>. A las _____ hs del día ___________.<br><center>¡Le deseamos mucho éxito en su evaluación!</center></p>
            <p>Tipo de inscripción: <?php echo htmlspecialchars($tipo); ?></p>
        </div>
    </div>
</body>
</html>
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
$dompdf->stream("Inscripcion_completa_a_Examenes.pdf", array("Attachment" => false));
?>




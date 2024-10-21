<?php
// Iniciar la sesión
include("../administrativo/sesion.php");
requireAuthEst();

// Verificar si se ha definido la constante
if (!defined('ACCESO_PERMITIDO')) {
    header("Location: ../administrativo/index.php");
    exit();
}


// Obtener los datos enviados por la solicitud POST
$materia = isset($_POST['materia']) ? $_POST['materia'] : '';
$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';

// Validar los datos recibidos
if (!empty($materia) && !empty($tipo)) {
    // Crear un array con los datos recibidos
    $datos = array(
        'materia' => $materia,
        'fecha' => $tipo
    );

    // Almacenar el array en la sesión
    $_SESSION['usuario'] = $datos;
}
?>

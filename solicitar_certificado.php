<?php
// archivo solicitar_certificado.php
include("sql/conexion.php"); // Incluye el archivo de conexión

// Recoger datos del request 
$tipoCertificado = $_POST['tipoCertificado'];
$id_estudiante = 1; // para pruebas.
$fechaSolicitud = date('Y-m-d');

// Preparar la consulta SQL
$sql = "INSERT INTO certificados (id_estudiante, FechaSolicitud, TipoCertificado, idEstado) VALUES (?, ?, ?, 1)";

if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param('iss', $id_estudiante, $fechaSolicitud, $tipoCertificado);
    
    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => $mysqli->error]);
}

// Cerrar la conexión
$mysqli->close();
?>

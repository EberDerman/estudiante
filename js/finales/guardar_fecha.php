<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sitmdm";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => $conn->connect_error]));
}

$id_Tecnicatura = $_POST['id_Tecnicatura'];
$id_Materia = $_POST['id_Materia'];
$fecha = $_POST['fecha'];
$fechaCampo = $_POST['fechaCampo'];

// Asegúrate de que fechaCampo solo contenga 'fecha1' o 'fecha2'
if (!in_array($fechaCampo, ['fecha1', 'fecha2'])) {
    die(json_encode(['success' => false, 'error' => 'Campo de fecha no válido']));
}

// Validar que la fecha no sea nula o vacía
if (empty($fecha) || $fecha === '0000-00-00') {
    die(json_encode(['success' => false, 'error' => 'Fecha no válida']));
}

// Validar formato de fecha
$dateTime = DateTime::createFromFormat('Y-m-d', $fecha);
if (!$dateTime || $dateTime->format('Y-m-d') !== $fecha) {
    die(json_encode(['success' => false, 'error' => 'Formato de fecha no válido']));
}

// Guardar la fecha en la tabla fechas_materias
$sql = "INSERT INTO fechas_materias (id_Tecnicatura, id_Materia, $fechaCampo) 
        VALUES (?, ?, ?) 
        ON DUPLICATE KEY UPDATE $fechaCampo = VALUES($fechaCampo)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $id_Tecnicatura, $id_Materia, $fecha);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>

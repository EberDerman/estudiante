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
    die(json_encode(['success' => false, 'error' => 'Conexión fallida: ' . $conn->connect_error]));
}

// Obtener datos del POST
$id_Tecnicatura = $_POST['id_Tecnicatura'];
$id_Materia = $_POST['id_Materia'];
$fecha = $_POST['fecha'];

// Preparar la consulta para reemplazar la fecha por NULL
$stmt = $conn->prepare("UPDATE fechas_materias SET fecha1 = CASE WHEN fecha1 = ? THEN NULL ELSE fecha1 END, 
                                                          fecha2 = CASE WHEN fecha2 = ? THEN NULL ELSE fecha2 END 
                         WHERE id_Tecnicatura = ? AND id_Materia = ?");
$stmt->bind_param("ssii", $fecha, $fecha, $id_Tecnicatura, $id_Materia);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>

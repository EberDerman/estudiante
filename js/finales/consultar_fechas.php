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

$id_Tecnicatura = $_GET['id_Tecnicatura'];

// Consultar todas las fechas ocupadas para la tecnicatura
$sql = "SELECT fecha1, fecha2 FROM fechas_materias WHERE id_Tecnicatura = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_Tecnicatura);
$stmt->execute();
$result = $stmt->get_result();

$fechas = [];
while ($row = $result->fetch_assoc()) {
    if ($row['fecha1']) $fechas[] = $row['fecha1'];
    if ($row['fecha2']) $fechas[] = $row['fecha2'];
}

$stmt->close();
$conn->close();

echo json_encode(['success' => true, 'fechas' => $fechas]);
?>

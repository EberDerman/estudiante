<?php
// Enable error reporting during development
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'sitmdm');

// Crear conexión
$conexion = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Datos del usuario

$codRol = 1; // Asumimos un rol de estudiante
$usuario = 'estudiante';
$contrasenia = password_hash('estudiante', PASSWORD_BCRYPT);

// Preparar la declaración
$stmt = $conexion->prepare("INSERT INTO usuarios (idUsuario, codRol, usuario, contrasenia) VALUES (?, ?, ?, ?)");

if ($stmt === false) {
    die("Error al preparar la consulta: " . $conexion->error);
}

// Vincular parámetros
$stmt->bind_param("iiss", $idUsuario, $codRol, $usuario, $contrasenia);

// Ejecutar la declaración
if ($stmt->execute()) {
    echo "Usuario creado correctamente.";
} else {
    echo "Error al crear el usuario: " . $stmt->error;
}

// Cerrar la declaración y la conexión
$stmt->close();
$conexion->close();
?>

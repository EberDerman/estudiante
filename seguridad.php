<?php
// Iniciar sesión si no se ha iniciado
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Conectar a la base de datos
$conexion = new mysqli('localhost', 'usuario', 'contraseña', 'basededatos');

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Verificar si el usuario está registrado
if (!isset($_SESSION['usuario'])) {
    // Redireccionar al login
    header("Location: login.php");
    exit;
}

// Obtener la página actual
$pagina = basename($_SERVER['PHP_SELF']);

// Obtener el código de rol del usuario
$codRol = $_SESSION['codRol'];

// Preparar y ejecutar la consulta para verificar permisos
$stmt = $conexion->prepare("SELECT pagina FROM permisos WHERE codRol=? AND pagina LIKE ?");
$stmt->bind_param("is", $codRol, $pagina);
$stmt->execute();
$result = $stmt->get_result();
$row_cnt = $result->num_rows;
$stmt->close();
$conexion->close();

// Verificar si el usuario tiene permiso para acceder a la página
if ($row_cnt == 0) {
    // No tiene acceso a la página
    echo "<script>alert('No posee acceso a esta sección.');";
    
    // Redireccionar según el rol
    switch ($codRol) {
        case 1:
            header("Location: inicioAdmin.php");
            break;
        case 2:
            header("Location: inicioCaps.php");
            break;
        case 3:
            header("Location: inicioDirec.php");
            break;
        case 4:
            header("Location: inicioPrecep.php");
            break;
        case 5:
            header("Location: inicioDocente.php");
            break;
        case 6:
            header("Location: inicioEstudiante.php");
            break;
        default:
            header("Location: login.php"); // Redireccionar a login si el rol no está definido
            break;
    }
    exit;
}

// Si el usuario tiene acceso, se puede incluir el menú correspondiente aquí
// Esto se puede manejar en cada página o en un archivo común de menú
?>

<?php
include("../administrativo/sesion.php");
requireAuthEst();
include("encabezado.php");
include("../administrativo/sql/conexion.php");

// Obtener el ID del estudiante desde la sesión (ajusta esta función si es necesario)
$idUsuario = getIdUsuario();

// Consulta para obtener el ID del estudiante
$sql = "SELECT id_estudiante FROM estudiantes WHERE idUsuario = ?";
$stmt = $conexiones->prepare($sql);
$stmt->execute([$idUsuario]);
$idEstudiante = $stmt->fetchColumn(); // Obtiene solo el ID del estudiante

// Verifica si se obtuvo el ID del estudiante
if ($idEstudiante === false) {
    // Manejar el error si no se encuentra el estudiante (opcional)
    echo "<script languaje= 'javascript'>";
    echo "window.location='index.php';";
    echo "alert ('El usuario o la clave no son validas')";
    echo "</script>";
}

// Manejo del formulario enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tecnicatura'])) {
    // Almacena el nuevo ID de tecnicatura y sobrescribe el anterior si existía
    $_SESSION['id_tecnicatura'] = $_POST['tecnicatura'];
    header("Location: inicioEstudiante.php");
    exit();
}


// Consulta para obtener las tecnicaturas asociadas al estudiante
$sql = "SELECT t.id_Tecnicatura, t.nombreTec 
        FROM tecnicaturas t 
        INNER JOIN estudiante_tecnicatura et ON t.id_Tecnicatura = et.id_Tecnicatura
        WHERE et.id_Estudiante = ?";
$stmt = $conexiones->prepare($sql);
$stmt->execute([$idEstudiante]);
$tecnicaturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Si el alumno tiene solo una tecnicatura, redirigir automáticamente
if (count($tecnicaturas) == 1) {
    $_SESSION['id_tecnicatura'] = $tecnicaturas[0]['id_Tecnicatura'];
    header("Location: inicioEstudiante.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<link rel="stylesheet" href="css/bootstrap.css">

<body class="hidden-sn mdb-skin">
    <style>
        img {
            max-width: 50%;
            max-height: 50%;
        }
    </style>

    <main>
        <div class="container-fluid">
            <?php include("menuEstudiante.php"); ?>
        </div>
    </main>

    <div class="container">
        <h2 class="text-center m-5">Selecciona tu Tecnicatura</h2>
        <div class="row" style="display: flex; justify-content: center;">
            <?php foreach ($tecnicaturas as $tecnicatura): ?>
                <div class="col-md-4">
                    <div class="card">
                        <h4 class="text-center pb-2 pt-2"><?php echo $tecnicatura['nombreTec']; ?></h4>
                        <form action="" method="POST"> <!-- Accede al mismo archivo -->
                            <input type="hidden" name="tecnicatura" value="<?php echo $tecnicatura['id_Tecnicatura']; ?>">
                            <div class="d-flex justify-content-center align-items-center">
                                <button type="submit" class="btn btn-primary">Acceder</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php include("pie.php"); ?>
    <script src="js/inicializacionSidear.js"></script>
    <script src="js/charts.js"></script>
</body>

</html>
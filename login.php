<?php
include("sesion.php"); // Incluir el archivo de sesión

// Usar la conexión existente de tu primer código
require_once("sql/conexion.php"); // Asegúrate de incluir el archivo que tiene la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificar la conexión con MySQLi
    if ($mysqli->connect_error) {
        die("Conexión fallida: " . $mysqli->connect_error);
    }

    // Preparar y ejecutar la consulta
    if ($stmt = $mysqli->prepare("SELECT id, password FROM users WHERE username = ?")) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $hashed_password);
            $stmt->fetch();

            // Verificar la contraseña
            if (password_verify($password, $hashed_password)) {
                $_SESSION['username'] = $username;
                $_SESSION['id_estudiante'] = $id; // Almacena el id_estudiante en la sesión
                header("Location: inicioEstudiante.php"); // Redirigir a la página de bienvenida
                exit(); // Para asegurarse de que el código no continúe ejecutándose
            } else {
                echo "Nombre de usuario o contraseña incorrectos.";
            }
        } else {
            echo "Nombre de usuario o contraseña incorrectos.";
        }

        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $mysqli->error;
    }

    // Cerrar la conexión si no la necesitas más
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>SITMDM</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Material Design Bootstrap -->
    <link rel="stylesheet" href="css/mdb.min.css">
    <!-- Custom styles -->
    <link rel="icon" type="image/png" href="img/favicon.png">
    <!-- SCRIPTS -->
    <!-- JQuery -->
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="js/mdb.min.js"></script>

    <script>
        $('.carousel.carousel-multi-item.v-2 .carousel-item').each(function() {
            var next = $(this).next();
            if (!next.length) {
                next = $(this).siblings(':first');
            }
            next.children(':first-child').clone().appendTo($(this));

            for (var i = 0; i < 4; i++) {
                next = next.next();
                if (!next.length) {
                    next = $(this).siblings(':first');
                }
                next.children(':first-child').clone().appendTo($(this));
            }
        });

        function moveLabel(element) {
            $(element).siblings('label').addClass('active');
        }
    </script>
    <style>
        html,
        body,
        header,
        .view {
            height: 100%;
        }

        @media (max-width: 740px) {
            html,
            body,
            header,
            .view {
                height: 1040px;
            }
        }

        @media (min-width: 800px) and (max-width: 850px) {
            html,
            body,
            header,
            .view {
                height: 600px;
            }
        }

        .pyproductos {
            padding-top: 90px;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body class="landing-page">
    <!-- Intro Section -->
    <section class="view">
        <div class="mask rgba-stylish-strong d-flex justify-content-center align-items-center" style="background-image: url(img/principal.jpg); background-repeat: no-repeat; background-size: cover">
            <div class="container">
                <div class="row">
                    <div class="col-xl-5 col-lg-6 col-md-10 col-sm-12 mx-auto mt-lg-5">
                        <!-- Form -->
                        <form action="login.php" method="POST">
                            <div class="card wow fadeInRight" data-wow-delay="0.3s">
                                <div class="card-body">
                                    <!-- Header -->
                                    <div class="text-center">
                                        <h3 class="white-text"><i class="fas fa-user white-text"></i> Ingreso Sistema</h3>
                                        <hr class="hr-light">
                                    </div>

                                    <!-- Body -->
                                    <div class="md-form">
                                        <i class="fas fa-user prefix white-text"></i>
                                        <input type="text" id="form3" autocomplete="off" onclick="moveLabel(this)" onkeyup='moveLabel(this)' class="form-control text-white" name="username">
                                        <label for="form3" class="text-white">Usuario</label>
                                    </div>

                                    <div class="md-form">
                                        <i class="fas fa-lock prefix white-text"></i>
                                        <input type="password" id="form4" autocomplete="off" onclick="moveLabel(this)" onkeyup="moveLabel(this)" class="form-control text-white" name="password">
                                        <label for="form4" class="text-white"><b>Contraseña</b></label>
                                    </div>

                                    <div class="text-center mt-4">
                                        <input type="submit" class="btn btn-light-blue btn-rounded" name="ingresar" value="Ingresar"></Input>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>

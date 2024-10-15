<?php
include("sesion.php");
requireAuth();
include("encabezado.php");
include("sql/conexion.php");
?>

<!DOCTYPE html>
<html lang="es">

<body class="hidden-sn mdb-skin">

  <!-- Main layout -->
  <main>

    <div class="container-fluid">
      <?php

            include ("menuEstudiante.php");

        ?>
      </div>
      <?php

include ("trayectoria.php");

?>
    </main>
    <!-- Main layout -->

    <?php
    include("pie.php");
    ?>
    <!-- Footer -->

    <!-- SCRIPTS -->


    <!-- Initializations -->
    
<script src="js/inicializacionSidear.js"></script>
<script src="js/charts.js"></script>

    </body>

    </html>

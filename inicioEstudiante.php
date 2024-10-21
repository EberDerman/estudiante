<?php
include("../administrativo/sesion.php");
checkAccessEstudiante([1, 6]);
include("encabezado.php");
include("../administrativo/sql/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">

<body class="hidden-sn mdb-skin" >

  <!-- Main layout -->
  <main>

    <div class="container-fluid">
      <?php

            include ("menuEstudiante.php");

        ?>
      </div>
      <?php

include ("paginaInicio.php");

?>
    </main>
    <!-- Main layout -->

    <?php
    include("pie.php");
    ?>
    <!-- Footer -->

    <!-- SCRIPTS -->

<script src="js/inicializacionSidear.js"></script>
<script src="js/charts.js"></script>

    </body>

    </html>

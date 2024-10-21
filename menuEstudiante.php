<?php
// Verificar si se ha definido la constante
if (!defined('ACCESO_PERMITIDO')) {
    header("Location: ../administrativo/index.php");
    exit();
}
?>

<!DOCTYPE html>
<header>
  <!-- Sidebar navigation -->
  <div id="slide-out" class="side-nav sn-bg-4">
    <ul class="custom-scrollbar">
      <li>
        <ul class="collapsible collapsible-accordion">
          <li>
            <a href="inicioEstudiante.php" class="waves-effect"><i class="fas fa-user"></i>Inicio</a>
          </li>
          <li>
            <a href="menuTrayectoria.php" class="waves-effect"><i class="fas fa-user"></i>Trayectoria</a>
          </li>
          <li>
            <a href="inscripPrueba.php" class="waves-effect"><i class="fas fa-user"></i>Inscripciones</a>
          </li>
          <li>
            <a href="certificados.php" class="waves-effect"><i class="fas fa-user"></i>Certificados</a>
          </li>
        </ul>
      </li>
    </ul>
    <div class="sidenav-bg mask-strong"></div>
  </div>
  <!-- Sidebar navigation -->

  <!-- Navbar -->
  <nav class="navbar fixed-top navbar-toggleable-md navbar-expand-lg scrolling-navbar double-nav">
    <!-- SideNav slide-out button -->
    <div class="float-left">
      <a href="#" data-activates="slide-out" class="button-collapse"><i class="fas fa-bars"></i></a>
    </div>
    <!-- Breadcrumb-->
    <div class="breadcrumb-dn mr-auto">
      <p>SITMDM</p>
    </div>
    <ul class="nav navbar-nav nav-flex-icons ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false"><i class="fas fa-user"></i>
          <?php echo $_SESSION['usuario']; ?>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="logout.php"><i class="fa fa-fw fa-power-off"></i>Logout</a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.Navbar -->
</header>
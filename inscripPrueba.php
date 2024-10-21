<?php
include("../administrativo/sesion.php");
requireAuthEst();
include("encabezado.php");
include("../administrativo/sql/conexion.php");
include("menuEstudiante.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Inscripción a Exámenes</title>
  <style>
    .centrarCol {
      text-align: center;
    }

    .hidden {
      display: none;
    }
  </style>
</head>

<body class="hidden-sn mdb-skin">
  <!-- Main layout -->
  <main>
    <div class="container-fluid">
      <!-- Incluye el menú aquí -->
    </div>
    <div class="container card text-center my-3 px-0">
      <h4 class="card-header primary-color-dark white-text">INSCRIPCIÓN A EXÁMENES</h4>
      <div class="card-body jus">
        <div class="table-responsive text-nowrap">
          <table class="table table-bordered table-hover table-striped display AllDataTables" cellspacing="0" width="100%">
            <thead>
              <tr>
                <td>Materias</td>
                <td class="centrarCol">Fechas</td>
              </tr>
            </thead>
            <tbody class="materias">
              <!-- Las filas se insertarán aquí -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>
  <!-- Main layout -->

  <?php include("pie.php"); ?>

  <!-- SCRIPTS -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Datos obtenidos de PHP
      <?php

      $id_usuario = getIdUsuario();
      $id_tecnicatura = getIdTecnicatura();

      $sql_estudiante = "SELECT id_estudiante FROM estudiantes WHERE idUsuario = ?";
      $stmt_estudiante = $conexion->prepare($sql_estudiante);
      $stmt_estudiante->bind_param("i", $id_usuario);
      $stmt_estudiante->execute();
      $stmt_estudiante->bind_result($id_estudiante);
      $stmt_estudiante->fetch();
      $stmt_estudiante->close();


      // Consulta SQL para filtrar por el ID del estudiante
      $sql = "SELECT m.id_Materia, m.Materia, m.AnioCursada, 
                     tm.nota_primer_cuatrimestre, tm.nota_segundo_cuatrimestre, 
                     tm.asistencia_horas, tm.horas_cursadas, 
                     fm.fecha1, fm.fecha2
              FROM estudiante_materia tm
              JOIN materias m ON tm.id_Materia = m.id_Materia
              JOIN estudiante_tecnicatura et ON et.id_estudiante = tm.id_estudiante
              LEFT JOIN fechas_materias fm ON fm.id_Materia = m.id_Materia
              WHERE tm.id_estudiante = ? AND et.id_Tecnicatura = ?";

      $stmt = $conexion->prepare($sql);
      $stmt->bind_param("ii", $id_estudiante, $id_tecnicatura);
      $stmt->execute();
      $resultado = $stmt->get_result();

      $datos = array();

      if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
          $datos[] = $row;
        }
      }

      $stmt->close();
      $conexion->close();

      // Convertir los datos a formato JSON para usarlos en JavaScript
      echo "const materias = " . json_encode($datos) . ";";
      ?>

      console.log('Datos de materias:', materias);

      function calcularPromedio(notas) {
        if (notas.length === 0) return 0;
        let suma = notas.reduce((a, b) => a + b, 0);
        return suma / notas.length;
      }

      function calcularPorcentajeAsistencia(horasCursada, horasAsistidas) {
        if (horasCursada === 0) return 0;
        return (horasAsistidas / horasCursada) * 100;
      }

      function regularidad(promedio, porcentajeAsistencia) {
        return promedio >= 4 && porcentajeAsistencia >= 60;
      }

      function generarHTML(materias) {
        return materias.map(materiaData => {
          // Convertir notas de cadenas a números
          const notaPrimerCuatrimestre = parseFloat(materiaData.nota_primer_cuatrimestre);
          const notaSegundoCuatrimestre = parseFloat(materiaData.nota_segundo_cuatrimestre);

          const notas = [notaPrimerCuatrimestre, notaSegundoCuatrimestre];
          const promedio = calcularPromedio(notas);
          const porcentajeAsistencia = calcularPorcentajeAsistencia(materiaData.horas_cursadas, materiaData.asistencia_horas);
          const esRegular = regularidad(promedio, porcentajeAsistencia);

          // Asignar fechas a los botones
          const fecha1 = materiaData.fecha1 ? new Date(materiaData.fecha1).toLocaleDateString('es-ES') : null;
          const fecha2 = materiaData.fecha2 ? new Date(materiaData.fecha2).toLocaleDateString('es-ES') : null;

          // Solo mostrar botones si la materia es regular
          if (esRegular) {
            return `
              <tr>
                <td class="campoMateria">${materiaData.Materia}</td>
                <td class="d-flex justify-content-center align-items-center">
                  <button type="button" class="btn btn-primary confirmButtonA me-2" ${!fecha1 ? 'disabled' : ''}>
                    ${fecha1 ? fecha1 : 'Fecha no cargada'}
                  </button>
                  <button type="button" class="btn btn-primary confirmButtonB me-2" ${!fecha2 ? 'disabled' : ''}>
                    ${fecha2 ? fecha2 : 'Fecha no cargada'}
                  </button>
                  <p class="successMessage me-2 hidden">Se ha inscripto con éxito</p>
                  <button class="btn btn-secondary pdfButton hidden" onclick="pdf('valor')">pdf</button>
                </td>
              </tr>`;
          } else {
            // Retorna una fila vacía o algún mensaje si no es regular
            return `
              <tr>
                <td colspan="2" class="text-center">La materia ${materiaData.Materia} no es regular.</td>
              </tr>`;
          }
        }).join('');
      }

      // Insertar las materias en el DOM
      const tbody = document.querySelector('.materias');
      tbody.innerHTML = generarHTML(materias);

      function inscripcion(tipo, clickedButton) {
        // Obtener la fila que contiene el botón clicado
        const row = clickedButton.closest('tr');
        const materia = row.querySelector('.campoMateria').innerText;

        // Mostrar el botón PDF y ocultar los botones A y B
        row.querySelector('.pdfButton').classList.remove('hidden');
        row.querySelector('.confirmButtonA').classList.add('hidden');
        row.querySelector('.confirmButtonB').classList.add('hidden');

        // Enviar los datos al servidor
        fetch('guardar_inscripcion.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `materia=${encodeURIComponent(materia)}&tipo=${encodeURIComponent(tipo)}`
          })
          .then(response => response.text())
          .then(data => {
            // Redirigir a la página deseada
            window.location.href = 'InscrCompletaExam.php';
          })
          .catch(error => console.error('Error:', error));
      }

    });
  </script>
</body>

</html>
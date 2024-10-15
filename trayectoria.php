<div id="contenidoPDF"> <!-- Contenedor principal para el PDF -->
    <div class="container">
        <span class="badge badge-primary" style="font-size: 120%; padding: .5em .75em; margin-top: 20px; display: block;">TS. en Desarrollo de Software - 2024</span>

        <div class="d-flex justify-content-between align-items-center" style="margin-top: 20px; margin-bottom: 20px;">
            <strong>
                <h4>TRAYECTORIA</h4>
            </strong>
            <div>
                <button id="btnPDF" type="button" class="btn btn-primary">PDF</button>
                <button id="btnExpandir" type="button" class="btn btn-secondary">VER</button>
            </div>
        </div>

        <hr>

        <div class="div">
            <div class="d-flex justify-content-between align-items-center">
                <h6>Progreso General</h6>
                <h6 id="progresoTexto"></h6> <!-- Texto de progreso actualizado dinámicamente -->
            </div>
            <div class="progress" style="margin-top: 20px; margin-bottom: 20px;">
                <div id="barraProgreso" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div> <!-- Barra de progreso actualizable -->
            </div>
        </div>
    </div>

    <div class="container">
        <strong>
            <h6>Año De Cursada: (2024)</h6>
        </strong>
        <div class="accordion" id="accordionMaterias">
            <!-- Las tarjetas se generarán aquí por JavaScript -->
        </div>
    </div>

    <br>

    <div class="container">
        <hr>
        <div class="div">
            <div class="d-flex justify-content-between align-items-center">
                <h6>Promedio</h6>
                <h6 id="promedioGeneral"></h6> <!-- Texto del promedio general actualizado dinámicamente -->
            </div>
            <div class="progress" style="margin-top: 20px; margin-bottom: 20px;">
                <div id="barraPromedio" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="10" style="width: 0%;"></div> <!-- Barra de promedio general actualizable -->
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Datos obtenidos de PHP
        <?php
        $conexion = new mysqli('localhost', 'root', '', 'sitmdm');

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $id_estudiante = getIdEstudiante();

        $sql_tecnicatura = "SELECT id_Tecnicatura FROM estudiantes WHERE id_usuario = ?";
        $stmt_tecnicatura = $conexion->prepare($sql_tecnicatura);
        $stmt_tecnicatura->bind_param("i", $id_estudiante);
        $stmt_tecnicatura->execute();
        $stmt_tecnicatura->bind_result($id_tecnicatura);
        $stmt_tecnicatura->fetch();
        $stmt_tecnicatura->close();

        $sql_materias = "SELECT 
            m.id_Materia, 
            m.Materia, 
            m.AnioCursada, 
            tm.nota_primer_cuatrimestre, 
            tm.nota_segundo_cuatrimestre, 
            tm.asistencia_horas, 
            tm.horas_cursadas
            FROM estudiante_materia tm
            JOIN materias m ON tm.id_Materia = m.id_Materia
            JOIN estudiante_tecnicatura et ON et.id_estudiante = tm.id_estudiante
            WHERE tm.id_estudiante = ? AND et.id_Tecnicatura = ?";

        $stmt = $conexion->prepare($sql_materias);
        $stmt->bind_param("ii", $id_estudiante, $id_tecnicatura);
        $stmt->execute();
        $resultado_materias = $stmt->get_result();

        $datos = array();

        if ($resultado_materias->num_rows > 0) {
            while ($row = $resultado_materias->fetch_assoc()) {
                $datos[$row['id_Materia']] = $row;  
                $datos[$row['id_Materia']]['finales'] = array();  
            }
        }

        $stmt->close();
        
        $sql_finales = "SELECT 
            f.id_materia, 
            f.fecha, 
            f.nota 
            FROM finales f
            WHERE f.id_estudiante = ? AND f.id_tecnicatura = ?";

        $stmt_finales = $conexion->prepare($sql_finales);
        $stmt_finales->bind_param("ii", $id_estudiante, $id_tecnicatura);
        $stmt_finales->execute();
        $resultado_finales = $stmt_finales->get_result();

        if ($resultado_finales->num_rows > 0) {
            while ($row_finales = $resultado_finales->fetch_assoc()) {
                $datos[$row_finales['id_materia']]['finales'][] = array(
                    "fecha" => $row_finales['fecha'],
                    "nota" => $row_finales['nota']
                );
            }
        }

        $stmt_finales->close();
        $conexion->close();

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
            return Object.values(materias).map((materiaData) => {
                const notaPrimerCuatrimestre = parseFloat(materiaData.nota_primer_cuatrimestre) || 0;
                const notaSegundoCuatrimestre = parseFloat(materiaData.nota_segundo_cuatrimestre) || 0;

                const notas = [notaPrimerCuatrimestre, notaSegundoCuatrimestre];
                const promedio = calcularPromedio(notas);
                const porcentajeAsistencia = calcularPorcentajeAsistencia(materiaData.horas_cursadas, materiaData.asistencia_horas);
                const esRegular = regularidad(promedio, porcentajeAsistencia) ? "Regular" : "Libre";
                const cardId = materiaData.Materia.replace(/\s+/g, '') + Math.random().toString(36).substring(7);

                const finales = materiaData.finales || [];
                let filasFinales = '';
                finales.forEach((final, index) => {
                    filasFinales += `
                        <tr>
                            <td class="text-center">${index + 1}</td>
                            <td class="text-center">${final.fecha}</td>
                            <td class="text-center">${final.nota}</td>
                        </tr>
                    `;
                });

                return `
                    <div class="card mb-3">
                        <div class="card-header" id="heading${cardId}">
                            <h5 class="mb-0">
                                <button class="btn btn-link toggle-card" type="button" data-toggle="collapse" data-target="#collapse${cardId}" aria-expanded="false" aria-controls="collapse${cardId}">
                                    ${materiaData.Materia}
                                </button>
                            </h5>
                        </div>
                        <div id="collapse${cardId}" class="collapse" aria-labelledby="heading${cardId}">
                            <div class="card-body">
                                <p><strong>Condición:</strong> ${esRegular}</p>
                                <hr>
                                <p><strong>Nota Primer Cuatrimestre:</strong> ${notaPrimerCuatrimestre}</p>
                                <p><strong>Nota Segundo Cuatrimestre:</strong> ${notaSegundoCuatrimestre}</p>
                                <hr>
                                <p><strong>Nota Examen Final:</strong></p>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">N°</th>
                                            <th scope="col" class="text-center">Fecha</th>
                                            <th scope="col" class="text-center">Nota</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${filasFinales}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function actualizarProgreso(materias) {
            let totalMaterias = 0;
            let materiasAprobadas = 0;

            Object.values(materias).forEach(materia => {
                totalMaterias++;
                const promedio = calcularPromedio([parseFloat(materia.nota_primer_cuatrimestre) || 0, parseFloat(materia.nota_segundo_cuatrimestre) || 0]);
                const asistencia = calcularPorcentajeAsistencia(materia.horas_cursadas, materia.asistencia_horas);

                if (regularidad(promedio, asistencia)) {
                    materiasAprobadas++;
                }
            });

            const progresoPorcentaje = (materiasAprobadas / totalMaterias) * 100;
            document.getElementById('barraProgreso').style.width = progresoPorcentaje + '%';
            document.getElementById('progresoTexto').innerText = `${progresoPorcentaje.toFixed(2)}%`;
        }

        function actualizarPromedioGeneral(materias) {
            let sumaPromedios = 0;
            let totalMaterias = 0;

            Object.values(materias).forEach(materia => {
                const notasFinales = materia.finales.map(final => parseFloat(final.nota)).filter(nota => !isNaN(nota));
                if (notasFinales.length > 0) {
                    const ultimaNotaFinal = notasFinales[notasFinales.length - 1]; // Última nota final
                    sumaPromedios += ultimaNotaFinal;
                    totalMaterias++;
                }
            });

            const promedioGeneral = (sumaPromedios / totalMaterias).toFixed(2);
            document.getElementById('barraPromedio').style.width = promedioGeneral * 10 + '%'; // 0-10 promedio, se multiplica por 10 para un rango de 0-100
            document.getElementById('promedioGeneral').innerText = promedioGeneral;
        }

        document.getElementById('accordionMaterias').innerHTML = generarHTML(materias);
        actualizarProgreso(materias);
        actualizarPromedioGeneral(materias);
    });
</script>

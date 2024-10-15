
<!DOCTYPE html>
<html lang="es">

<head>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="formulario.css">
  
  <style>
    .form-header {
      background-color: #007bff;
      color: white;
      padding: 20px;
      text-align: center;
      margin-bottom: 20px;
    }

    .form-header h3,
    .form-header h4 {
      margin: 0;
    }
  </style>
</head>

<body class="hidden-sn mdb-skin">
  <div class="container mt-5">
    <div class="card">
      <div class="card-body">
        <form id="formulario" method="post" action="guardar_datos.php">
          <div class="form-header bg-primary text-white text-center py-3 mb-4">
            <h3 class="font-weight-200"><i class="fas fa-user"></i> SOLICITUD DE INSCRIPCIÓN AÑO LECTIVO <span id="fechaTitulo"></span></h3>
            <h4>EDUCACIÓN SUPERIOR</h4>
            <h4>FORMACIÓN DOCENTE INICIAL. EDUCACIÓN SUPERIOR TÉCNICA. EDUCACIÓN SUPERIOR ARTÍSTICA</h4>
          </div>

          <div class="mb-3">
            <label for="numero_establecimiento" class="form-label">N°:</label>
            <input type="text" class="form-control" id="numero_establecimiento" placeholder="A completar por el establecimiento" name="numero_establecimiento">
          </div>

          <section>
            <h4 class="mb-3">DATOS ESTUDIANTE</h4>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="apellido" class="form-label">Apellido/s:</label>
                <input type="text" class="form-control" id="apellido" placeholder="Apellido/s" name="apellido" required pattern="[A-Za-z\s]+" title="Solo letras y espacios">
              </div>
              <div class="col-md-6 mb-3">
                <label for="nombre" class="form-label">Nombre/s:</label>
                <input type="text" class="form-control" id="nombre" placeholder="Nombre/s" name="nombre" required pattern="[A-Za-z\s]+" title="Solo letras y espacios">
              </div>
              <div class="col-md-6 mb-3">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input type="tel" class="form-control" id="telefono" placeholder="Teléfono" name="telefono" required pattern="[0-9]{10}" title="Debe contener exactamente 10 dígitos numéricos">
              </div>
              <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Email" name="email" required>
              </div>
            </div>
          </section>

          <section>
            <h4 class="mb-3">DNI</h4>
            <div class="mb-3">
              <label for="dniSelect" class="form-label">¿Posee DNI Argentino?</label>
              <select id="dniSelect" class="form-select" name="posee_dni" required>
                <option value="" selected disabled>Seleccione una opción</option>
                <option value="1">Sí, y tengo el DNI físico</option>
                <option value="2">Sí, pero NO tengo el DNI físico y se encuentra en trámite</option>
                <option value="3">Sí, pero NO tengo el DNI físico y NO se encuentra en trámite</option>
                <option value="4">NO posee DNI argentino</option>
              </select>
            </div>
            <div class="dni">
              <div class="mb-3">
                <label for="dniNumber" class="form-label">Indique número de DNI argentino:</label>
                <input id="dniNumber" type="text" class="form-control" placeholder="********" name="dni_numero" required pattern="[0-9]{8}">
              </div>
              <div class="mb-3">
                <label for="cuilNumber" class="form-label">CUIL:</label>
                <input id="cuilNumber" type="text" class="form-control" placeholder="***********" name="cuil" required pattern="[0-9]{11}">
              </div>
            </div>
            <div class="dniNo">
              <h5>¿Posee certificado de preinscripción (CPI)?</h5>
              <div class="form-check">
                <input class="form-check-input" type="radio" id="cpiSi" value="SI" name="tiene_cpi" required>
                <label class="form-check-label" for="cpiSi">Sí</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" id="cpiNo" value="NO" name="tiene_cpi">
                <label class="form-check-label" for="cpiNo">No</label>
              </div>
              <h5>¿Posee documento extranjero?</h5>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="docExtSi" value="SI" name="documento_extranjero" required>
                <label class="form-check-label" for="docExtSi">Sí</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="docExtNo" value="NO" name="documento_extranjero">
                <label class="form-check-label" for="docExtNo">No</label>
              </div>
              <div class="mb-3">
                <label for="tipo_documento_extranjero" class="form-label">Tipo de documento:</label>
                <input type="text" class="form-control" id="tipo_documento_extranjero" placeholder="Tipo de documento" name="tipo_documento_extranjero" required pattern="[A-Za-z\s]+">
              </div>
              <div class="mb-3">
                <label for="numero_documento_extranjero" class="form-label">N°:</label>
                <input type="number" class="form-control" id="numero_documento_extranjero" placeholder="N°" name="numero_documento_extranjero" required>
              </div>
            </div>
          </section>

          <section>
            <div class="mb-3">
              <label for="identidadGenero" class="form-label">Identidad de género:</label>
              <select id="identidadGenero" class="form-select" name="identidad_genero" required>
                <option value="" disabled selected>Seleccione una opción</option>
                <option value="1">Mujer</option>
                <option value="2">Mujer trans / travesti</option>
                <option value="3">Varón</option>
                <option value="4">Varón trans / masculinidad trans</option>
                <option value="5">No binario</option>
                <option value="6">Otro</option>
                <option value="7">No desea responder</option>
              </select>
            </div>
          </section>

          <section>
            <div class="mb-3">
              <label for="pais_select" class="form-label">Lugar de nacimiento:</label>
              <select id="pais_select" class="form-select" name="lugar_nacimiento" required>
                <option value="" disabled selected>Seleccione una opción</option>
                <option value="1">Argentina</option>
                <option value="2">En el extranjero</option>
              </select>
            </div>
            <div class="exterior">
              <div class="mb-3">
                <label for="especificar_pais" class="form-label">Especificar país:</label>
                <input type="text" class="form-control" id="especificar_pais" placeholder="Especificar país" name="especificar_pais" required pattern="[A-Za-z\s]+">
              </div>
            </div>
            <div class="argentina">
              <div class="mb-3">
                <label for="provincia" class="form-label">Provincia</label>
                <select class="form-select" id="provincia" name="provincia" required>
                  <option value="" disabled selected>Selecciona una provincia</option>
                  <option value="Buenos Aires">Buenos Aires</option>
                  <option value="Catamarca">Catamarca</option>
                  <option value="Chaco">Chaco</option>
                  <option value="Chubut">Chubut</option>
                  <option value="Córdoba">Córdoba</option>
                  <option value="Corrientes">Corrientes</option>
                  <option value="Entre Ríos">Entre Ríos</option>
                  <option value="Formosa">Formosa</option>
                  <option value="Jujuy">Jujuy</option>
                  <option value="La Pampa">La Pampa</option>
                  <option value="La Rioja">La Rioja</option>
                  <option value="Mendoza">Mendoza</option>
                  <option value="Misiones">Misiones</option>
                  <option value="Neuquén">Neuquén</option>
                  <option value="Río Negro">Río Negro</option>
                  <option value="Salta">Salta</option>
                  <option value="San Juan">San Juan</option>
                  <option value="San Luis">San Luis</option>
                  <option value="Santa Cruz">Santa Cruz</option>
                  <option value="Santa Fe">Santa Fe</option>
                  <option value="Santiago del Estero">Santiago del Estero</option>
                  <option value="Tierra del Fuego">Tierra del Fuego</option>
                  <option value="Tucumán">Tucumán</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="localidad" class="form-label">Localidad:</label>
                <input type="text" class="form-control" id="localidad" placeholder="Localidad" name="localidad" required pattern="[A-Za-z\s]+">
              </div>
              <div class="bsas">
                <label for="distrito" class="form-label">Distrito:</label>
                <input type="text" class="form-control" id="distrito" placeholder="Distrito" name="distrito" required pattern="[A-Za-z\s]+">
              </div>
              <div class="otra">
                <label for="especificar_provincia" class="form-label">Especificar:</label>
                <input type="text" class="form-control" id="especificar_provincia" placeholder="Especificar" name="especificar_provincia" required pattern="[A-Za-z\s]+">
              </div>
              <div class="mb-3">
                <label for="calle" class="form-label">Calle:</label>
                <input type="text" class="form-control" id="calle" placeholder="Calle" name="calle" required>
              </div>
              <div class="mb-3">
                <label for="numero" class="form-label">Número:</label>
                <input type="text" class="form-control" id="numero" placeholder="Número" name="numero" required pattern="[0-9]+" title="Solo números">
              </div>
              <div class="mb-3">
                <label for="piso" class="form-label">Piso:</label>
                <input type="text" class="form-control" id="piso" placeholder="Piso" name="piso">
              </div>
              <div class="mb-3">
                <label for="torre" class="form-label">Torre:</label>
                <input type="text" class="form-control" id="torre" placeholder="Torre" name="torre">
              </div>
              <div class="mb-3">
                <label for="departamento" class="form-label">Departamento:</label>
                <input type="text" class="form-control" id="departamento" placeholder="Departamento" name="departamento">
              </div>
            </div>
          </section>

          <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
      </div>
    </div>
  </div>






  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRu0HQkmXNmHXud6VJUhgbgDUGb5gbdcfQ/ghvgn4" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQTf9pDbFLpr8xoT9WlEuQjTA3wT/4a5oDhz6kktLcbRHuoPBHVj12yow5j7R8u0" crossorigin="anonymous"></script>
  <script src="formulario.js"></script>

</body>

</html>
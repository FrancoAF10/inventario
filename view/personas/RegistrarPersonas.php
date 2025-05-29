<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <div class="container">
    <form action="" method="POST" id="formulario-personas">
      <h2 class="text-center mt-3">REGISTRAR PERSONA</h2>
      <button id="volverpersona" type="button" onclick="window.location.href='././ListarPersonas.php'" class="btn btn-success"><i class="fa-solid fa-arrow-left"></i> VOLVER</button>
      <hr>
      <div class="card mt-3">
        <div class="card-header bg-info"><strong>REGISTRAR PERSONA</strong></div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos"
                  required>
                <label for="apellidos" class="form-label">Apellidos</label>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombres" required>
                <label for="nombres" class="form-label">Nombres</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" id="tipoDoc" name="tipoDoc" placeholder="Tipo de Documento"
                  required>
                <label for="tipoDoc" class="form-label">Tipo de Documento</label>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" id="nroDocumento" name="nroDocumento"
                  placeholder="Número de Documento" required>
                <label for="nroDocumento" class="form-label">Número de Documento</label>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" required>
                <label for="telefono" class="form-label">Teléfono</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" placeholder="Correo Electrónico"
                  required>
                <label for="email" class="form-label">Correo Electrónico</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección"
                  required>
                <label for="direccion" class="form-label">Dirección</label>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer  d-grid gap-2">
          <button type="submit" class="btn btn-primary">Registrar</button>
        </div>
      </div>
    </form>
  </div>
  <script>
    const formulario = document.querySelector("#formulario-personas");

    function registrarPersona() {
      fetch(`../../controller/PersonasController.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          apellidos: document.querySelector('#apellidos').value,
          nombres: document.querySelector('#nombres').value,
          tipoDoc: document.querySelector('#tipoDoc').value,
          nroDocumento: document.querySelector('#nroDocumento').value,
          telefono: document.querySelector('#telefono').value,
          email: document.querySelector('#email').value,
          direccion: document.querySelector('#direccion').value
        })
      })
        .then(response => { return response.json() })
        .then(data => {
          if (data.filas > 0) {
            formulario.reset();
            Swal.fire({
              title: 'CONFIRMADO',
              text: 'Persona Registrada',
              icon: 'success',
              footer: 'SENATI ING. SOFTWARE',
              confirmButtonText: 'OK',
              confirmButtonColor: '#2980b9',
            })
          }
        })
        .catch(error => { console.error(error) });
    }
    //formulario=botonb[submit](validar Front)
    formulario.addEventListener("submit", function (event) {
      event.preventDefault();//cancela el evento

      Swal.fire({
        title: 'PERSONA',
        text: '¿Está seguro de registrar?',
        icon: 'question',
        footer: 'SENATI ING. SOFTWARE',
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#2980b9',
        showCancelButton: true,
        cancelButtonText: 'cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          registrarPersona();
        }
      })
    });

  </script>
</body>

</html>
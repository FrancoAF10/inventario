<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Document</title>
</head>
<body>
<div class="container">
    <form action="" method="POST" id="formulario-personas">
      <h2 class="text-center mt-3">ACTUALIZACIÓN DE DATOS</h2>
      <hr>
      <div class="card mt-3">
        <div class="card-header bg-info"><strong>ACTUALIZAR</strong></div>
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
          <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
      </div>
    </form>
  </div>
  <script>
      document.addEventListener("DOMContentLoaded", () => {
    // Obtener el registro existente para cargarlo en el formulario
    function obtenerRegistro() {
      const URL = new URLSearchParams(window.location.search);
      const idpersona = URL.get('id');

      const parametros = new URLSearchParams();
      parametros.append("task", "getById");
      parametros.append("idPersona", idpersona);

      fetch(`../../controller/PersonasController.php?${parametros}`, { method: 'GET' })
        .then(response => response.json())
        .then(data => {
          if (data.length > 0) {
            document.getElementById("apellidos").value = data[0].apellidos;
            document.getElementById("nombres").value = data[0].nombres;
            document.getElementById("tipoDoc").value = data[0].tipoDoc;
            document.getElementById("nroDocumento").value = data[0].nroDocumento;
            document.getElementById("telefono").value = data[0].telefono;
            document.getElementById("email").value = data[0].email;
            document.getElementById("direccion").value = data[0].direccion;

          }
        })
        .catch(error => {
          console.error(error);
        });
    }

    obtenerRegistro();

    const formulario = document.getElementById('formulario-personas');

    formulario.addEventListener('submit', function (event) {
      event.preventDefault();

      const idpersona = new URLSearchParams(window.location.search).get('id');
      const apellidos = document.getElementById('apellidos').value;
      const nombres = document.getElementById('nombres').value;
      const tipoDoc = document.getElementById('tipoDoc').value;
      const nroDocumento = document.getElementById('nroDocumento').value;
      const telefono = document.getElementById('telefono').value;
      const email = document.getElementById('email').value;
      const direccion = document.getElementById('direccion').value;


      Swal.fire({
        title: 'PERSONAS',
        text: '¿Está seguro de actualizar?',
        icon: 'question',
        footer: 'SENATI ING. SOFTWARE',
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#2980b9',
        showCancelButton: true,
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          const datos = {
            idPersona: idpersona,
            apellidos: apellidos,
            nombres:nombres,
            tipoDoc:tipoDoc,
            nroDocumento:nroDocumento,
            telefono:telefono,
            email:email,
            direccion:direccion
          };

          fetch('../../controller/PersonasController.php', {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(datos)
          })
            .then(response => response.json())
            .then(data => {
              if (data.filas > 0) {
                Swal.fire({
                  title: 'ACTUALIZADO',
                  text: 'Datos de la Persona actualizados',
                  icon: 'success',
                  footer: 'SENATI ING. SOFTWARE',
                  confirmButtonText: 'OK',
                  confirmButtonColor: '#2980b9',
                }).then(() => {
                  // Redirigir después de aceptar el mensaje de éxito
                  window.location.href = "../../view/personas/ListarPersonas.php";
                });
              }
            })
            .catch(error => {
              console.error(error);
            });
        }
      });
    });
  });
  </script>
</body>
</html>
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
    <form action="" autocomplete="off" id="formulario-registrar">
      <h2 class="text-center mt-3">REGISTRAR ROL</h2>
      <button id="listadoRoles" type="button" onclick="window.location.href='././ListarRoles.php'" class="btn btn-success"><i class="fa-solid fa-arrow-left"></i> VOLVER </button>
      <hr>
      <div class="card mt-3">
        <div class="card-header bg-info"><strong>REGISTRAR ROLES</strong></div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12 mb-2">
              <div class="form-floating">
                <input type="text" id="rol" name="rol" class="form-control" placeholder="ROLES" required>
                <label for="rol" class="form-label">ROLES:</label>
            </div>
          </div>
          </div>
        </div>
        <div class="card-footer d-grid gap-2">
          <button class="btn btn-primary" id="addRoles" type="submit">Agregar Rol</button>
        </div>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>


  <script>
    //AGREGAMOS UN REGISTRO
    const formulario = document.querySelector("#formulario-registrar");

    function registrarRol() {
      fetch(`../../controller/RolesController.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          rol: document.querySelector('#rol').value,
        })
      })
        .then(response => { return response.json() })
        .then(data => {
          if (data.filas > 0) {
            formulario.reset();
            Swal.fire({
              title: 'CONFIRMADO',
              text: 'Rol Registrado',
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
        title: 'ROLES',
        text: '¿Está seguro de registrar?',
        icon: 'question',
        footer: 'SENATI ING. SOFTWARE',
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#2980b9',
        showCancelButton: true,
        cancelButtonText: 'cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          registrarRol();
        }
      })
    });

  </script>
</body>

</html>
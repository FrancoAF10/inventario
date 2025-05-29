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
  <div class="container mt-5">
    <form id="registrar-usuario" autocomplete="off" method="POST">
      <h2 class="text-center mt-5">REGISTRAR USUARIO</h2>
      <button id="volverUsuario" type="button" onclick="window.location.href='././listarUsuarios.php'" class="btn btn-success"><i class="fa-solid fa-arrow-left"></i> VOLVER</button>
     <hr>
      <div class="card mt-3">
        <div class="card-header bg-info"><strong>REGISTRAR </strong></div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" id="nomUser" name="nomUser" placeholder="Nombre de Usuario"
                  required>
                <label for="nomUser" class="form-label">Nombre de Usuario:</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña"
                  required>
                <label for="password" class="form-label">Contraseña:</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="form-floating">
                <select id="estado" name="estado" class="form-select" required>
                  <option value="Activo">Activo</option>
                  <option value="Inactivo">Inactivo</option>
                </select>
                <label for="estado" class="form-label">Estado:</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="form-floating">
                <select id="idColaborador" name="idColaborador" class="form-select" required>
                  <option value="">Seleccione un colaborador</option>
                </select>
                <label for="idColaborador" class="form-label">Seleccionar Colaborador:</label>
              </div>
            </div>
          </div>
          <div class="card-footer d-grid gap-2">
            <button type="submit" class="btn btn-primary">Agregar Usuario</button>
          </div>
    </form>
  </div>
  </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const colaborador = document.querySelector("#idColaborador"); 

      fetch("../../controller/UsuariosController.php?task=getColaboradores")
        .then(response => response.json())
        .then(data => {

          data.forEach(colaboradores => {
            colaborador.innerHTML += `<option value="${colaboradores.idColaborador}">${colaboradores.nombres} ${colaboradores.apellidos}</option>`;
          });
        })
        .catch(error => {
          console.error(error);
        });
    });

    const formulario = document.querySelector("#registrar-usuario");
    function registrarUsuario() {
      fetch(`../../controller/UsuariosController.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          nomUser: document.querySelector('#nomUser').value,
          passUser: document.querySelector('#password').value,
          estado: document.querySelector('#estado').value,
          idColaborador: parseInt(document.querySelector('#idColaborador').value)
        })
      })
        .then(response => { return response.json() })
        .then(data => {
          if (data.filas > 0) {
            formulario.reset();
            Swal.fire({
              title: 'CONFIRMADO',
              text: 'Usuario Registrado',
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
        title: 'USUARIO',
        text: '¿Está seguro de registrar?',
        icon: 'question',
        footer: 'SENATI ING. SOFTWARE',
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#2980b9',
        showCancelButton: true,
        cancelButtonText: 'cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          registrarUsuario();
        }
      })
    });
  </script>
</body>

</html>
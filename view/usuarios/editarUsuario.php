<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Document</title>
</head>
<body>
  
<div class="container mt-5">
    <form id="registrar-usuario" autocomplete="off" method="POST">
      <h2 class="text-center mt-5">ACTUALIZACIÓN DE DATOS</h2>
      <hr>
      <div class="card mt-3">
        <div class="card-header bg-info"><strong>ACTUALIZAR USUARIO</strong></div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="form-floating">
              <input type="text" class="form-control" id="nomUser" name="nomUser" placeholder="Nombre de Usuario" autocomplete="username" required>
                <label for="nomUser" class="form-label">Nombre de Usuario:</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="form-floating">
              <input type="password" class="form-control" id="password" name="password"
              placeholder="Contraseña" autocomplete="current-password" required>
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
            <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
          </div>
    </form>
  </div>
  </div>
  </div>
  <script>
      document.addEventListener("DOMContentLoaded", () => {
    // Obtener el registro existente para cargarlo en el formulario
    function obtenerRegistro() {
  const URL = new URLSearchParams(window.location.search);
  const idusuario = URL.get('id');
  const colaboradorSelect = document.querySelector("#idColaborador");

  const parametros = new URLSearchParams();
  parametros.append("task", "getById");
  parametros.append("idUsuario", idusuario);

  let usuarioData = null;

  // Paso 1: Obtener los datos del usuario
  fetch(`../../controller/UsuariosController.php?${parametros}`, { method: 'GET' })
    .then(response => response.json())
    .then(data => {
      if (data.length > 0) {
        usuarioData = data[0]; // Guardamos los datos del usuario para usar después
        document.getElementById("nomUser").value = usuarioData.nomUser;
        document.getElementById("password").value = usuarioData.passUser;
        document.getElementById("estado").value = usuarioData.estado;
      }
      // Paso 2: Obtener colaboradores
      return fetch("../../controller/UsuariosController.php?task=getColaboradores");
    })
    .then(response => response.json())
    .then(data => {
      data.forEach(colaborador => {
        const option = document.createElement("option");
        option.value = colaborador.idColaborador;
        option.textContent = `${colaborador.nombres} ${colaborador.apellidos}`;
        colaboradorSelect.appendChild(option);
      });

      // Paso 3: Ahora que las opciones están cargadas, seleccionamos el colaborador correcto
      if (usuarioData) {
        colaboradorSelect.value = usuarioData.idColaborador;
      }
    })
    .catch(error => {
      console.error(error);
    });
}


    obtenerRegistro();

    const formulario = document.getElementById('registrar-usuario');

    formulario.addEventListener('submit', function (event) {
      event.preventDefault();

      const idusuario = new URLSearchParams(window.location.search).get('id');
      const nomUser = document.getElementById('nomUser').value;
      const passUser = document.getElementById('password').value;
      const estado = document.getElementById('estado').value;
      const idColaborador = document.getElementById('idColaborador').value;

      Swal.fire({
        title: 'USUARIOS',
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
            idUsuario:idusuario,
              nomUser: nomUser,
              passUser:passUser,
              estado:estado,
              idColaborador: idColaborador,
          };

          fetch('../../controller/UsuariosController.php', {
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
                  text: 'Datos de Usuario actualizados',
                  icon: 'success',
                  footer: 'SENATI ING. SOFTWARE',
                  confirmButtonText: 'OK',
                  confirmButtonColor: '#2980b9',
                }).then(() => {
                  // Redirigir después de aceptar el mensaje de éxito
                  window.location.href = "../../view/usuarios/listarUsuarios.php";
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
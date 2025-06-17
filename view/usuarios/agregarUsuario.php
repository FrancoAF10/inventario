<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Registrar Usuario</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      background-color: #f8f9fa;
    }
    .navbar-brand {
      font-weight: bold;
      letter-spacing: 1px;
    }
    .card {
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }
    .btn {
      transition: all 0.3s ease;
    }
    .btn:hover {
      transform: scale(1.05);
    }
  </style>
</head>

<body>

  <?php include_once(__DIR__ . '/../../layouts/navbar.php'); ?>

  <div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="text-primary">Registrar Usuario</h2>
      <button type="button" onclick="window.location.href='./listarUsuarios.php'" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Volver
      </button>
    </div>

    <form autocomplete="off" id="formulario-registrar-usuario">
      <div class="card">
        <div class="card-header bg-primary text-white">
          <strong>Formulario de Registro</strong>
        </div>
        <div class="card-body">
          <div class="form-floating mb-3">
            <input type="text" id="nomUser" name="nomUser" class="form-control" placeholder="Nombre de Usuario" required />
            <label for="nomUser">Nombre de Usuario</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" required />
            <label for="password">Contraseña</label>
          </div>
          <div class="form-floating mb-3">
            <select id="estado" name="estado" class="form-select" required>
              <option value="Activo">Activo</option>
              <option value="Inactivo">Inactivo</option>
            </select>
            <label for="estado">Estado</label>
          </div>
          <div class="form-floating mb-3">
            <select id="idColaborador" name="idColaborador" class="form-select" required>
              <option value="">Seleccione un colaborador</option>
            </select>
            <label for="idColaborador">Seleccionar Colaborador</label>
          </div>
        </div>
        <div class="card-footer text-end">
          <button class="btn btn-primary" type="submit">
            <i class="fa-solid fa-check me-1"></i> Registrar Usuario
          </button>
        </div>
      </div>
    </form>
  </div>

  <script>
    // Carga colaboradores para el select
    document.addEventListener("DOMContentLoaded", () => {
      const colaborador = document.querySelector("#idColaborador");

      fetch("../../controller/UsuariosController.php?task=getColaboradores")
        .then(response => response.json())
        .then(data => {
          data.forEach(col => {
            colaborador.innerHTML += `<option value="${col.idColaborador}">${col.nombres} ${col.apellidos}</option>`;
          });
        })
        .catch(error => {
          console.error('Error al cargar colaboradores:', error);
        });
    });

    const formulario = document.querySelector("#formulario-registrar-usuario");

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
        .then(response => response.json())
        .then(data => {
          if (data.filas > 0) {
            formulario.reset();
            Swal.fire({
              icon: 'success',
              title: 'Usuario registrado',
              text: 'El usuario se registró correctamente.',
              footer: 'SENATI ING. SOFTWARE',
              confirmButtonColor: '#198754'
            });
          } else {
            Swal.fire({
              icon: 'warning',
              title: 'Sin cambios',
              text: 'No se pudo registrar el usuario.',
              confirmButtonColor: '#ffc107'
            });
          }
        })
        .catch(error => {
          console.error(error);
          Swal.fire({
            icon: 'error',
            title: 'Error del servidor',
            text: 'No se pudo registrar el usuario.',
            confirmButtonColor: '#dc3545'
          });
        });
    }

    formulario.addEventListener("submit", (event) => {
      event.preventDefault();

      Swal.fire({
        title: '¿Registrar Usuario?',
        text: 'Confirme si desea registrar el nuevo usuario.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Registrar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          registrarUsuario();
        }
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

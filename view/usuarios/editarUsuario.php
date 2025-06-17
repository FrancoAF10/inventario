<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Actualizar Usuario</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" />

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      background-color: #f8f9fa;
    }
    .card {
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .btn {
      transition: all 0.3s ease-in-out;
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
    <h2 class="text-primary">Actualizar Usuario</h2>
    <button onclick="window.location.href='./listarUsuarios.php'" class="btn btn-outline-secondary">
      <i class="fa-solid fa-arrow-left me-1"></i> Volver
    </button>
  </div>

  <form id="formulario-actualizar" autocomplete="off" method="POST" novalidate>
    <div class="card">
      <div class="card-header bg-info text-white">
        <strong>Formulario de Actualización</strong>
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
        <button type="submit" class="btn btn-primary">
          <i class="fa-solid fa-floppy-disk me-1"></i> Guardar Cambios
        </button>
      </div>
    </div>
  </form>
</div>


<script>
  document.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    const idUsuario = urlParams.get("id");
    const colaboradorSelect = document.getElementById("idColaborador");

    if (!idUsuario) {
      Swal.fire("Error", "No se encontró el ID del usuario en la URL.", "error");
      return;
    }

    // Cargar datos de usuario y colaboradores
    fetch(`../../controller/UsuariosController.php?task=getById&idUsuario=${idUsuario}`)
      .then(res => res.json())
      .then(dataUser => {
        if (!dataUser.length) {
          Swal.fire("Error", "Usuario no encontrado.", "error");
          throw new Error("Usuario no encontrado");
        }
        const usuario = dataUser[0];
        document.getElementById("nomUser").value = usuario.nomUser;
        document.getElementById("password").value = usuario.passUser;
        document.getElementById("estado").value = usuario.estado;

        return fetch("../../controller/UsuariosController.php?task=getColaboradores");
      })
      .then(res => res.json())
      .then(dataColaboradores => {
        dataColaboradores.forEach(col => {
          const option = document.createElement("option");
          option.value = col.idColaborador;
          option.textContent = `${col.nombres} ${col.apellidos}`;
          colaboradorSelect.appendChild(option);
        });

        // Seleccionar colaborador asignado al usuario
        fetch(`../../controller/UsuariosController.php?task=getById&idUsuario=${idUsuario}`)
          .then(res => res.json())
          .then(dataUser => {
            if (dataUser.length) {
              colaboradorSelect.value = dataUser[0].idColaborador;
            }
          });
      })
      .catch(err => {
        console.error(err);
        Swal.fire("Error", "No se pudo cargar la información.", "error");
      });

    document.getElementById("formulario-actualizar").addEventListener("submit", function(e) {
      e.preventDefault();

      const nomUser = document.getElementById("nomUser").value.trim();
      const password = document.getElementById("password").value.trim();
      const estado = document.getElementById("estado").value;
      const idColaborador = document.getElementById("idColaborador").value;

      if (!nomUser || !password || !idColaborador) {
        Swal.fire("Campos incompletos", "Por favor complete todos los campos.", "warning");
        return;
      }

      Swal.fire({
        title: "¿Actualizar usuario?",
        text: "Esta acción modificará la información.",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Sí, actualizar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#0d6efd",
        cancelButtonColor: "#6c757d"
      }).then(result => {
        if (result.isConfirmed) {
          fetch("../../controller/UsuariosController.php", {
            method: "PUT",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
              idUsuario,
              nomUser,
              passUser: password,
              estado,
              idColaborador
            })
          })
          .then(res => res.json())
          .then(data => {
            if (data.filas > 0) {
              Swal.fire({
                title: "Actualizado",
                text: "Datos de usuario actualizados correctamente.",
                icon: "success",
                confirmButtonColor: "#198754"
              }).then(() => {
                window.location.href = "./listarUsuarios.php";
              });
            } else {
              Swal.fire("Sin cambios", "No se actualizó ningún registro.", "info");
            }
          })
          .catch(err => {
            console.error(err);
            Swal.fire("Error", "No se pudo actualizar el usuario.", "error");
          });
        }
      });
    });
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>

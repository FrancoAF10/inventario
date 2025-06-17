<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gestión de Colaboradores</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />

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
    .card-header {
      background-color: #0d6efd;
      color: white;
      font-weight: bold;
    }
    .btn {
      transition: all 0.3s ease;
    }
    .btn:hover {
      transform: scale(1.05);
    }
    th, td {
      vertical-align: middle;
    }
  </style>
</head>
<body>

<?php include_once(__DIR__ . '/../../layouts/navbar.php'); ?>

<div class="container my-5">
  <h2 class="text-center text-primary mb-4">Gestión de Colaboradores</h2>

  <div class="text-end mb-3">
    <button class="btn btn-success" onclick="location.href='./registrarColaborador.php'">
      <i class="fa-solid fa-plus me-1"></i> Nuevo Colaborador
    </button>
  </div>

  <div class="card shadow">
    <div class="card-header">COLABORADORES REGISTRADOS</div>
    <div class="card-body table-responsive">
      <table class="table table-bordered table-hover align-middle" id="tablaColaboradores">
        <colgroup>
          <col style="width: 10%;" />
          <col style="width: 25%;" />
          <col style="width: 20%;" />
          <col style="width: 15%;" />
          <col style="width: 15%;" />
          <col style="width: 15%;" />
          <col style="width: 15%;" />
        </colgroup>
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Persona</th>
            <th>Área</th>
            <th>Rol</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th class="text-center">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <!-- Cuerpo dinámico -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  const tabla = document.querySelector("#tablaColaboradores tbody");

  function obtenerDatos() {
    fetch(`../../controller/ColaboradorController.php?task=getAll`)
      .then(response => response.json())
      .then(data => {
        tabla.innerHTML = '';
        data.forEach(element => {
          tabla.innerHTML += `
            <tr>
              <td>${element.idColaborador}</td>
              <td>${element.apellidos} ${element.nombres}</td>
              <td>${element.area}</td>
              <td>${element.rol}</td>
              <td>${element.inicio}</td>
              <td>${element.fin}</td>
              <td class="text-center">
                <a href="editarColaborador.php?id=${element.idColaborador}" class="btn btn-outline-info btn-sm me-1" title="Editar">
                  <i class="fa-solid fa-pencil"></i>
                </a>
                <a href="#" class="btn btn-outline-danger btn-sm delete" data-idcolaborador="${element.idColaborador}" title="Eliminar">
                  <i class="fa-solid fa-trash"></i>
                </a>
              </td>
            </tr>
          `;
        });
      })
      .catch(error => console.error(error));
  }

  document.addEventListener("DOMContentLoaded", () => {
    obtenerDatos();

    tabla.addEventListener("click", (event) => {
      const enlace = event.target.closest("a");
      if (enlace && enlace.classList.contains("delete")) {
        event.preventDefault();
        const idcolaborador = enlace.getAttribute("data-idcolaborador");

        Swal.fire({
          title: "¿Está seguro?",
          text: "¡Esta acción no se puede revertir!",
          icon: "warning",
          footer: 'SENATI ING. SOFTWARE',
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Sí, eliminar",
          cancelButtonText: "Cancelar"
        }).then((result) => {
          if (result.isConfirmed) {
            fetch(`../../controller/ColaboradorController.php/${idcolaborador}`, {
              method: 'DELETE'
            })
              .then(response => response.json())
              .then(datos => {
                if (datos.filas > 0) {
                  enlace.closest('tr').remove();
                  Swal.fire("¡Eliminado!", "El colaborador ha sido eliminado correctamente.", "success");
                } else {
                  Swal.fire("Error", "No se pudo eliminar el colaborador.", "error");
                }
              })
              .catch(error => {
                console.error(error);
                Swal.fire("Error", "Ocurrió un problema al eliminar el colaborador.", "error");
              });
          }
        });
      }
    });
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Gestión de Detalles</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      background-color: #f8f9fa;
    }
    .card {
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .card-header {
      background-color: #0d6efd;
      color: white;
      font-weight: bold;
    }
    .btn {
      transition: all 0.3s ease-in-out;
    }
    .btn:hover {
      transform: scale(1.05);
    }
    th, td {
      vertical-align: middle;
    }
    h2 {
      font-weight: 700;
      letter-spacing: 1px;
    }
    .text-primary {
      color: #0d6efd !important;
    }
  </style>
</head>
<body>

<?php include_once(__DIR__ . '/../../layouts/navbar.php'); ?>

<div class="container my-5">
  <h2 class="text-center text-primary mb-4">Gestión de Detalles</h2>

  <div class="text-end mb-3">
    <button class="btn btn-success" onclick="window.location.href='./registrarDetalles.php'">
      <i class="fa-solid fa-plus me-1"></i> Nuevo Detalle
    </button>
  </div>

  <div class="card">
    <div class="card-header">DETALLES REGISTRADOS</div>
    <div class="card-body table-responsive">
      <table class="table table-bordered table-hover align-middle" id="tabla-Detalles">
        <colgroup>
          <col style="width: 10%;">
          <col style="width: 25%;">
          <col style="width: 25%;">
          <col style="width: 30%;">
          <col style="width: 10%;">
        </colgroup>
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>CARACTERÍSTICAS</th>
            <th>CONFIGURACIÓN</th>
            <th>DETALLES</th>
            <th class="text-center">ACCIONES</th>
          </tr>
        </thead>
        <tbody>
          <!-- Contenido dinámico -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  const tabla = document.querySelector("#tabla-Detalles tbody");

  function obtenerDatos() {
    fetch(`../../controller/DetallesController.php?task=getAll`)
      .then(response => response.json())
      .then(data => {
        tabla.innerHTML = '';
        data.forEach(element => {
          tabla.innerHTML += `
            <tr>
              <td>${element.idDetalle}</td>
              <td>${element.segmento}</td>
              <td>${element.configuracion}</td>
              <td>${element.caracteristica}</td>
              <td class="text-center">
                <a href='editarDetalles.php?id=${element.idDetalle}' class='btn btn-outline-info btn-sm me-1' title='Editar'>
                  <i class="fa-solid fa-pencil"></i>
                </a>
                <a href='#' data-iddetalle='${element.idDetalle}' class='btn btn-outline-danger btn-sm delete' title='Eliminar'>
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
        const iddetalle = enlace.getAttribute("data-iddetalle");

        Swal.fire({
          title: "¿Está seguro?",
          text: "¡Esta acción no se puede revertir!",
          icon: "warning",
          footer: 'SENATI ING. SOFTWARE',
          showCancelButton: true,
          confirmButtonColor: "#0d6efd",
          cancelButtonColor: "#6c757d",
          confirmButtonText: "Sí, eliminar",
          cancelButtonText: "Cancelar"
        }).then((result) => {
          if (result.isConfirmed) {
            fetch(`../../controller/DetallesController.php/${iddetalle}`, {
              method: 'DELETE'
            })
              .then(response => response.json())
              .then(datos => {
                if (datos.filas > 0) {
                  enlace.closest('tr').remove();
                  Swal.fire("¡Eliminado!", "El detalle ha sido eliminado correctamente.", "success");
                } else {
                  Swal.fire("Error", "No se pudo eliminar el detalle.", "error");
                }
              })
              .catch(error => {
                console.error(error);
                Swal.fire("Error", "Ocurrió un problema al eliminar el detalle.", "error");
              });
          }
        });
      }
    });
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

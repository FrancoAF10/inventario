<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gestión de Subcategorías</title>
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
  <h2 class="text-center text-primary mb-4">Gestión de Subcategorías</h2>

  <div class="text-end mb-3">
    <button id="pgaddsubcategoria" type="button" onclick="location.href='./registrarSubCategoria.php'" class="btn btn-success">
      <i class="fa-solid fa-plus me-1"></i> Nueva Subcategoría
    </button>
  </div>

  <div class="card shadow">
    <div class="card-header">SUBCATEGORÍAS REGISTRADAS</div>
    <div class="card-body table-responsive">
      <table class="table table-bordered table-hover align-middle" id="tabla-Subcategorias">
        <colgroup>
          <col style="width: 15%;">
          <col style="width: 40%;">
          <col style="width: 30%;">
          <col style="width: 15%;">
        </colgroup>
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Subcategoría</th>
            <th>Categoría</th>
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
  const tabla = document.querySelector("#tabla-Subcategorias tbody");

  function obtenerDatos() {
    fetch(`../../controller/SubCategoriaController.php?task=getAll`)
      .then(response => response.json())
      .then(data => {
        tabla.innerHTML = '';
        data.forEach(element => {
          tabla.innerHTML += `
            <tr>
              <td>${element.idSubCategoria}</td>
              <td>${element.subCategoria}</td>
              <td>${element.categoria}</td>
              <td class="text-center">
                <a href="editarSubcategoria.php?id=${element.idSubCategoria}" class="btn btn-outline-info btn-sm me-1" title="Editar">
                  <i class="fa-solid fa-pencil"></i>
                </a>
                <a href="#" class="btn btn-outline-danger btn-sm delete" data-idsubcategoria="${element.idSubCategoria}" title="Eliminar">
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
        const idsubcategoria = enlace.getAttribute("data-idsubcategoria");

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
            fetch(`../../controller/SubCategoriaController.php/${idsubcategoria}`, {
              method: 'DELETE'
            })
              .then(response => response.json())
              .then(datos => {
                if (datos.filas > 0) {
                  enlace.closest('tr').remove();
                  Swal.fire("¡Eliminado!", "La Subcategoría ha sido eliminada correctamente.", "success");
                } else {
                  Swal.fire("Error", "No se pudo eliminar la Subcategoría.", "error");
                }
              })
              .catch(error => {
                console.error(error);
                Swal.fire("Error", "Ocurrió un problema al eliminar la Subcategoría.", "error");
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

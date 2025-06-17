<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gestión de Bienes</title>

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

    th,
    td {
      vertical-align: middle;
    }
  </style>
</head>

<body>
  <?php include_once(__DIR__ . '/../../layouts/navbar.php'); ?>

  <div class="container my-5">
    <h2 class="text-center text-primary mb-4">Gestión de Bienes</h2>

    <div class="text-end mb-3">
      <button id="pgaddBien" type="button" onclick="window.location.href='./agregarBien.php'"
        class="btn btn-success">
        <i class="fa-solid fa-plus me-1"></i> Nuevo Bien
      </button>
    </div>

    <div class="card shadow">
      <div class="card-header">BIENES REGISTRADOS</div>
      <div class="card-body table-responsive">
        <table class="table table-bordered table-hover align-middle" id="tabla-bienes">
          <colgroup>
            <col style="width: 5%;">
            <col style="width: 10%;">
            <col style="width: 10%;">
            <col style="width: 10%;">
            <col style="width: 20%;">
            <col style="width: 10%;">
            <col style="width: 15%;">
            <col style="width: 15%;">
            <col style="width: 5%;">
          </colgroup>
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Marca</th>
              <th>Modelo</th>
              <th>N° Serie</th>
              <th>Descripción</th>
              <th>Condición</th>
              <th>Fotografía</th>
              <th>Usuario</th>
              <th class="text-center">Acciones</th>
            </tr>
          </thead>

          <tbody>
            <!-- Contenido de forma dinámica -->
          </tbody>

        </table>
      </div>
    </div>
  </div>

  <script>
    const tablabien = document.querySelector("#tabla-bienes tbody");

    function obtenerDatos() {
      fetch(`../../controller/BienController.php?task=getAll`, {
        method: 'GET'
      })
        .then(response => response.json())
        .then(data => {
          tablabien.innerHTML = ``;
          data.forEach(element => {
            const srcImagen = element.fotografia;

            tablabien.innerHTML += `
              <tr>
                <td>${element.idBien}</td>
                <td>${element.marca}</td>
                <td>${element.modelo}</td>
                <td>${element.numSerie}</td>
                <td>${element.descripcion}</td>   
                <td>${element.condicion}</td>
                <td><img src="${srcImagen}" alt="Fotografía" width="100"></td>
                <td>${element.nomUser}</td>
                <td class="text-center">
                  <a href='editarBien.php?id=${element.idBien}' title='Editar' class='btn btn-outline-info btn-sm me-1'>
                    <i class="fa-solid fa-pencil"></i>
                  </a>
                  <a href='#' title='Eliminar' data-idbien='${element.idBien}' class='btn btn-outline-danger btn-sm delete'>
                    <i class="fa-solid fa-trash"></i>
                  </a>
                </td>
              </tr>
            `;
          });
        })
        .catch(error => {
          console.error(error);
        });
    }

    document.addEventListener("DOMContentLoaded", () => {
      obtenerDatos();

      tablabien.addEventListener("click", (event) => {
        const enlace = event.target.closest("a");
        if (enlace && enlace.classList.contains("delete")) {
          event.preventDefault();
          const idbien = enlace.getAttribute("data-idbien");

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
              fetch(`../../controller/BienController.php/${idbien}`, {
                method: 'DELETE'
              })
                .then(response => response.json())
                .then(datos => {
                  if (datos.filas > 0) {
                    const filaEliminar = enlace.closest('tr');
                    if (filaEliminar) filaEliminar.remove();

                    Swal.fire({
                      icon: 'success',
                      title: '¡Eliminado!',
                      text: 'El Bien ha sido eliminado correctamente.'
                    });
                  } else {
                    Swal.fire({
                      icon: 'error',
                      title: 'Error',
                      text: 'No se pudo eliminar el Bien.'
                    });
                  }
                })
                .catch(error => {
                  console.error(error);
                  Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un problema al eliminar el Bien.'
                  });
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

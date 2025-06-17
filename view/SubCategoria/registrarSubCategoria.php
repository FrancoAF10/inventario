<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Registrar Subcategoría</title>

  <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer"/>

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
      <h2 class="text-primary">Registrar Nueva Subcategoría</h2>
      <button type="button" onclick="window.location.href='./ListarSubCategorias.php'" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Volver
      </button>
    </div>

    <form autocomplete="off" id="formulario-registrar">
      <div class="card">
        <div class="card-header bg-primary text-white">
          <strong>Formulario de Registro</strong>
        </div>
        <div class="card-body">
          <div class="form-floating mb-3">
            <select id="categoriaSelect" class="form-select" required>
              <option value="">Selecciona una categoría</option>
            </select>
            <label for="categoriaSelect">Seleccionar Categoría</label>
          </div>
          <div class="form-floating mb-3">
            <input
              type="text"
              id="subCategoria"
              name="subcategoria"
              class="form-control"
              placeholder="Subcategoría"
              required
            />
            <label for="subCategoria">Nombre de la Subcategoría</label>
          </div>
        </div>
        <div class="card-footer text-end">
          <button class="btn btn-primary" id="addSubcategoria" type="submit">
            <i class="fa-solid fa-check me-1"></i> Registrar Subcategoría
          </button>
        </div>
      </div>
    </form>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const categoriaSelect = document.querySelector("#categoriaSelect");

      // Obtener las categorías al cargar la página
      fetch("../../controller/SubCategoriaController.php?task=getCategorias")
        .then((response) => response.json())
        .then((data) => {
          categoriaSelect.innerHTML = '<option value="">Selecciona una categoría</option>';
          data.forEach((categoria) => {
            categoriaSelect.innerHTML += `<option value="${categoria.idCategoria}">${categoria.categoria}</option>`;
          });
        })
        .catch((error) => {
          console.error(error);
        });
    });

    const formulario = document.querySelector("#formulario-registrar");

    function registrarSubCategoria() {
      fetch(`../../controller/SubCategoriaController.php`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          subCategoria: document.querySelector("#subCategoria").value,
          idCategoria: parseInt(document.querySelector("#categoriaSelect").value),
        }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.filas > 0) {
            formulario.reset();
            Swal.fire({
              icon: "success",
              title: "Subcategoría registrada",
              text: "La nueva subcategoría se registró correctamente.",
              footer: "SENATI ING. SOFTWARE",
              confirmButtonColor: "#198754",
            }).then(() => {
              window.location.href = "./ListarSubCategorias.php";
            });
          } else {
            Swal.fire({
              icon: "warning",
              title: "Sin cambios",
              text: "No se realizó el registro.",
              confirmButtonColor: "#ffc107",
            });
          }
        })
        .catch((error) => {
          console.error(error);
          Swal.fire({
            icon: "error",
            title: "Error del servidor",
            text: "No se pudo registrar la subcategoría.",
            confirmButtonColor: "#dc3545",
          });
        });
    }

    formulario.addEventListener("submit", function (event) {
      event.preventDefault();

      Swal.fire({
        title: "¿Registrar Subcategoría?",
        text: "Confirme si desea registrar la nueva subcategoría.",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#0d6efd",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Registrar",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.isConfirmed) {
          registrarSubCategoria();
        }
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
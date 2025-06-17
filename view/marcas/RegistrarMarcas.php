<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Registrar Marca</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

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
      <h2 class="text-primary">Registrar Nueva Marca</h2>
      <button type="button" onclick="window.location.href='./ListarMarcas.php'" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Volver
      </button>
    </div>

    <form autocomplete="off" id="formulario-registrarMarca">
      <div class="card">
        <div class="card-header bg-primary text-white">
          <strong>Formulario de Registro</strong>
        </div>
        <div class="card-body">
          <div class="mb-3 form-floating">
            <select id="categoria" name="categoria" class="form-select" required>
              <option value="">Seleccione una categoría</option>
            </select>
            <label for="categoria">Categoría</label>
          </div>

          <div class="mb-3 form-floating">
            <select id="subcategoria" name="subcategoria" class="form-select" required>
              <option value="">Seleccione una Subcategoría</option>
            </select>
            <label for="subcategoria">Subcategoría</label>
          </div>

          <div class="mb-3 form-floating">
            <input type="text" id="marca" name="marca" class="form-control" placeholder="Marca" required />
            <label for="marca">Marca</label>
          </div>
        </div>
        <div class="card-footer text-end">
          <button type="submit" class="btn btn-primary" id="addMarca">
            <i class="fa-solid fa-check me-1"></i> Registrar Marca
          </button>
        </div>
      </div>
    </form>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const categoriaSelect = document.querySelector("#categoria");
      const subCategoriaSelect = document.querySelector("#subcategoria");

      // Cargar Categorías
      fetch("../../controller/MarcaController.php?task=getCategorias")
        .then((response) => response.json())
        .then((data) => {
          data.forEach((categoria) => {
            categoriaSelect.innerHTML += `<option value="${categoria.idCategoria}">${categoria.categoria}</option>`;
          });
        });

      // Al seleccionar categoría, cargar subcategorías
      categoriaSelect.addEventListener("change", () => {
        const idCategoria = categoriaSelect.value;
        subCategoriaSelect.innerHTML = '<option value="">Seleccione una Subcategoría</option>';

        if (idCategoria) {
          fetch(`../../controller/MarcaController.php?task=getsubCategorias&idCategoria=${idCategoria}`)
            .then((response) => response.json())
            .then((data) => {
              data.forEach((subcategoria) => {
                subCategoriaSelect.innerHTML += `<option value="${subcategoria.idSubCategoria}">${subcategoria.subCategoria}</option>`;
              });
            });
        }
      });
    });

    const formulario = document.querySelector("#formulario-registrarMarca");

    function registrarMarca() {
      fetch(`../../controller/MarcaController.php`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          marca: document.querySelector("#marca").value,
          idSubCategoria: parseInt(document.querySelector("#subcategoria").value),
        }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.filas > 0) {
            formulario.reset();
            Swal.fire({
              icon: "success",
              title: "Marca registrada",
              text: "La nueva marca se registró correctamente.",
              footer: "SENATI ING. SOFTWARE",
              confirmButtonColor: "#198754",
            }).then(() => {
              window.location.href = "./ListarMarcas.php";
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
            text: "No se pudo registrar la marca.",
            confirmButtonColor: "#dc3545",
          });
        });
    }

    formulario.addEventListener("submit", (event) => {
      event.preventDefault();

      Swal.fire({
        title: "¿Registrar Marca?",
        text: "Confirme si desea registrar la nueva marca.",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#0d6efd",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Registrar",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.isConfirmed) {
          registrarMarca();
        }
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>

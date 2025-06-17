<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Actualizar Marca</title>

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
    .card {
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
    <h2 class="text-primary">Actualizar Marca</h2>
    <button onclick="window.location.href='./ListarMarcas.php'" class="btn btn-outline-secondary">
      <i class="fa-solid fa-arrow-left me-1"></i> Volver
    </button>
  </div>

  <form id="formulario-registrarMarca" autocomplete="off">
    <div class="card">
      <div class="card-header bg-info text-white">
        <strong>Formulario de Actualización</strong>
      </div>

      <input type="hidden" id="idmarca" name="idmarca" />

      <div class="card-body">
        <div class="form-floating mb-3">
          <select id="categoria" name="categoria" class="form-select" required>
            <option value="">Seleccione una categoría</option>
          </select>
          <label for="categoria">Categoría</label>
        </div>

        <div class="form-floating mb-3">
          <select id="subcategoria" name="subcategoria" class="form-select" required>
            <option value="">Seleccione una Subcategoría</option>
          </select>
          <label for="subcategoria">Subcategoría</label>
        </div>

        <div class="form-floating mb-3">
          <input type="text" id="marca" name="marca" class="form-control" placeholder="Ingrese la marca" required />
          <label for="marca">Marca</label>
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
    const categoriaSelect = document.querySelector("#categoria");
    const subCategoriaSelect = document.querySelector("#subcategoria");
    const marcaInput = document.querySelector("#marca");

    const URLparams = new URLSearchParams(window.location.search);
    const idmarca = URLparams.get("id");

    if (!idmarca) {
      console.warn("No se proporcionó ID de marca.");
      return;
    }

    // Cargar Categorías
    fetch("../../controller/MarcaController.php?task=getCategorias")
      .then(res => res.json())
      .then(categorias => {
        categorias.forEach(c => {
          categoriaSelect.innerHTML += `<option value="${c.idCategoria}">${c.categoria}</option>`;
        });
        obtenerRegistro(); 
      });

    // Cargar Subcategorías según categoría
    categoriaSelect.addEventListener("change", () => {
      const idCategoria = categoriaSelect.value;
      subCategoriaSelect.innerHTML = '<option value="">Seleccione una Subcategoría</option>';

      fetch(`../../controller/MarcaController.php?task=getsubCategorias&idCategoria=${idCategoria}`)
        .then(res => res.json())
        .then(subcategorias => {
          subcategorias.forEach(s => {
            subCategoriaSelect.innerHTML += `<option value="${s.idSubCategoria}">${s.subCategoria}</option>`;
          });
        });
    });

    // Obtener datos de la marca
    function obtenerRegistro() {
      const parametros = new URLSearchParams();
      parametros.append("task", "getById");
      parametros.append("idMarca", idmarca);

      fetch(`../../controller/MarcaController.php?${parametros}`)
        .then(res => res.json())
        .then(data => {
          if (data.length > 0) {
            marcaInput.value = data[0].marca;
            categoriaSelect.value = data[0].idCategoria;

            fetch(`../../controller/MarcaController.php?task=getsubCategorias&idCategoria=${data[0].idCategoria}`)
              .then(res => res.json())
              .then(subcategorias => {
                subCategoriaSelect.innerHTML = '<option value="">Seleccione una Subcategoría</option>';
                subcategorias.forEach(s => {
                  subCategoriaSelect.innerHTML += `<option value="${s.idSubCategoria}">${s.subCategoria}</option>`;
                });
                subCategoriaSelect.value = data[0].idSubCategoria;
              });
          }
        })
        .catch(error => console.error("Error al obtener datos de marca:", error));
    }

    const formulario = document.getElementById('formulario-registrarMarca');
    formulario.addEventListener('submit', function (event) {
      event.preventDefault();

      const idMarca = idmarca;
      const marca = marcaInput.value.trim();
      const subcategoria = subCategoriaSelect.value;

      if (!marca || !subcategoria) {
        Swal.fire("Campos vacíos", "Por favor, complete todos los campos.", "warning");
        return;
      }

      Swal.fire({
        title: '¿Actualizar marca?',
        text: 'Esta acción modificará la información.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, actualizar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          const datos = {
            idMarca: idMarca,
            idSubCategoria: subcategoria,
            marca: marca,
          };
          fetch('../../controller/MarcaController.php', {
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
                  title: 'Actualizado',
                  text: 'Marca actualizada correctamente.',
                  icon: 'success',
                  confirmButtonColor: '#198754'
                }).then(() => {
                  window.location.href = "./ListarMarcas.php";
                });
              } else {
                Swal.fire("Sin cambios", "No se actualizó el registro.", "info");
              }
            })
            .catch(error => {
              console.error(error);
              Swal.fire("Error", "No se pudo actualizar la marca.", "error");
            });
        }
      });
    });
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"   crossorigin="anonymous"></script>

</body>
</html>

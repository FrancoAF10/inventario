<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Actualizar Subcategoría</title>

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
      <h2 class="text-primary">Actualizar Subcategoría</h2>
      <button onclick="window.location.href='./ListarSubcategorias.php'" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Volver
      </button>
    </div>

    <form id="formulario-registro" autocomplete="off">
      <div class="card">
        <div class="card-header bg-info text-white">
          <strong>Formulario de Actualización</strong>
        </div>
        <div class="card-body">
          <div class="form-floating mb-3">
            <select id="categoriaSelect" class="form-select" required>
              <option value="">Selecciona una categoría</option>
            </select>
            <label for="categoriaSelect">Seleccionar Categoría</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" id="subCategoria" name="subcategoria" class="form-control" placeholder="Subcategoría" required />
            <label for="subCategoria">Subcategoría</label>
          </div>
        </div>
        <div class="card-footer text-end">
          <button class="btn btn-primary" type="submit">
            <i class="fa-solid fa-floppy-disk me-1"></i> Guardar Cambios
          </button>
        </div>
      </div>
    </form>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      // Obtener id subcategoría de la URL
      const urlParams = new URLSearchParams(window.location.search);
      const idsubcategoria = urlParams.get("id");

      // Cargar categorías en el select
      function cargarCategorias() {
        return fetch('../../controller/SubCategoriaController.php?task=getCategorias')
          .then(res => res.json())
          .then(data => {
            const select = document.getElementById("categoriaSelect");
            data.forEach(categoria => {
              const option = document.createElement("option");
              option.value = categoria.idCategoria;
              option.textContent = categoria.categoria;
              select.appendChild(option);
            });
          });
      }

      // Obtener datos actuales de la subcategoría
      function cargarDatosSubcategoria() {
        return fetch(`../../controller/SubCategoriaController.php?task=getById&idSubCategoria=${idsubcategoria}`)
          .then(res => res.json())
          .then(data => {
            if (data.length > 0) {
              document.getElementById("subCategoria").value = data[0].subCategoria;
              document.getElementById("categoriaSelect").value = data[0].idCategoria;
            }
          });
      }

      // Ejecutar carga de categorías y luego cargar datos de la subcategoría
      cargarCategorias().then(() => cargarDatosSubcategoria());

      //envío del formulario
      document.getElementById("formulario-registro").addEventListener("submit", function (e) {
        e.preventDefault();

        const subcategoria = document.getElementById("subCategoria").value.trim();
        const idCategoria = document.getElementById("categoriaSelect").value;

        if (!subcategoria) {
          Swal.fire("Campo vacío", "Por favor ingrese una subcategoría.", "warning");
          return;
        }

        if (!idCategoria) {
          Swal.fire("Campo vacío", "Por favor seleccione una categoría.", "warning");
          return;
        }

        Swal.fire({
          title: '¿Actualizar subcategoría?',
          text: "Esta acción modificará la información.",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#0d6efd',
          cancelButtonColor: '#6c757d',
          confirmButtonText: 'Sí, actualizar',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            fetch('../../controller/SubCategoriaController.php', {
              method: 'PUT',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({ idSubCategoria: idsubcategoria, subCategoria: subcategoria, idCategoria: idCategoria })
            })
              .then(res => res.json())
              .then(data => {
                if (data.filas > 0) {
                  Swal.fire({
                    title: 'Actualizado',
                    text: 'Subcategoría actualizada correctamente.',
                    icon: 'success',
                    confirmButtonColor: '#198754'
                  }).then(() => {
                    window.location.href = "./ListarSubcategorias.php";
                  });
                } else {
                  Swal.fire("Sin cambios", "No se actualizó el registro.", "info");
                }
              })
              .catch(err => {
                console.error("Error al actualizar:", err);
                Swal.fire("Error", "No se pudo actualizar la subcategoría.", "error");
              });
          }
        });
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>

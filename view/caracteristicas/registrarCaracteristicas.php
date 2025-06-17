<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Agregar Características</title>

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
      <h2 class="text-primary">Agregar Características</h2>
      <button type="button" onclick="window.history.back()" class="btn btn-outline-secondary">
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
            <input type="text" id="segmento" name="caracteristica" class="form-control" placeholder="Segmento" required />
            <label for="segmento">Segmento</label>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <div class="form-floating">
                <select id="Categoria" class="form-select" required>
                  <option value="">Seleccione Categoría</option>
                </select>
                <label for="Categoria">Seleccionar Categoría</label>
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <div class="form-floating">
                <select id="SubCategoria" class="form-select" required>
                  <option value="">Seleccione Subcategoría</option>
                </select>
                <label for="SubCategoria">Seleccionar Subcategoría</label>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <div class="form-floating">
              <select id="marca" class="form-select" required>
                <option value="">Seleccione Marca</option>
              </select>
              <label for="marca">Seleccionar Marca</label>
            </div>
          </div>

          <div class="mb-3">
            <div class="form-floating">
              <select id="bienes" class="form-select" required>
                <option value="">Seleccione Bien</option>
              </select>
              <label for="bienes">Seleccionar Bien</label>
            </div>
          </div>
        </div>
        <div class="card-footer text-end">
          <button class="btn btn-primary" id="addCaracteristica" type="submit">
            <i class="fa-solid fa-check me-1"></i> Agregar
          </button>
        </div>
      </div>
    </form>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const categoriaSelect = document.querySelector("#Categoria");
      const subCategoriaSelect = document.querySelector("#SubCategoria");
      const marcaSelect = document.querySelector("#marca");
      const bienes = document.querySelector("#bienes");

      // Cargar Categorías
      fetch("../../controller/CaracteristicaController.php?task=getCategorias")
        .then(response => response.json())
        .then(data => {
          data.forEach(categoria => {
            categoriaSelect.innerHTML += `<option value="${categoria.idCategoria}">${categoria.categoria}</option>`;
          });
        });

      // Cargar Subcategorías al cambiar Categoría
      categoriaSelect.addEventListener("change", () => {
        const idCategoria = categoriaSelect.value;
        subCategoriaSelect.innerHTML = '<option value="">Seleccione Subcategoría</option>';
        marcaSelect.innerHTML = '<option value="">Seleccione Marca</option>';
        bienes.innerHTML = '<option value="">Seleccione Bien</option>';

        if (!idCategoria) return;

        fetch(`../../controller/CaracteristicaController.php?task=getSubCategorias&idCategoria=${idCategoria}`)
          .then(response => response.json())
          .then(data => {
            data.forEach(subcategoria => {
              subCategoriaSelect.innerHTML += `<option value="${subcategoria.idSubCategoria}">${subcategoria.subCategoria}</option>`;
            });
          })
          .catch(console.error);
      });

      // Cargar Marcas al cambiar Subcategoría
      subCategoriaSelect.addEventListener("change", () => {
        const idSubCategoria = subCategoriaSelect.value;
        marcaSelect.innerHTML = '<option value="">Seleccione Marca</option>';
        bienes.innerHTML = '<option value="">Seleccione Bien</option>';

        if (!idSubCategoria) return;

        fetch(`../../controller/CaracteristicaController.php?task=getMarcas&idSubCategoria=${idSubCategoria}`)
          .then(response => response.json())
          .then(data => {
            data.forEach(marca => {
              marcaSelect.innerHTML += `<option value="${marca.idMarca}">${marca.marca}</option>`;
            });
          })
          .catch(console.error);
      });

      // Cargar Bienes al cambiar Marca
      marcaSelect.addEventListener("change", () => {
        const idMarca = marcaSelect.value;
        bienes.innerHTML = '<option value="">Seleccione Bien</option>';

        if (!idMarca) return;

        fetch(`../../controller/CaracteristicaController.php?task=getBienesPorMarca&idMarca=${idMarca}`)
          .then(response => response.json())
          .then(data => {
            data.forEach(bien => {
              bienes.innerHTML += `<option value="${bien.idBien}">${bien.modelo} ${bien.numSerie} ${bien.descripcion}</option>`;
            });
          })
          .catch(console.error);
      });
    });

    const formulario = document.querySelector("#formulario-registrar");

    function registrarCaracteristica() {
      const idBien = parseInt(document.querySelector('#bienes').value);
      const segmento = document.querySelector("#segmento").value;

      fetch(`../../controller/CaracteristicaController.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          segmento,
          idBien,
        })
      })
        .then(response => response.json())
        .then(data => {
          if (data.filas > 0) {
            formulario.reset();
            Swal.fire({
              icon: 'success',
              title: 'Guardado',
              text: 'La característica fue registrada correctamente.',
              confirmButtonColor: '#198754'
            });
          } else {
            Swal.fire({
              icon: 'warning',
              title: 'Error',
              text: 'No se pudo guardar la característica.',
              confirmButtonColor: '#ffc107'
            });
          }
        })
        .catch(error => {
          console.error(error);
          Swal.fire({
            icon: 'error',
            title: 'Error del servidor',
            text: 'No se pudo registrar la característica.',
            confirmButtonColor: '#dc3545'
          });
        });
    }

    formulario.addEventListener("submit", function (event) {
      event.preventDefault();

      Swal.fire({
        title: '¿Registrar Característica?',
        text: 'Confirme si desea registrar la nueva característica.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Registrar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          registrarCaracteristica();
        }
      });
    });
  </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
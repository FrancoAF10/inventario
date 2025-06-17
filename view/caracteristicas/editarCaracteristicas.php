<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Editar Característica</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" />

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
      <h2 class="text-primary">Actualizar Característica</h2>
      <button onclick="window.location.href='./listarCaracteristicas.php'" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Volver
      </button>
    </div>

    <form id="formulario-registrar" autocomplete="off">
      <div class="card">
        <div class="card-header bg-info text-white">
          <strong>Formulario de Actualización</strong>
        </div>
        <div class="card-body">
          <div class="form-floating mb-3">
            <input type="text" id="segmento" name="segmento" class="form-control" placeholder="Segmento" required />
            <label for="segmento">Segmento</label>
          </div>

          <div class="row mb-3">
            <div class="col-md-6 form-floating">
              <select id="Categoria" class="form-select" required>
                <option value="">Seleccione Categoria</option>
              </select>
              <label for="Categoria">Categoría</label>
            </div>
            <div class="col-md-6 form-floating">
              <select id="SubCategoria" class="form-select" required>
                <option value="">Seleccione Subcategoría</option>
              </select>
              <label for="SubCategoria">Subcategoría</label>
            </div>
          </div>

          <div class="form-floating mb-3">
            <select id="marca" class="form-select" required>
              <option value="">Seleccione Marca</option>
            </select>
            <label for="marca">Marca</label>
          </div>

          <div class="form-floating mb-3">
            <select id="bienes" class="form-select" required>
              <option value="">Seleccione Bien</option>
            </select>
            <label for="bienes">Bien</label>
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
      const categoriaSelect = document.querySelector("#Categoria");
      const subCategoriaSelect = document.querySelector("#SubCategoria");
      const marcaSelect = document.querySelector("#marca");
      const bienesSelect = document.querySelector("#bienes");

      const params = new URLSearchParams(window.location.search);
      const idCaracteristica = params.get("id");

      // Cargar categorías
      function cargarCategorias(idSeleccionada) {
        return fetch("../../controller/CaracteristicaController.php?task=getCategorias")
          .then(res => res.json())
          .then(data => {
            categoriaSelect.innerHTML = '<option value="">Seleccione Categoria</option>';
            data.forEach(c => {
              categoriaSelect.innerHTML += `<option value="${c.idCategoria}" ${c.idCategoria == idSeleccionada ? "selected" : ""}>${c.categoria}</option>`;
            });
          });
      }

      // Cargar subcategorías
      function cargarSubCategorias(idCategoria, idSeleccionada) {
        return fetch(`../../controller/CaracteristicaController.php?task=getSubCategorias&idCategoria=${idCategoria}`)
          .then(res => res.json())
          .then(data => {
            subCategoriaSelect.innerHTML = '<option value="">Seleccione Subcategoría</option>';
            data.forEach(sc => {
              subCategoriaSelect.innerHTML += `<option value="${sc.idSubCategoria}" ${sc.idSubCategoria == idSeleccionada ? "selected" : ""}>${sc.subCategoria}</option>`;
            });
          });
      }

      // Cargar marcas
      function cargarMarcas(idSubCategoria, idSeleccionada) {
        return fetch(`../../controller/CaracteristicaController.php?task=getMarcas&idSubCategoria=${idSubCategoria}`)
          .then(res => res.json())
          .then(data => {
            marcaSelect.innerHTML = '<option value="">Seleccione Marca</option>';
            data.forEach(m => {
              marcaSelect.innerHTML += `<option value="${m.idMarca}" ${m.idMarca == idSeleccionada ? "selected" : ""}>${m.marca}</option>`;
            });
          });
      }

      // Cargar bienes
      function cargarBienes(idMarca, idSeleccionado) {
        return fetch(`../../controller/CaracteristicaController.php?task=getBienesPorMarca&idMarca=${idMarca}`)
          .then(res => res.json())
          .then(data => {
            bienesSelect.innerHTML = '<option value="">Seleccione Bien</option>';
            data.forEach(b => {
              const texto = `${b.modelo} ${b.numSerie} ${b.descripcion}`;
              bienesSelect.innerHTML += `<option value="${b.idBien}" ${b.idBien == idSeleccionado ? "selected" : ""}>${texto}</option>`;
            });
          });
      }

      // Cargar datos actuales del registro
      fetch(`../../controller/CaracteristicaController.php?task=getById&idCaracteristica=${idCaracteristica}`)
        .then(res => res.json())
        .then(data => {
          if (data.length === 0) {
            Swal.fire('Error', 'Característica no encontrada', 'error');
            return;
          }
          const caracteristica = data[0];
          document.getElementById("segmento").value = caracteristica.segmento;

          // Carga en cascada selects con selección previa
          cargarCategorias(caracteristica.idCategoria)
            .then(() => cargarSubCategorias(caracteristica.idCategoria, caracteristica.idSubCategoria))
            .then(() => cargarMarcas(caracteristica.idSubCategoria, caracteristica.idMarca))
            .then(() => cargarBienes(caracteristica.idMarca, caracteristica.idBien));
        })
        .catch(error => {
          console.error(error);
          Swal.fire('Error', 'Error al cargar los datos', 'error');
        });

      // Cambios en selects para recargar dependientes
      categoriaSelect.addEventListener("change", () => {
        const idCat = categoriaSelect.value;
        if (!idCat) {
          subCategoriaSelect.innerHTML = '<option value="">Seleccione Subcategoría</option>';
          marcaSelect.innerHTML = '<option value="">Seleccione Marca</option>';
          bienesSelect.innerHTML = '<option value="">Seleccione Bien</option>';
          return;
        }
        cargarSubCategorias(idCat, null);
        marcaSelect.innerHTML = '<option value="">Seleccione Marca</option>';
        bienesSelect.innerHTML = '<option value="">Seleccione Bien</option>';
      });

      subCategoriaSelect.addEventListener("change", () => {
        const idSubCat = subCategoriaSelect.value;
        if (!idSubCat) {
          marcaSelect.innerHTML = '<option value="">Seleccione Marca</option>';
          bienesSelect.innerHTML = '<option value="">Seleccione Bien</option>';
          return;
        }
        cargarMarcas(idSubCat, null);
        bienesSelect.innerHTML = '<option value="">Seleccione Bien</option>';
      });

      marcaSelect.addEventListener("change", () => {
        const idMarca = marcaSelect.value;
        if (!idMarca) {
          bienesSelect.innerHTML = '<option value="">Seleccione Bien</option>';
          return;
        }
        cargarBienes(idMarca, null);
      });

      // Enviar formulario para actualizar
      document.getElementById("formulario-registrar").addEventListener("submit", (e) => {
        e.preventDefault();

        const segmento = document.getElementById("segmento").value.trim();
        const idBien = bienesSelect.value;
        if (!segmento || !idBien) {
          Swal.fire('Atención', 'Debe completar todos los campos', 'warning');
          return;
        }

        Swal.fire({
          title: 'Confirmar actualización',
          text: '¿Está seguro de actualizar esta característica?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Sí, actualizar',
          cancelButtonText: 'Cancelar',
          confirmButtonColor: '#0d6efd',
          cancelButtonColor: '#6c757d'
        }).then(result => {
          if (result.isConfirmed) {
            fetch('../../controller/CaracteristicaController.php', {
              method: 'PUT',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({
                idCaracteristica,
                segmento,
                idBien
              })
            })
              .then(res => res.json())
              .then(response => {
                if (response.filas > 0) {
                  Swal.fire('Actualizado', 'La característica fue actualizada exitosamente.', 'success')
                    .then(() => window.location.href = './listarCaracteristicas.php');
                } else {
                  Swal.fire('Error', 'No se pudo actualizar la característica.', 'error');
                }
              })
              .catch(() => {
                Swal.fire('Error', 'Error en la actualización', 'error');
              });
          }
        });
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Registrar Asignación</title>

  <!-- Bootstrap CSS -->
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
      <h2 class="text-info">Registrar Nueva Asignación</h2>
      <button type="button" onclick="window.location.href='./listarAsignaciones.php'"
        class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Volver
      </button>
    </div>

    <form autocomplete="off" id="formulario-registrar">
      <div class="card">
        <div class="card-header bg-info text-white">
          <strong>Formulario de Registro</strong>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-4">
              <div class="form-floating">
                <select id="Categoria" class="form-select" required>
                  <option value="">Seleccionar Categoria</option>
                </select>
                <label for="Categoria">Categoría</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating">
                <select id="SubCategoria" class="form-select" required>
                  <option value="">Seleccionar Subcategoría</option>
                </select>
                <label for="SubCategoria">Subcategoría</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating">
                <select id="marca" class="form-select" required>
                  <option value="">Seleccionar Marca</option>
                </select>
                <label for="marca">Marca</label>
              </div>
            </div>
          </div>

          <div class="row g-3 mt-3">
            <div class="col-12">
              <div class="form-floating">
                <select id="bienes" class="form-select" required>
                  <option value="">Seleccionar Bien</option>
                </select>
                <label for="bienes">Bien</label>
              </div>
            </div>
          </div>

          <div class="row g-3 mt-3">
            <div class="col-12">
              <div class="form-floating">
                <select id="colaboradores" class="form-select" required>
                  <option value="">Seleccionar Colaborador</option>
                </select>
                <label for="colaboradores">Colaborador</label>
              </div>
            </div>
          </div>

          <div class="row g-3 mt-3">
            <div class="col-md-6">
              <div class="form-floating">
                <input type="date" class="form-control" id="inicio" name="inicio" required />
                <label for="inicio">Fecha Inicio</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating">
                <input type="date" class="form-control" id="fin" name="fin" />
                <label for="fin">Fecha Final</label>
              </div>
            </div>
          </div>
        </div>

        <div class="card-footer text-end">
          <button type="submit" class="btn btn-info" id="addAsignaciones">
            <i class="fa-solid fa-check me-1"></i> Registrar Asignación
          </button>
        </div>
      </div>
    </form>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const colaboradores = document.querySelector("#colaboradores");
      const bienes = document.querySelector("#bienes");
      const categoriaSelect = document.querySelector("#Categoria");
      const subCategoriaSelect = document.querySelector("#SubCategoria");
      const marcaSelect = document.querySelector("#marca");

      // Cargar Colaboradores
      fetch("../../controller/AsignacionesController.php?task=getColaboradores")
        .then((res) => res.json())
        .then((data) => {
          data.forEach((colaborador) => {
            colaboradores.innerHTML += `<option value="${colaborador.idColaborador}">${colaborador.nombres} ${colaborador.apellidos}</option>`;
          });
        })
        .catch(console.error);

      // Cargar Categorías
      fetch("../../controller/AsignacionesController.php?task=getCategorias")
        .then((res) => res.json())
        .then((data) => {
          data.forEach((categoria) => {
            categoriaSelect.innerHTML += `<option value="${categoria.idCategoria}">${categoria.categoria}</option>`;
          });
        });

      // Cargar subcategorías cuando se haya seleccionado una categoría
      categoriaSelect.addEventListener("change", () => {
        const idCategoria = categoriaSelect.value;
        subCategoriaSelect.innerHTML = '<option value="">Seleccionar Subcategoría</option>';
        marcaSelect.innerHTML = '<option value="">Seleccionar Marca</option>';
        bienes.innerHTML = '<option value="">Seleccionar Bien</option>';

        if (idCategoria) {
          fetch(`../../controller/AsignacionesController.php?task=getSubCategorias&idCategoria=${idCategoria}`)
            .then((res) => res.json())
            .then((data) => {
              data.forEach((subcat) => {
                subCategoriaSelect.innerHTML += `<option value="${subcat.idSubCategoria}">${subcat.subCategoria}</option>`;
              });
            })
            .catch(console.error);
        }
      });

      // Seleccionado subcategoría, cargamos las marcas
      subCategoriaSelect.addEventListener("change", () => {
        const idSubCategoria = subCategoriaSelect.value;
        marcaSelect.innerHTML = '<option value="">Seleccionar Marca</option>';
        bienes.innerHTML = '<option value="">Seleccionar Bien</option>';

        if (idSubCategoria) {
          fetch(`../../controller/AsignacionesController.php?task=getMarcas&idSubCategoria=${idSubCategoria}`)
            .then((res) => res.json())
            .then((data) => {
              data.forEach((marca) => {
                marcaSelect.innerHTML += `<option value="${marca.idMarca}">${marca.marca}</option>`;
              });
            })
            .catch(console.error);
        }
      });

      //Seleccionando las marcas, cargamos bienes
      marcaSelect.addEventListener("change", () => {
        const idMarca = marcaSelect.value;
        bienes.innerHTML = '<option value="">Seleccionar Bien</option>';

        if (idMarca) {
          fetch(`../../controller/AsignacionesController.php?task=getBienesPorMarca&idMarca=${idMarca}`)
            .then((res) => res.json())
            .then((data) => {
              data.forEach((bien) => {
                bienes.innerHTML += `<option value="${bien.idBien}">${bien.modelo} ${bien.numSerie} ${bien.descripcion}</option>`;
              });
            })
            .catch(console.error);
        }
      });
    });

    const formulario = document.querySelector("#formulario-registrar");

    function registrarAsignaciones() {
      const idBien = parseInt(document.querySelector("#bienes").value);
      const idColaborador = parseInt(document.querySelector("#colaboradores").value);
      const inicio = document.querySelector("#inicio").value;
      const fin = document.querySelector("#fin").value;

      fetch(`../../controller/AsignacionesController.php`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          idBien,
          idColaborador,
          inicio,
          fin,
        }),
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.filas > 0) {
            formulario.reset();
            Swal.fire({
              title: "CONFIRMADO",
              text: "Asignación Registrada",
              icon: "success",
              footer: "SENATI ING. SOFTWARE",
              confirmButtonText: "OK",
              confirmButtonColor: "#198754", 
            });
          } else {
            Swal.fire({
              icon: 'warning',
              title: 'Sin cambios',
              text: 'No se realizó el registro.',
              confirmButtonColor: '#ffc107'
            });
          }
        })
        .catch((error) => {
          console.error(error);
          Swal.fire({
            icon: "error",
            title: "Error del servidor",
            text: "No se pudo registrar la asignación.",
            confirmButtonColor: "#dc3545",
          });
        });
    }

    formulario.addEventListener("submit", (event) => {
      event.preventDefault();

      Swal.fire({
        title: "¿Registrar Asignación?",
        text: "Confirme si desea registrar la nueva asignación.",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#0d6efd",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Registrar",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.isConfirmed) {
          registrarAsignaciones();
        }
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>

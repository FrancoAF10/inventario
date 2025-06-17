<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Actualizar Asignación</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
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
      <h2 class="text-primary">Actualizar Asignación</h2>
      <button onclick="window.location.href='./listarAsignaciones.php'" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Volver
      </button>
    </div>

    <form id="formulario-registrar" autocomplete="off">
      <input type="hidden" id="idAsignacion" name="idAsignacion" />
      <div class="card">
        <div class="card-header bg-info text-white">
          <strong>Formulario de Actualización</strong>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-6">
              <div class="form-floating">
                <select id="Categoria" name="Categoria" class="form-select" required>
                  <option value="">Seleccionar Categoría</option>
                </select>
                <label for="Categoria">Categoría</label>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-floating">
                <select id="SubCategoria" name="SubCategoria" class="form-select" required>
                  <option value="">Seleccionar SubCategoría</option>
                </select>
                <label for="SubCategoria">SubCategoría</label>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-floating">
                <select id="Marca" name="Marca" class="form-select" required>
                  <option value="">Seleccionar Marca</option>
                </select>
                <label for="Marca">Marca</label>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-floating">
                <select id="Bienes" name="Bienes" class="form-select" required>
                  <option value="">Seleccionar Bien</option>
                </select>
                <label for="Bienes">Bien</label>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-floating">
                <select id="Colaboradores" name="Colaboradores" class="form-select" required>
                  <option value="">Seleccionar Colaborador</option>
                </select>
                <label for="Colaboradores">Colaborador</label>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-floating">
                <input type="date" id="Inicio" name="Inicio" class="form-control" required />
                <label for="Inicio">Fecha Inicio</label>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-floating">
                <input type="date" id="Fin" name="Fin" class="form-control" />
                <label for="Fin">Fecha Fin</label>
              </div>
            </div>
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
      const categoriaSelect = document.getElementById("Categoria");
      const subCategoriaSelect = document.getElementById("SubCategoria");
      const marcaSelect = document.getElementById("Marca");
      const bienesSelect = document.getElementById("Bienes");
      const colaboradoresSelect = document.getElementById("Colaboradores");

      // Cargar colaboradores
      fetch("../../controller/AsignacionesController.php?task=getColaboradores")
        .then(res => res.json())
        .then(data => {
          colaboradoresSelect.innerHTML = '<option value="">Seleccionar Colaborador</option>';
          data.forEach(c => {
            colaboradoresSelect.innerHTML += `<option value="${c.idColaborador}">${c.nombres} ${c.apellidos}</option>`;
          });
        });

      // Cargar categorías
      fetch("../../controller/AsignacionesController.php?task=getCategorias")
        .then(res => res.json())
        .then(data => {
          categoriaSelect.innerHTML = '<option value="">Seleccionar Categoría</option>';
          data.forEach(c => {
            categoriaSelect.innerHTML += `<option value="${c.idCategoria}">${c.categoria}</option>`;
          });
        });

      // Cargar subcategorías según categoría
      function cargarSubCategorias(idCategoria, selectedSubCat = null) {
        subCategoriaSelect.innerHTML = '<option value="">Seleccionar SubCategoría</option>';
        if (!idCategoria) return;

        fetch(`../../controller/AsignacionesController.php?task=getSubCategorias&idCategoria=${idCategoria}`)
          .then(res => res.json())
          .then(data => {
            data.forEach(sc => {
              subCategoriaSelect.innerHTML += `<option value="${sc.idSubCategoria}">${sc.subCategoria}</option>`;
            });
            if (selectedSubCat) {
              subCategoriaSelect.value = selectedSubCat;
            }
          });
      }

      // Cargar marcas según subcategoría
      function cargarMarcas(idSubCategoria, selectedMarca = null) {
        marcaSelect.innerHTML = '<option value="">Seleccionar Marca</option>';
        if (!idSubCategoria) return;

        fetch(`../../controller/AsignacionesController.php?task=getMarcas&idSubCategoria=${idSubCategoria}`)
          .then(res => res.json())
          .then(data => {
            data.forEach(m => {
              marcaSelect.innerHTML += `<option value="${m.idMarca}">${m.marca}</option>`;
            });
            if (selectedMarca) {
              marcaSelect.value = selectedMarca;
            }
          });
      }

      // Cargar bienes según marca
      function cargarBienes(idMarca, selectedBien = null) {
        bienesSelect.innerHTML = '<option value="">Seleccionar Bien</option>';
        if (!idMarca) return;

        fetch(`../../controller/AsignacionesController.php?task=getBienesPorMarca&idMarca=${idMarca}`)
          .then(res => res.json())
          .then(data => {
            data.forEach(b => {
              bienesSelect.innerHTML += `<option value="${b.idBien}">${b.modelo} ${b.numSerie} ${b.descripcion}</option>`;
            });
            if (selectedBien) {
              bienesSelect.value = selectedBien;
            }
          });
      }

      // Eventos para selects dependientes
      categoriaSelect.addEventListener("change", () => {
        cargarSubCategorias(categoriaSelect.value);
        marcaSelect.innerHTML = '<option value="">Seleccionar Marca</option>';
        bienesSelect.innerHTML = '<option value="">Seleccionar Bien</option>';
      });

      subCategoriaSelect.addEventListener("change", () => {
        cargarMarcas(subCategoriaSelect.value);
        bienesSelect.innerHTML = '<option value="">Seleccionar Bien</option>';
      });

      marcaSelect.addEventListener("change", () => {
        cargarBienes(marcaSelect.value);
      });

      // Cargamos los datos para editar
      function cargarRegistro() {
        const params = new URLSearchParams(window.location.search);
        const idAsignacion = params.get("id");
        if (!idAsignacion) return;

        fetch(`../../controller/AsignacionesController.php?task=getById&idAsignacion=${idAsignacion}`)
          .then(res => res.json())
          .then(data => {
            if (data.length === 0) return;

            const registro = data[0];
            document.getElementById("idAsignacion").value = registro.idAsignacion;
            document.getElementById("Inicio").value = registro.inicio;
            document.getElementById("Fin").value = registro.fin;
            document.getElementById("Colaboradores").value = registro.idColaborador;

            const idCategoria = registro.idCategoria;
            const idSubCategoria = registro.idSubCategoria;
            const idMarca = registro.idMarca;
            const idBien = registro.idBien;

            if (idCategoria) {
              categoriaSelect.value = idCategoria;
              cargarSubCategorias(idCategoria, idSubCategoria);
              if (idSubCategoria) {
                cargarMarcas(idSubCategoria, idMarca);
                if (idMarca) {
                  cargarBienes(idMarca, idBien);
                }
              }
            } else {
              bienesSelect.value = idBien;
            }
          })
          .catch(() => {
            Swal.fire("Error", "No se pudo cargar la información.", "error");
          });
      }

      cargarRegistro();

      // mandamos el formulario
      document.getElementById("formulario-registrar").addEventListener("submit", (e) => {
        e.preventDefault();

        const idAsignacion = document.getElementById("idAsignacion").value;
        const inicio = document.getElementById("Inicio").value;
        const fin = document.getElementById("Fin").value;
        const idBien = document.getElementById("Bienes").value;
        const idColaborador = document.getElementById("Colaboradores").value;
        // Cargar datos para la edición
function cargarRegistro() {
  const params = new URLSearchParams(window.location.search);
  const idAsignacion = params.get("id");
  if (!idAsignacion) return;

  fetch(`../../controller/AsignacionesController.php?task=getById&idAsignacion=${idAsignacion}`)
    .then(res => res.json())
    .then(data => {
      if (data.length === 0) return;

      const registro = data[0];
      document.getElementById("idAsignacion").value = registro.idAsignacion;
      document.getElementById("Inicio").value = registro.inicio;
      document.getElementById("Fin").value = registro.fin;
      document.getElementById("Colaboradores").value = registro.idColaborador;

      const idCategoria = registro.idCategoria;
      const idSubCategoria = registro.idSubCategoria;
      const idMarca = registro.idMarca;
      const idBien = registro.idBien;

      if (idCategoria) {
        document.getElementById("Categoria").value = idCategoria;
        cargarSubCategorias(idCategoria, idSubCategoria, () => {
          if (idSubCategoria) {
            cargarMarcas(idSubCategoria, idMarca, () => {
              if (idMarca) {
                cargarBienes(idMarca, idBien);
              }
            });
          }
        });
      }
    })
    .catch(() => {
      Swal.fire("Error", "No se pudo cargar la información.", "error");
    });
}

// Modificar la función cargarSubCategorias para aceptar callback
function cargarSubCategorias(idCategoria, selectedSubCat = null, callback = null) {
  const subCategoriaSelect = document.getElementById("SubCategoria");
  subCategoriaSelect.innerHTML = '<option value="">Seleccionar SubCategoría</option>';
  if (!idCategoria) return;

  fetch(`../../controller/AsignacionesController.php?task=getSubCategorias&idCategoria=${idCategoria}`)
    .then(res => res.json())
    .then(data => {
      data.forEach(sc => {
        subCategoriaSelect.innerHTML += `<option value="${sc.idSubCategoria}">${sc.subCategoria}</option>`;
      });
      if (selectedSubCat) {
        subCategoriaSelect.value = selectedSubCat;
      }
      if (callback) callback();
    });
}

// Modificamos la función cargarMarcas para aceptar callback
function cargarMarcas(idSubCategoria, selectedMarca = null, callback = null) {
  const marcaSelect = document.getElementById("Marca");
  marcaSelect.innerHTML = '<option value="">Seleccionar Marca</option>';
  if (!idSubCategoria) return;

  fetch(`../../controller/AsignacionesController.php?task=getMarcas&idSubCategoria=${idSubCategoria}`)
    .then(res => res.json())
    .then(data => {
      data.forEach(m => {
        marcaSelect.innerHTML += `<option value="${m.idMarca}">${m.marca}</option>`;
      });
      if (selectedMarca) {
        marcaSelect.value = selectedMarca;
      }
      if (callback) callback();
    });
}

// función para cargar el bien
function cargarBienes(idMarca, selectedBien = null) {
  const bienesSelect = document.getElementById("Bienes");
  bienesSelect.innerHTML = '<option value="">Seleccionar Bien</option>';
  if (!idMarca) return;

  fetch(`../../controller/AsignacionesController.php?task=getBienesPorMarca&idMarca=${idMarca}`)
    .then(res => res.json())
    .then(data => {
      data.forEach(b => {
        bienesSelect.innerHTML += `<option value="${b.idBien}">${b.modelo} ${b.numSerie} ${b.descripcion}</option>`;
      });
      if (selectedBien) {
        bienesSelect.value = selectedBien;
      }
    });
}

        if (!inicio || !idBien || !idColaborador) {
          Swal.fire("Campos incompletos", "Por favor completa todos los campos obligatorios.", "warning");
          return;
        }

        Swal.fire({
          title: "¿Actualizar asignación?",
          text: "Esta acción modificará la información.",
          icon: "question",
          showCancelButton: true,
          confirmButtonColor: "#0d6efd",
          cancelButtonColor: "#6c757d",
          confirmButtonText: "Sí, actualizar",
          cancelButtonText: "Cancelar"
        }).then((result) => {
          if (result.isConfirmed) {
            const datos = {
              idAsignacion: idAsignacion,
              inicio: inicio,
              fin: fin,
              idBien: idBien,
              idColaborador: idColaborador,
            };

            fetch("../../controller/AsignacionesController.php", {
              method: "PUT",
              headers: {
                "Content-Type": "application/json",
              },
              body: JSON.stringify(datos),
            })
              .then((res) => res.json())
              .then((data) => {
                if (data.filas > 0) {
                  Swal.fire({
                    title: "Actualizado",
                    text: "Asignación actualizada correctamente.",
                    icon: "success",
                    confirmButtonColor: "#198754",
                  }).then(() => {
                    window.location.href = "./listarAsignaciones.php";
                  });
                } else {
                  Swal.fire("Sin cambios", "No se actualizó el registro.", "info");
                }
              })
              .catch(() => {
                Swal.fire("Error", "No se pudo actualizar la asignación.", "error");
              });
          }
        });
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>

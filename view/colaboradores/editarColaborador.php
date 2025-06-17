<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Actualizar Colaborador</title>

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
    <h2 class="text-primary">Actualizar Colaborador</h2>
    <button onclick="window.location.href='./listarColaboradores.php'" class="btn btn-outline-secondary">
      <i class="fa-solid fa-arrow-left me-1"></i> Volver
    </button>
  </div>

  <form id="form-actualizar-colaborador" autocomplete="off">
    <div class="card">
      <div class="card-header bg-info text-white">
        <strong>Formulario de Actualización</strong>
      </div>
      <div class="card-body">

        <div class="form-floating mb-3">
          <select id="persona" class="form-select" required>
            <option value="">Seleccione Persona</option>
          </select>
          <label for="persona">Seleccionar Persona</label>
        </div>

        <div class="form-floating mb-3">
          <select id="areas" class="form-select" required>
            <option value="">Seleccione Área</option>
          </select>
          <label for="areas">Seleccionar Área</label>
        </div>

        <div class="form-floating mb-3">
          <select id="rol" class="form-select" required>
            <option value="">Seleccione Rol</option>
          </select>
          <label for="rol">Seleccionar Rol</label>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <div class="form-floating">
              <input type="date" class="form-control" id="fechainicio" required>
              <label for="fechainicio">Fecha Inicio</label>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="form-floating">
              <input type="date" class="form-control" id="fechafin" >
              <label for="fechafin">Fecha Fin</label>
            </div>
          </div>
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
    const urlParams = new URLSearchParams(window.location.search);
    const idcolaborador = urlParams.get("id");

    const personaSelect = document.getElementById("persona");
    const areaSelect = document.getElementById("areas");
    const rolSelect = document.getElementById("rol");

    function cargarSelect(url, element, idCampo, textoCampo) {
      fetch(url)
        .then(res => res.json())
        .then(data => {
          data.forEach(item => {
            const option = document.createElement("option");
            option.value = item[idCampo];
            option.textContent = item[textoCampo];
            element.appendChild(option);
          });
        });
    }

    function obtenerColaborador() {
      fetch(`../../controller/ColaboradorController.php?task=getById&idColaborador=${idcolaborador}`)
        .then(res => res.json())
        .then(data => {
          if (data.length > 0) {
            document.getElementById("fechainicio").value = data[0].inicio;
            document.getElementById("fechafin").value = data[0].fin;
            personaSelect.value = data[0].idPersona;
            areaSelect.value = data[0].idArea;
            rolSelect.value = data[0].idRol;
          }
        });
    }

    cargarSelect("../../controller/ColaboradorController.php?task=getPersonas", personaSelect, "idPersona", "apellidos");
    cargarSelect("../../controller/ColaboradorController.php?task=getAreas", areaSelect, "idArea", "area");
    cargarSelect("../../controller/ColaboradorController.php?task=getRoles", rolSelect, "idRol", "rol");

    obtenerColaborador();

    document.getElementById("form-actualizar-colaborador").addEventListener("submit", (e) => {
      e.preventDefault();

      const datos = {
        idColaborador: idcolaborador,
        inicio: document.getElementById("fechainicio").value,
        fin: document.getElementById("fechafin").value,
        idPersona: personaSelect.value,
        idArea: areaSelect.value,
        idRol: rolSelect.value
      };

      Swal.fire({
        title: '¿Actualizar colaborador?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, actualizar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#0d6efd'
      }).then((result) => {
        if (result.isConfirmed) {
          fetch("../../controller/ColaboradorController.php", {
            method: "PUT",
            headers: {
              "Content-Type": "application/json"
            },
            body: JSON.stringify(datos)
          })
          .then(res => res.json())
          .then(data => {
            if (data.filas > 0) {
              Swal.fire("Actualizado", "Colaborador actualizado correctamente", "success")
                .then(() => window.location.href = "./listarColaboradores.php");
            } else {
              Swal.fire("Sin cambios", "No se modificó ningún dato", "info");
            }
          })
          .catch(() => Swal.fire("Error", "Ocurrió un problema al actualizar", "error"));
        }
      });
    });
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

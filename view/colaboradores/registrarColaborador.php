<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Registrar Colaborador</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />

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
      <h2 class="text-primary">Registrar Colaborador</h2>
      <button type="button" onclick="window.location.href='./listarColaboradores.php'" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Volver
      </button>
    </div>

    <form autocomplete="off" id="form-registrar-colaborador" method="POST">
      <div class="card">
        <div class="card-header bg-primary text-white">
          <strong>Formulario de Registro</strong>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="form-floating">
                <select id="persona" name="persona" class="form-select" required>
                  <option value="">Seleccione Persona</option>
                </select>
                <label for="persona">Seleccionar Persona</label>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="form-floating">
                <select id="areas" name="areas" class="form-select" required>
                  <option value="">Seleccione Área</option>
                </select>
                <label for="areas">Seleccionar Área</label>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="form-floating">
                <select id="rol" name="rol" class="form-select" required>
                  <option value="">Seleccione Rol</option>
                </select>
                <label for="rol">Seleccionar Rol</label>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <div class="form-floating">
                <input type="date" id="fechainicio" name="fechainicio" class="form-control" required />
                <label for="fechainicio">Fecha Inicio</label>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-floating">
                <input type="date" id="fechafin" name="fechafin" class="form-control" />
                <label for="fechafin">Fecha Fin</label>
              </div>
            </div>
          </div>
        </div>

        <div class="card-footer text-end">
          <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-check me-1"></i> Registrar
          </button>
        </div>
      </div>
    </form>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const personaSelect = document.querySelector("#persona");
      const areasSelect = document.querySelector("#areas");
      const rolSelect = document.querySelector("#rol");

      // Cargar personas
      fetch("../../controller/ColaboradorController.php?task=getPersonas")
        .then(res => res.json())
        .then(data => {
          data.forEach(p => {
            personaSelect.innerHTML += `<option value="${p.idPersona}">${p.apellidos} ${p.nombres}</option>`;
          });
        }).catch(console.error);

      // Cargar áreas
      fetch("../../controller/ColaboradorController.php?task=getAreas")
        .then(res => res.json())
        .then(data => {
          data.forEach(a => {
            areasSelect.innerHTML += `<option value="${a.idArea}">${a.area}</option>`;
          });
        }).catch(console.error);

      // Cargar roles
      fetch("../../controller/ColaboradorController.php?task=getRoles")
        .then(res => res.json())
        .then(data => {
          data.forEach(r => {
            rolSelect.innerHTML += `<option value="${r.idRol}">${r.rol}</option>`;
          });
        }).catch(console.error);
    });

    const form = document.querySelector("#form-registrar-colaborador");

    form.addEventListener("submit", e => {
      e.preventDefault();

      Swal.fire({
        title: '¿Registrar Colaborador?',
        text: 'Confirme si desea registrar el colaborador.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Registrar',
        cancelButtonText: 'Cancelar'
      }).then(result => {
        if (result.isConfirmed) {
          registrarColaborador();
        }
      });
    });

    function registrarColaborador() {
      fetch("../../controller/ColaboradorController.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          idPersona: parseInt(document.querySelector("#persona").value),
          idArea: parseInt(document.querySelector("#areas").value),
          idRol: parseInt(document.querySelector("#rol").value),
          inicio: document.querySelector("#fechainicio").value,
          fin: document.querySelector("#fechafin").value
        })
      })
        .then(res => res.json())
        .then(data => {
          if (data.filas > 0) {
            form.reset();
            Swal.fire({
              icon: "success",
              title: "Colaborador registrado",
              text: "El colaborador se registró correctamente.",
              footer: "SENATI ING. SOFTWARE",
              confirmButtonColor: "#198754"
            });
          } else {
            Swal.fire({
              icon: "warning",
              title: "Sin cambios",
              text: "No se realizó el registro.",
              confirmButtonColor: "#ffc107"
            });
          }
        })
        .catch(error => {
          console.error(error);
          Swal.fire({
            icon: "error",
            title: "Error del servidor",
            text: "No se pudo registrar el colaborador.",
            confirmButtonColor: "#dc3545"
          });
        });
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>

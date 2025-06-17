<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Registrar Persona</title>

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
    <h2 class="text-primary">Registrar Nueva Persona</h2>
    <button type="button" onclick="window.location.href='./ListarPersonas.php'" class="btn btn-outline-secondary">
      <i class="fa-solid fa-arrow-left me-1"></i> Volver
    </button>
  </div>

  <form action="" id="formulario-personas" autocomplete="off">
    <div class="card">
      <div class="card-header bg-primary text-white">
        <strong>Formulario de Registro</strong>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6 mb-3">
            <div class="form-floating">
              <input type="text" id="apellidos" name="apellidos" class="form-control" placeholder="Apellidos" required />
              <label for="apellidos">Apellidos</label>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="form-floating">
              <input type="text" id="nombres" name="nombres" class="form-control" placeholder="Nombres" required />
              <label for="nombres">Nombres</label>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4 mb-3">
            <div class="form-floating">
              <select id="tipoDoc" name="tipoDoc" class="form-select" required>
                <option value="" disabled selected>Seleccione tipo</option>
                <option value="DNI">DNI</option>
                <option value="Carnet de Extranjería">Carnet de Extranjería</option>
                <option value="Pasaporte">Pasaporte</option>
                <option value="RUC">RUC</option>
              </select>
              <label for="tipoDoc">Tipo de Documento</label>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="form-floating">
              <input type="text" id="nroDocumento" name="nroDocumento" class="form-control" placeholder="Número de Documento" required />
              <label for="nroDocumento">Número de Documento</label>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="form-floating">
              <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Teléfono" required />
              <label for="telefono">Teléfono</label>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <div class="form-floating">
              <input type="email" id="email" name="email" class="form-control" placeholder="Correo" required />
              <label for="email">Correo Electrónico</label>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="form-floating">
              <input type="text" id="direccion" name="direccion" class="form-control" placeholder="Dirección" required />
              <label for="direccion">Dirección</label>
            </div>
          </div>
        </div>
      </div>

      <div class="card-footer text-end">
        <button type="submit" class="btn btn-primary">
          <i class="fa-solid fa-check me-1"></i> Registrar Persona
        </button>
      </div>
    </div>
  </form>
</div>

<script>
  const formulario = document.querySelector("#formulario-personas");

  function registrarPersona() {
    const persona = {
      apellidos: document.querySelector("#apellidos").value.trim(),
      nombres: document.querySelector("#nombres").value.trim(),
      tipoDoc: document.querySelector("#tipoDoc").value,
      nroDocumento: document.querySelector("#nroDocumento").value.trim(),
      telefono: document.querySelector("#telefono").value.trim(),
      email: document.querySelector("#email").value.trim(),
      direccion: document.querySelector("#direccion").value.trim(),
    };

    fetch(`../../controller/PersonasController.php`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(persona),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.filas > 0) {
          formulario.reset();
          Swal.fire({
            icon: "success",
            title: "Persona registrada",
            text: "Los datos se han guardado correctamente.",
            footer: "SENATI ING. SOFTWARE",
            confirmButtonColor: "#198754",
          }).then(() => {
            window.location.href = "./ListarPersonas.php";
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
          text: "No se pudo registrar la persona.",
          confirmButtonColor: "#dc3545",
        });
      });
  }

  formulario.addEventListener("submit", function (event) {
    event.preventDefault();

    Swal.fire({
      title: "¿Registrar Persona?",
      text: "Confirme si desea guardar los datos.",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#0d6efd",
      cancelButtonColor: "#6c757d",
      confirmButtonText: "Registrar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        registrarPersona();
      }
    });
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>

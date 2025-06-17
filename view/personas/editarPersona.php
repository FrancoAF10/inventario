<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Actualizar Persona</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
    <h2 class="text-primary">Actualizar Persona</h2>
    <button onclick="window.location.href='./ListarPersonas.php'" class="btn btn-outline-secondary">
      <i class="fa-solid fa-arrow-left me-1"></i> Volver
    </button>
  </div>

  <form id="formulario-personas" autocomplete="off">
    <div class="card">
      <div class="card-header bg-info text-white">
        <strong>Formulario de Actualización</strong>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6 mb-3">
            <div class="form-floating">
              <input type="text" id="apellidos" name="apellidos" class="form-control" placeholder="Apellidos" required>
              <label for="apellidos">Apellidos</label>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="form-floating">
              <input type="text" id="nombres" name="nombres" class="form-control" placeholder="Nombres" required>
              <label for="nombres">Nombres</label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 mb-3">
            <div class="form-floating">
              <select id="tipoDoc" name="tipoDoc" class="form-select" required>
                <option value="" disabled>Seleccione un tipo de documento</option>
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
              <input type="text" id="nroDocumento" name="nroDocumento" class="form-control" placeholder="Número de Documento" required>
              <label for="nroDocumento">N° Documento</label>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="form-floating">
              <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Teléfono" required>
              <label for="telefono">Teléfono</label>
            </div>
          </div>
        </div>
        <div class="form-floating mb-3">
          <input type="email" id="email" name="email" class="form-control" placeholder="Correo Electrónico" required>
          <label for="email">Correo Electrónico</label>
        </div>
        <div class="form-floating mb-3">
          <input type="text" id="direccion" name="direccion" class="form-control" placeholder="Dirección" required>
          <label for="direccion">Dirección</label>
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
    const id = new URLSearchParams(window.location.search).get("id");

    fetch(`../../controller/PersonasController.php?task=getById&idPersona=${id}`)
      .then(res => res.json())
      .then(data => {
        if (data.length > 0) {
          document.getElementById("apellidos").value = data[0].apellidos;
          document.getElementById("nombres").value = data[0].nombres;
          document.getElementById("tipoDoc").value = data[0].tipoDoc || "";
          document.getElementById("nroDocumento").value = data[0].nroDocumento;
          document.getElementById("telefono").value = data[0].telefono;
          document.getElementById("email").value = data[0].email;
          document.getElementById("direccion").value = data[0].direccion;
        }
      });

    document.getElementById("formulario-personas").addEventListener("submit", (e) => {
      e.preventDefault();

      Swal.fire({
        title: '¿Actualizar persona?',
        text: 'Se guardarán los cambios realizados.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Actualizar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          const data = {
            idPersona: id,
            apellidos: document.getElementById("apellidos").value,
            nombres: document.getElementById("nombres").value,
            tipoDoc: document.getElementById("tipoDoc").value,
            nroDocumento: document.getElementById("nroDocumento").value,
            telefono: document.getElementById("telefono").value,
            email: document.getElementById("email").value,
            direccion: document.getElementById("direccion").value
          };

          fetch('../../controller/PersonasController.php', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
          })
          .then(res => res.json())
          .then(data => {
            if (data.filas > 0) {
              Swal.fire('Actualizado', 'La persona fue actualizada exitosamente.', 'success')
                .then(() => window.location.href = "./ListarPersonas.php");
            } else {
              Swal.fire('Sin cambios', 'No se realizaron modificaciones.', 'info');
            }
          })
          .catch(err => {
            console.error(err);
            Swal.fire('Error', 'Hubo un problema al actualizar.', 'error');
          });
        }
      });
    });
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

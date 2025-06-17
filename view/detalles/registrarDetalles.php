<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Registrar Detalles</title>

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
      <h2 class="text-primary">Registrar Nuevo Detalle</h2>
      <button type="button" onclick="window.location.href='./listarDetalles.php'" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Volver
      </button>
    </div>

    <form autocomplete="off" id="formulario-registrar">
      <div class="card">
        <div class="card-header bg-info text-white">
          <strong>Formulario de Registro</strong>
        </div>
        <div class="card-body">
          <div class="form-floating mb-3">
            <input type="text" id="detalle" name="detalle" class="form-control" placeholder="Detalles" required />
            <label for="detalle">Detalles</label>
          </div>

          <div class="form-floating mb-3">
            <select id="caracteristica" name="caracteristica" class="form-select" required>
              <option value="">Seleccione Característica</option>
            </select>
            <label for="caracteristica">Seleccionar Característica</label>
          </div>

          <div class="form-floating mb-3">
            <select id="configuracion" name="configuracion" class="form-select" required>
              <option value="">Seleccione Configuración</option>
            </select>
            <label for="configuracion">Seleccionar Configuración</label>
          </div>
        </div>

        <div class="card-footer text-end">
          <button type="submit" class="btn btn-info" id="addDetalle">
            <i class="fa-solid fa-check me-1"></i> Registrar Detalle
          </button>
        </div>
      </div>
    </form>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const caracteristica = document.querySelector("#caracteristica");
      const configuracion = document.querySelector("#configuracion");
      const detalle=document.querySelector('#detalle');
      // Cargar características
      fetch("../../controller/DetallesController.php?task=getCaracteristica")
        .then(response => response.json())
        .then(data => {
          caracteristica.innerHTML = '<option value="">Seleccione Característica</option>';
          data.forEach(item => {
            caracteristica.innerHTML += `<option value="${item.idCaracteristica}">${item.segmento}</option>`;
          });
        })
        .catch(error => console.error(error));

      // Cargar configuraciones
      fetch("../../controller/DetallesController.php?task=getConfiguracion")
        .then(response => response.json())
        .then(data => {
          configuracion.innerHTML = '<option value="">Seleccione Configuración</option>';
          data.forEach(item => {
            configuracion.innerHTML += `<option value="${item.idConfiguracion}">${item.configuracion}</option>`;
          });
        })
        .catch(error => console.error(error));
    });

    const formulario = document.querySelector("#formulario-registrar");

    function registrarDetalle() {
      fetch(`../../controller/DetallesController.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          caracteristica: document.querySelector('#detalle').value,
          idCaracteristica: parseInt(document.querySelector('#caracteristica').value),
          idConfiguracion: parseInt(document.querySelector('#configuracion').value)
        })
      })
        .then(response => response.json())
        .then(data => {
          if (data.filas > 0) {
            formulario.reset();
            Swal.fire({
              icon: 'success',
              title: 'Detalle registrado',
              text: 'El nuevo detalle se registró correctamente.',
              footer: 'SENATI ING. SOFTWARE',
              confirmButtonColor: '#0dcaf0' // color info
            }).then(() => {
              window.location.href = "./listarDetalles.php";
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
        .catch(error => {
          console.error(error);
          Swal.fire({
            icon: 'error',
            title: 'Error del servidor',
            text: 'No se pudo registrar el detalle.',
            confirmButtonColor: '#dc3545'
          });
        });
    }

    formulario.addEventListener("submit", (e) => {
      e.preventDefault();

      Swal.fire({
        title: '¿Registrar Detalle?',
        text: 'Confirme si desea registrar el nuevo detalle.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Registrar',
        cancelButtonText: 'Cancelar'
      }).then(result => {
        if (result.isConfirmed) {
          registrarDetalle();
        }
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>
</body>

</html>

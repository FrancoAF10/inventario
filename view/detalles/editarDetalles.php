<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Actualizar Detalle</title>

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
      <h2 class="text-primary">Actualizar Detalle</h2>
      <button onclick="window.location.href='../../view/detalles/listarDetalles.php'" class="btn btn-outline-secondary">
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
            <input type="text" id="detalle" name="detalle" class="form-control" placeholder="Detalles" required />
            <label for="detalle">Detalles</label>
          </div>

          <div class="form-floating mb-3">
            <select id="caracteristica" name="caracteristica" class="form-select" required>
              <option value="">Seleccione característica</option>
            </select>
            <label for="caracteristica">Seleccionar Característica</label>
          </div>

          <div class="form-floating mb-3">
            <select id="configuracion" name="configuracion" class="form-select" required>
              <option value="">Seleccione configuración</option>
            </select>
            <label for="configuracion">Seleccionar Configuración</label>
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
      async function obtenerRegistro() {
        const urlParams = new URLSearchParams(window.location.search);
        const iddetalle = urlParams.get("id");
        let detalleData = null;

        try {
          const resDetalle = await fetch(`../../controller/DetallesController.php?task=getById&idDetalle=${iddetalle}`);
          const dataDetalle = await resDetalle.json();

          if (dataDetalle.length > 0) {
            detalleData = dataDetalle[0];
            document.getElementById("detalle").value = detalleData.caracteristica;
          }
        } catch (error) {
          console.error("Error al obtener detalle:", error);
          Swal.fire("Error", "No se pudo cargar el detalle.", "error");
        }

        // Cargar características
        try {
          const resCaracteristicas = await fetch("../../controller/DetallesController.php?task=getCaracteristica");
          const dataCaracteristicas = await resCaracteristicas.json();

          const caracteristicaSelect = document.getElementById("caracteristica");
          caracteristicaSelect.innerHTML = '<option value="">Seleccione característica</option>';
          dataCaracteristicas.forEach(item => {
            const option = document.createElement("option");
            option.value = item.idCaracteristica;
            option.textContent = item.segmento;
            caracteristicaSelect.appendChild(option);
          });

          if (detalleData) {
            caracteristicaSelect.value = detalleData.idCaracteristica;
          }
        } catch (error) {
          console.error("Error al cargar características:", error);
        }

        // Cargar configuraciones
        try {
          const resConfiguracion = await fetch("../../controller/DetallesController.php?task=getConfiguracion");
          const dataConfiguracion = await resConfiguracion.json();
          const configuracionSelect = document.getElementById("configuracion");

          configuracionSelect.innerHTML = '<option value="">Seleccione configuración</option>';
          dataConfiguracion.forEach(item => {
            const option = document.createElement("option");
            option.value = item.idConfiguracion;
            option.textContent = item.configuracion;
            configuracionSelect.appendChild(option);
          });

          if (detalleData) {
            configuracionSelect.value = detalleData.idConfiguracion;
          }
        } catch (error) {
          console.error("Error al cargar configuraciones:", error);
        }
      }

      obtenerRegistro();

      // Manejar envío del formulario
      document.getElementById("formulario-registrar").addEventListener("submit", function (e) {
        e.preventDefault();

        const idDetalle = new URLSearchParams(window.location.search).get("id");
        const caracteristica = document.getElementById("detalle").value.trim();
        const idCaracteristica = document.getElementById("caracteristica").value;
        const idConfiguracion = document.getElementById("configuracion").value;

        if (!caracteristica || !idCaracteristica || !idConfiguracion) {
          Swal.fire("Campos incompletos", "Por favor complete todos los campos.", "warning");
          return;
        }

        Swal.fire({
          title: "¿Actualizar detalle?",
          text: "Esta acción modificará la información.",
          icon: "question",
          showCancelButton: true,
          confirmButtonColor: "#0d6efd",
          cancelButtonColor: "#6c757d",
          confirmButtonText: "Sí, actualizar",
          cancelButtonText: "Cancelar",
        }).then((result) => {
          if (result.isConfirmed) {
            fetch("../../controller/DetallesController.php", {
              method: "PUT",
              headers: {
                "Content-Type": "application/json",
              },
              body: JSON.stringify({
                idDetalle,
                caracteristica,
                idCaracteristica,
                idConfiguracion,
              }),
            })
              .then((res) => res.json())
              .then((data) => {
                if (data.filas > 0) {
                  Swal.fire({
                    title: "Actualizado",
                    text: "Detalle actualizado correctamente.",
                    icon: "success",
                    confirmButtonColor: "#198754",
                  }).then(() => {
                    window.location.href = "../../view/detalles/listarDetalles.php";
                  });
                } else {
                  Swal.fire("Sin cambios", "No se actualizó el registro.", "info");
                }
              })
              .catch((error) => {
                console.error("Error al actualizar:", error);
                Swal.fire("Error", "No se pudo actualizar el detalle.", "error");
              });
          }
        });
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"  integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>
</body>

</html>
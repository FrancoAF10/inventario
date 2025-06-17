<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Actualizar Configuración</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
      <h2 class="text-primary">Actualizar Configuración</h2>
      <button onclick="window.location.href='./listarConfiguracion.php'" class="btn btn-outline-secondary">
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
            <input type="text" id="configuraciones" name="configuraciones" class="form-control"
              placeholder="Configuración" required />
            <label for="configuraciones">Configuración</label>
          </div>
          <div class="form-floating mb-3">
            <select id="categoriaSelect" class="form-select" required>
              <option value="">Seleccione categoría</option>
            </select>
            <label for="categoriaSelect">Seleccionar categoría</label>
          </div>
        </div>
        <div class="card-footer text-end">
          <button class="btn btn-primary" id="addConfiguraciones" type="submit">
            <i class="fa-solid fa-floppy-disk me-1"></i> Guardar Cambios
          </button>
        </div>
      </div>
    </form>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const categoriaSelect = document.querySelector("#categoriaSelect");

      // Obtener el registro existente para cargarlo en el formulario
      async function obtenerRegistro() {
        try {
          const URL = new URLSearchParams(window.location.search);
          const idconfiguracion = URL.get('id');

          // Obtenemos los datos configuración
          const parametros = new URLSearchParams();
          parametros.append("task", "getById");
          parametros.append("idConfiguracion", idconfiguracion);

          let res = await fetch(`../../controller/ConfiguracionController.php?${parametros}`);
          let data = await res.json();

          if (data.length > 0) {
            const configuracionData = data[0];
            document.getElementById("configuraciones").value = configuracionData.configuracion;

            // Cargamos categorías
            res = await fetch("../../controller/ConfiguracionController.php?task=getCategorias");
            let categorias = await res.json();

            categoriaSelect.innerHTML = '<option value="">Seleccione categoría</option>';
            categorias.forEach(categoria => {
              const option = document.createElement("option");
              option.value = categoria.idCategoria;
              option.textContent = categoria.categoria;
              categoriaSelect.appendChild(option);
            });

            // Seleccionamos categoría 
            categoriaSelect.value = configuracionData.idCategoria;
          }
        } catch (error) {
          console.error(error);
          Swal.fire("Error", "No se pudo cargar la información.", "error");
        }
      }

      obtenerRegistro();

      // envío de formulario
      const formulario = document.getElementById('formulario-registrar');
      formulario.addEventListener('submit', function (event) {
        event.preventDefault();

        const idconfiguracion = new URLSearchParams(window.location.search).get('id');
        const configuracion = document.getElementById('configuraciones').value.trim();
        const idcategoria = categoriaSelect.value;

        if (!configuracion || !idcategoria) {
          Swal.fire("Campos incompletos", "Por favor rellene todos los campos.", "warning");
          return;
        }

        Swal.fire({
          title: '¿Actualizar configuración?',
          text: 'Esta acción modificará la información.',
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#0d6efd',
          cancelButtonColor: '#6c757d',
          confirmButtonText: 'Sí, actualizar',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            fetch('../../controller/ConfiguracionController.php', {
              method: 'PUT',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify({
                idConfiguracion: idconfiguracion,
                configuracion: configuracion,
                idCategoria: idcategoria
              })
            })
              .then(res => res.json())
              .then(data => {
                if (data.filas > 0) {
                  Swal.fire({
                    title: 'Actualizado',
                    text: 'Configuración actualizada correctamente.',
                    icon: 'success',
                    confirmButtonColor: '#198754'
                  }).then(() => {
                    window.location.href = "./listarConfiguracion.php";
                  });
                } else {
                  Swal.fire("Sin cambios", "No se actualizó el registro.", "info");
                }
              })
              .catch(error => {
                console.error(error);
                Swal.fire("Error", "No se pudo actualizar la configuración.", "error");
              });
          }
        });
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"> </script>
</body>

</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <!--Font Awesone-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Document</title>
</head>
<body>
        <div class="container my-5">
        <form action="" method="" id="formulario-registrar">
            <h2 class="text-center mb-4">ACTUALIZACIÓN DE DATOS</h2>
            <div class="card">
                <div class="card-header bg-info"><strong>ACTUALIZACIÓN</strong></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-floating">
                                <input type="text" id="detalle" name="detalle" class="form-control" placeholder="Detalles" required>
                                <label for="detalle" class="form-label">Detalles:</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-floating">
                                <select id="caracteristica" class="form-select" required>
                                    <option value="">Seleccione caracteristica:</option>
                                </select>
                                <label for="caracteristica" class="form-label">Seleccionar Caracteristica:</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-floating">
                                <select id="configuracion" class="form-select" required>
                                    <option value="">Seleccione configuracion:</option>
                                </select>
                                <label for="configuracion" class="form-label">Seleccionar Configuración:</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" id="adddetalle">ACTUALIZAR</button>
                </div>
                <hr>
            </div>
    </div>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    async function obtenerRegistro() {
      const URL = new URLSearchParams(window.location.search);
      const iddetalle = URL.get('id');

      let detalleData = null;

      // 1. Obtener los datos del detalle por ID
      try {
        const response = await fetch(`../../controller/DetallesController.php?task=getById&idDetalle=${iddetalle}`);
        const data = await response.json();

        if (data.length > 0) {
          detalleData = data[0];
          document.getElementById("detalle").value = detalleData.caracteristica;
        }
      } catch (error) {
        console.error("Error al obtener detalle:", error);
      }

      // 2. Llenar select de caracteristica
      const caracteristicaSelect = document.getElementById("caracteristica");

      try {
        const response = await fetch("../../controller/DetallesController.php?task=getCaracteristica");
        const data = await response.json();

        caracteristicaSelect.innerHTML = '<option value="">Seleccionar Caracteristica</option>';
        data.forEach(item => {
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

      // 3. Llenar select de configuracion
      const configuracionSelect = document.getElementById("configuracion");

      try {
        const response = await fetch("../../controller/DetallesController.php?task=getConfiguracion");
        const data = await response.json();

        configuracionSelect.innerHTML = '<option value="">Seleccionar Configuración</option>';
        data.forEach(item => {
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

    // SUBMIT
    const formulario = document.getElementById('formulario-registrar');
    formulario.addEventListener('submit', function (event) {
      event.preventDefault();

      const idDetalle = new URLSearchParams(window.location.search).get('id');
      const caracteristica = document.getElementById('detalle').value;
      const idCaracteristica = document.getElementById('caracteristica').value;
      const idConfiguracion = document.getElementById('configuracion').value;

      Swal.fire({
        title: 'DETALLES',
        text: '¿Está seguro de actualizar?',
        icon: 'question',
        footer: 'SENATI ING. SOFTWARE',
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#2980b9',
        showCancelButton: true,
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          const datos = {
            idDetalle,
            caracteristica,
            idCaracteristica,
            idConfiguracion
          };

          fetch('../../controller/DetallesController.php', {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(datos)
          })
            .then(response => response.json())
            .then(data => {
              if (data.filas > 0) {
                Swal.fire({
                  title: 'ACTUALIZADO',
                  text: 'Detalles actualizados',
                  icon: 'success',
                  footer: 'SENATI ING. SOFTWARE',
                  confirmButtonText: 'OK',
                  confirmButtonColor: '#2980b9',
                }).then(() => {
                  window.location.href = "../../view/detalles/listarDetalles.php";
                });
              }
            })
            .catch(error => {
              console.error(error);
            });
        }
      });
    });
  });
</script>

</body>
</html>
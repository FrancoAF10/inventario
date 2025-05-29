<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <title>Document</title>
</head>

<body>
  <div class="container">
    <form action="" autocomplete="off" id="formulario-registrar">
      <h2 class="text-center mt-3">ACTUALIZAR DATOS</h2>
      <hr>
      <div class="card mt-3">
        <div class="card-header bg-info"><strong>ACTUALIZAR ÁREA</strong></div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12 mb-2">
              <div class="form-floating">
                <input type="text" id="area" name="area" class="form-control" placeholder="Area" required>
                <label for="area" class="form-label">Área:</label>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer d-grid gap-2">
          <button class="btn btn-primary" id="addArea" type="submit">Actualizar Área</button>
        </div>
      </div>
    </form>
  </div>
  <script>
  document.addEventListener("DOMContentLoaded", () => {
    // Obtener el registro existente para cargarlo en el formulario
    function obtenerRegistro() {
      const URL = new URLSearchParams(window.location.search);
      const idarea = URL.get('id');

      const parametros = new URLSearchParams();
      parametros.append("task", "getById");
      parametros.append("idArea", idarea);

      fetch(`../../controller/AreaController.php?${parametros}`, { method: 'GET' })
        .then(response => response.json())
        .then(data => {
          if (data.length > 0) {
            document.getElementById("area").value = data[0].area;
          }
        })
        .catch(error => {
          console.error(error);
        });
    }

    obtenerRegistro();
    const formulario = document.getElementById('formulario-registrar');
    formulario.addEventListener('submit', function (event) {
      event.preventDefault();

      const idarea = new URLSearchParams(window.location.search).get('id');
      const area = document.getElementById('area').value;

      Swal.fire({
        title: 'ÁREAS',
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
            idArea: idarea,
            area: area
          };
          fetch('../../controller/AreaController.php', {
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
                  text: 'Área actualizada',
                  icon: 'success',
                  footer: 'SENATI ING. SOFTWARE',
                  confirmButtonText: 'OK',
                  confirmButtonColor: '#2980b9',
                }).then(() => {
                  // Redirigir después de aceptar el mensaje de éxito
                  window.location.href = "../../view/areas/listarArea.php";
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
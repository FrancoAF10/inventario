<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <div class="container my-5">
        <form action="" method="" id="formulario-registrar">
            <h2 class="text-center mb-4">Agregar Detalles:</h2>
            <div class="card">
                <div class="card-header bg-info"><strong>DETALLES REGISTRADOS</strong></div>
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
                    <button class="btn btn-primary" id="adddetalle">Agregar</button>
                </div>
                <hr>
            </div>
    </div>
    <script>
      document.addEventListener("DOMContentLoaded", () => {
      const caracteristica = document.querySelector("#caracteristica"); // Tu <select> de categorías
      const configuracion = document.querySelector("#configuracion"); // Tu <select> de categorías

      // Obtener las categorías cuando cargue la página
      fetch("../../controller/DetallesController.php?task=getCaracteristica")
        .then(response => response.json())
        .then(data => {
          // Limpiar el <select>
          caracteristica.innerHTML = '<option value="">Seleccionar Caracteristica</option>';

          // Llenar el <select> con las caracteristicas
          data.forEach(caracteristicas => {
            caracteristica.innerHTML += `<option value="${caracteristicas.idCaracteristica}">${caracteristicas.segmento}</option>`;
          });
        })
        .catch(error => {
          console.error(error);
        });

        fetch("../../controller/DetallesController.php?task=getConfiguracion")
        .then(response => response.json())
        .then(data => {
          // Limpiar el <select>
          configuracion.innerHTML = '<option value="">Seleccionar Configuración</option>';

          // Llenar el <select> con las configuraciones
          data.forEach(configuraciones => {
            configuracion.innerHTML += `<option value="${configuraciones.idConfiguracion}">${configuraciones.configuracion}</option>`;
          });
        })
        .catch(error => {
          console.error(error);
        });
    });
        //AGREGAMOS UN REGISTRO
    const formulario = document.querySelector("#formulario-registrar");

    function registrarDetalles() {
      fetch(`../../controller/DetallesController.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          caracteristica: document.querySelector('#detalle').value,
          idCaracteristica: parseInt(document.querySelector('#caracteristica').value),
          idConfiguracion: parseInt(document.querySelector('#configuracion').value),

        })
      })
        .then(response => { return response.json() })
        .then(data => {
          if (data.filas > 0) {
            formulario.reset();
            Swal.fire({
              title: 'CONFIRMADO',
              text: 'Detalles Registrados',
              icon: 'success',
              footer: 'SENATI ING. SOFTWARE',
              confirmButtonText: 'OK',
              confirmButtonColor: '#2980b9',
            })
           }
        })
        .catch(error => { console.error(error) });
    }
    //formulario=botonb[submit](validar Front)
    formulario.addEventListener("submit", function (event) {
      event.preventDefault();//cancela el evento

      Swal.fire({
        title: 'DETALLES',
        text: '¿Está seguro de registrar?',
        icon: 'question',
        footer: 'SENATI ING. SOFTWARE',
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#2980b9',
        showCancelButton: true,
        cancelButtonText: 'cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          registrarDetalles();
        }
      })
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </form>
</body>

</html>
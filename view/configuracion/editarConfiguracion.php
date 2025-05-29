<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Document</title>
</head>
<body>
<div class="container my-5">
        <form action="" method="post" id="formulario-registrar">
        <h2 class="text-center mb-4">ACTUALIZACIÓN DE DATOS</h2>
        <hr>
    <div class="card">
      <div class="card-header bg-info"><strong>ACTUALIZAR</strong></div>
      <div class="card-body">
        <div class="row">
        <div class="col-md-12 mb-3">
          <div class="form-floating">
            <input type="text" id="configuraciones" name="configuraciones" class="form-control" placeholder="Configuración" required>
            <label for="configuraciones" class="form-label">Configuración:</label>
        </div>
        </div>
        </div>
        <div class="row">
        <div class="col-md-12 mb-3">
          <div class="form-floating">
            <select id="categoriaSelect" class="form-select" required>
              <option value="">Seleccione categoria:</option>
            </select>
            <label for="categoriaSelect" class="form-label">Seleccionar categoria:</label>
            </div>
        </div>
        </div>
        </div>
        <div class="card-footer">
        <div class="d-grid gap-2">
            <button class="btn btn-primary" id="addConfiguraciones" type="submit">ACTUALIZAR</button>
        </div>
        </div>
        
        </div>
    </form>
    </div>
    <script>
  document.addEventListener("DOMContentLoaded", () => {
    // Obtener el registro existente para cargarlo en el formulario
  function obtenerRegistro() {
  const URL = new URLSearchParams(window.location.search);
  const idconfiguracion = URL.get('id');
  const categoriaSelect = document.querySelector("#categoriaSelect");

  const parametros = new URLSearchParams();
  parametros.append("task", "getById");
  parametros.append("idConfiguracion", idconfiguracion);

  let configuracionData = null;

  // Paso 1: Obtener los datos del usuario
  fetch(`../../controller/ConfiguracionController.php?${parametros}`, { method: 'GET' })
    .then(response => response.json())
    .then(data => {
      if (data.length > 0) {
        configuracionData = data[0]; // Guardamos los datos del usuario para usar después
        document.getElementById("configuraciones").value = configuracionData.configuracion;
      }
      // Paso 2: Obtener colaboradores
      return fetch("../../controller/ConfiguracionController.php?task=getCategorias");
    })
    .then(response => response.json())
    .then(data => {
      data.forEach(categoria => {
        const option = document.createElement("option");
        option.value = categoria.idCategoria;
        option.textContent = `${categoria.categoria}`;
        categoriaSelect.appendChild(option);
      });

      // Paso 3: Ahora que las opciones están cargadas, seleccionamos el colaborador correcto
      if (configuracionData) {
        categoriaSelect.value = configuracionData.idCategoria;
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

      const idconfiguracion = new URLSearchParams(window.location.search).get('id');
      const configuracion = document.getElementById('configuraciones').value;
      const idcategoria = document.getElementById('categoriaSelect').value;
      

      Swal.fire({
        title: 'CONFIGURACIÓN',
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
            idConfiguracion: idconfiguracion,
            configuracion: configuracion,
            idCategoria:idcategoria
          };

          fetch('../../controller/ConfiguracionController.php', {
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
                  text: 'Configuración actualizada',
                  icon: 'success',
                  footer: 'SENATI ING. SOFTWARE',
                  confirmButtonText: 'OK',
                  confirmButtonColor: '#2980b9',
                }).then(() => {
                  // Redirigir después de aceptar el mensaje de éxito
                  window.location.href = "../../view/configuracion/listarConfiguracion.php";
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
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
  <!--INICIO DE NAVBAR-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.html">Inventario</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav w-100 d-flex flex-wrap justify-content-between">

        <li class="nav-item">
          <a class="nav-link" href="../areas/listarArea.php">Áreas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../roles/ListarRoles.php">Roles</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../categorias/listarCategoria.php">Categorías</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../SubCategoria/ListarSubcategorias.php">Subcategorías</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../marcas/ListarMarcas.php">Marcas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../personas/ListarPersonas.php">Personas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../colaboradores/listarColaboradores.php">Colaboradores</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../usuarios/listarUsuarios.php">Usuarios</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../bienes/listarBien.php">Bienes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../asignaciones/listarAsignaciones.php">Asignaciones</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../caracteristicas/listarCaracteristicas.php">Características</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./listarDetalles.php">Detalles</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../configuracion/listarConfiguracion.php">Configuraciones</a>
        </li>

      </ul>
    </div>
  </div>
</nav>
<!--FIN DE NAVBAR-->
  <div class="container">
    <form action="" autocomplete="off" id="formulario-registrar">
      <h2 class="text-center mt-3">REGISTRAR ÁREA</h2>
      <button id="listadoArea" type="button" onclick="window.location.href='././listarArea.php'" class="btn btn-success"><i class="fa-solid fa-arrow-left"></i> VOLVER </button>
<hr>
      <div class="card mt-3">
        <div class="card-header bg-info"><strong>REGISTRAR</strong></div>
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
          <button class="btn btn-primary" id="addArea" type="submit">Agregar Área</button>
        </div>
      </div>
    </form>
  </div>

  <script>
    //AGREGAMOS UN REGISTRO
    const formulario = document.querySelector("#formulario-registrar");

    function registrarArea() {
      fetch(`../../controller/AreaController.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          area: document.querySelector('#area').value,
        })
      })
        .then(response => { return response.json() })
        .then(data => {
          if (data.filas > 0) {
            formulario.reset();
            Swal.fire({
              title: 'CONFIRMADO',
              text: 'Area Registrada',
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
        title: 'AREAS',
        text: '¿Está seguro de registrar?',
        icon: 'question',
        footer: 'SENATI ING. SOFTWARE',
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#2980b9',
        showCancelButton: true,
        cancelButtonText: 'cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          registrarArea();
        }
      })
    });

  </script>
</body>

</html>
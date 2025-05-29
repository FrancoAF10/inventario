<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!--Font Awesone-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Document</title>
</head>

<body>
  <!--INICIO DE NAVBAR-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Inventario</a>
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
          <a class="nav-link" href="./listarBien.php">Bienes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../asignaciones/listarAsignaciones.php">Asignaciones</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../caracteristicas/listarCaracteristicas.php">Características</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../detalles/listarDetalles.php">Detalles</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../configuracion/listarConfiguracion.php">Configuraciones</a>
        </li>

      </ul>
    </div>
  </div>
</nav>
<!--FIN DE NAVBAR-->
  <div class="container mt-5">
    <h2 class="text-center mt-5">GESTIÓN DE BIENES</h2>
    <button id="pgaddBien" type="button" onclick="window.location.href='././agregarBien.php'" class="btn btn-success"><i class="fa-solid fa-plus"></i> NUEVO BIEN</button>
    <hr>

    <div class="card mt-3">
      <div class="card-header bg-info"><strong>BIENES REGISTRADOS</strong></div>
      <div class="card-body">
        <table class="table table-bordered table-striped w-100" id="tabla-bienes">
          <colgroup>
            <col style="width:5%;"><!--id-->
            <col style="width:10%;"><!--marca-->
            <col style="width:10%;"><!--modelo-->
            <col style="width:10%;"><!--NroSerie-->
            <col style="width:20%;"><!--descripción-->
            <col style="width:10%;"><!--condicion-->
            <col style="width:15%;"><!--fotografia-->
            <col style="width:15%;"><!--usuario-->
            <col style="width:5%;"><!--usuario-->

          </colgroup>
          <thead>
            <tr>
              <th>ID</th>
              <th>Marca</th>
              <th>Modelo</th>
              <th>N° Serie</th>
              <th>Descripción</th>
              <th>Condición</th>
              <th>Fotografía</th>
              <th>Usuario</th>
              <th>Acciones</th>
            </tr>
          </thead>

          <tbody>
            <!-- Contenido de forma dinámica -->
          </tbody>

        </table>
      </div>
    </div>

    <script>
      //acceso global
      //OBTENEMOS TODOS LOS DATOS
      const tablabien = document.querySelector("#tabla-bienes tbody");
      function obtenerDatos() {
        //fetch(RUTA_CONTROLADOR).then(JSON).then(DATA).catch(ERRORES)
        fetch(`../../controller/BienController.php?task=getAll`, {
          method: 'GET'
        })
          .then(response => { return response.json() })
          .then(data => {
            tablabien.innerHTML = ``;
            data.forEach(element => {
              tablabien.innerHTML += `
          <tr>
            <td>${element.idBien}</td>
            <td>${element.marca}</td>
            <td>${element.modelo}</td>
            <td>${element.numSerie}</td>
            <td>${element.descripcion}</td>   
            <td>${element.condicion}</td>
            <td><img src="${element.fotografia}" alt="Fotografía" width="100"></td>
            <td>${element.nomUser}</td>


            <td>
            
              <a href='editar.php?id=${element.idBien}' title='Editar' class='btn btn-info btn-sm edit'><i class="fa-solid fa-pencil"></i></a>
              <a href='#' title='Eliminar' data-idbien='${element.idBien}' class='btn btn-danger btn-sm delete'><i class="fa-solid fa-trash"></i></a>
              
            </td>

          </tr>
          `;
            });
          })
          .catch(error => { console.error(error) });
      }
      document.addEventListener("DOMContentLoaded", () => {
        obtenerDatos()
        tablabien.addEventListener("click", (event) => {

          const enlace = event.target.closest('a');
          if (enlace && enlace.classList.contains('delete')) {
            event.preventDefault();
            const idbien = enlace.getAttribute('data-idbien');
            if (confirm("¿Está seguro de eliminar el registro?")) {
              fetch(`../../controller/BienController.php/${idbien}`, { method: 'DELETE' })
                .then(response => { return response.json() })
                .then(datos => {
                  if (datos.filas > 0) {
                    const filaEliminar = enlace.closest('tr');
                    if (filaEliminar) { filaEliminar.remove(); }
                  }
                })
                .catch(error => { console.error(error) });
            }
          }
        });
      });
    </script>
  </div>
</body>

</html>
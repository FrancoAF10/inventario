<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <!--Font Awesone-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
<div class="container mt-5  ">
   
<h2 class="text-center mt-3">GESTIÓN DE DETALLES</h2>
  <button id="pgaddDetalles" type="button" onclick="window.location.href='././registrarDetalles.php'" class="btn btn-success"><i class="fa-solid fa-plus"></i> AGREGAR DETALLES </button>
    <hr>

  <div class="card mt-3">
    <div class="card-header bg-info"><strong>DETALLES REGISTRADAS</strong></div>
    <div class="card-body">
      <table class="table table-bordered table-striped w-100" id="tabla-Detalles">
        <colgroup>
          <col style="width:10%;"><!--idDetalles-->
          <col style="width:25%;"><!--Caracteristicas-->
          <col style="width:25%;"><!--Configuración-->
          <col style="width:30%;"><!--Detalles-->
          <col style="width:10%;"><!--acciones-->
        </colgroup>
        <thead>
          <tr>
            <th>ID</th>
            <th>CARACTERISTICAS</th>
            <th>CONFIGURACIÓN</th>
            <th>DETALLES</th>
            <th>ACCIONES</th>

          </tr>
        </thead>

        <tbody>
        <!-- Contenido de forma dinámica -->
        </tbody>

      </table>
    </div>
  </div>
  </div>

<script>
   //acceso global
   //OBTENEMOS TODOS LOS DATOS
  const tabla=document.querySelector("#tabla-Detalles tbody");
  function obtenerDatos(){
    //fetch(RUTA_CONTROLADOR).then(JSON).then(DATA).catch(ERRORES)
    fetch(`../../controller/DetallesController.php?task=getAll`,{
      method:'GET'
    })
    .then(response =>{return response.json()})
    .then(data =>{
      tabla.innerHTML=``;
      data.forEach(element => {
        tabla.innerHTML+=`
        <tr>
          <td>${element.idDetalle}</td>
          <td>${element.segmento}</td>
          <td>${element.configuracion}</td>
          <td>${element.caracteristica}</td>
          <td>
          
            <a href='editarDetalles.php?id=${element.idDetalle}' title='Editar' class='btn btn-info btn-sm edit'><i class="fa-solid fa-pencil"></i></a>
            <a href='#' title='Eliminar' data-iddetalle='${element.idDetalle}' class='btn btn-danger btn-sm delete'><i class="fa-solid fa-trash"></i></a>
            
          </td>

        </tr>
        `;
      });
    })
    .catch(error =>{console.error(error)});
  }
  document.addEventListener("DOMContentLoaded",()=>{
    obtenerDatos();

    tabla.addEventListener("click",(event)=>{

      const enlace=event.target.closest('a');//referencia a la etiqueta <a> mas cercana
      if(enlace && enlace.classList.contains('delete')){
        event.preventDefault();
        const iddetalle=enlace.getAttribute('data-iddetalle');
          if(confirm("¿Está seguro de eliminar el registro?")){
            fetch(`../../controller/DetallesController.php/${iddetalle}`,{method:'DELETE'})
            .then(response =>{return response.json()})
            .then(datos=>{
              if(datos.filas>0){
                const filaEliminar=enlace.closest('tr');
                if (filaEliminar){filaEliminar.remove();}
              }
            })
            .catch(error=>{console.error(error)});
          }
      }
    });
  });
</script>
</body>
</html>


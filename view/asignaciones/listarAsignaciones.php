<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <!--Font Awesone-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>

<div class="container mt-5">
   
  <button id="pgaddAsignacion" type="button" onclick="window.location.href='././agregarAsignaciones.php'">Agregar Asignacion</button>
    <hr>

  <div class="card mt-3">
    <div class="card-header">Asignaciones Registradas</div>
    <div class="card-body">
      <table class="table table-bordered table-striped w-100" id="tabla-Asignaciones">
        <colgroup>
          <col style="width:5%;"><!--id-->
          <col style="width:30%;"><!--Bien-->
          <col style="width:25%;"><!--colaborador-->
          <col style="width:20%;"><!--fecha inico-->
          <col style="width:20%;"><!--fecha fin-->

        </colgroup>
        <thead>
          <tr>
            <th>ID</th>
            <th>BIEN</th>
            <th>COLABORADOR</th>
            <th>FECHA INICIO</th>
            <th>FECHA FIN</th>
            <th>ACCIONES</th>

          </tr>
        </thead>

        <tbody>
        <!-- Contenido de forma dinámica -->
        </tbody>

      </table>
    </div>
  </div>

<script>
   //OBTENEMOS TODOS LOS DATOS
  const tabla=document.querySelector("#tabla-Asignaciones tbody");
  function obtenerDatos(){
    fetch(`../../controller/AsignacionesController.php?task=getAll`,{
      method:'GET'
    })
    .then(response =>{return response.json()})
    .then(data =>{
      tabla.innerHTML=``;
      data.forEach(element => {
        tabla.innerHTML+=`
        <tr>
          <td>${element.idAsignacion}</td>
          <td>${element.subCategoria} ${element.marca} ${element.numSerie}</td>
          <td>${element.nombres} ${element.apellidos}</td>
          <td>${element.inicio}</td>
          <td>${element.fin}</td>

          <td>
          
            <a href='editarAsignaciones.php?id=${element.idAsignacion}' title='Editar' class='btn btn-info btn-sm edit'><i class="fa-solid fa-pencil"></i></a>
            <a href='#' title='Eliminar' data-idasignacion='${element.idAsignacion}' class='btn btn-danger btn-sm delete'><i class="fa-solid fa-trash"></i></a>
            
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

      const enlace=event.target.closest('a');
      if(enlace && enlace.classList.contains('delete')){
        event.preventDefault();
        const idasignacion=enlace.getAttribute('data-idasignacion');
          if(confirm("¿Está seguro de eliminar el registro?")){
            fetch(`../../controller/AsignacionesController.php/${idasignacion}`,{method:'DELETE'})
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


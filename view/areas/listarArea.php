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

<div class="container ">
   
  <button id="pgaddArea" type="button" onclick="window.location.href='././registrarArea.php'">Agregar Nueva Area</button>
    <hr>

  <div class="card mt-3">
    <div class="card-header">Areas Registradas</div>
    <div class="card-body">
      <table class="table table-bordered table-striped w-100" id="tabla-Areas">
        <colgroup>
          <col style="width:15%;"><!--idArea-->
          <col style="width:65%;"><!--Area-->
          <col style="width:20%;"><!--acciones-->
        </colgroup>
        <thead>
          <tr>
            <th>ID</th>
            <th>AREA</th>
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
   //acceso global
   //OBTENEMOS TODOS LOS DATOS
  const tabla=document.querySelector("#tabla-Areas tbody");
  function obtenerDatos(){
    //fetch(RUTA_CONTROLADOR).then(JSON).then(DATA).catch(ERRORES)
    fetch(`../../controller/AreaController.php?task=getAll`,{
      method:'GET'
    })
    .then(response =>{return response.json()})
    .then(data =>{
      tabla.innerHTML=``;
      data.forEach(element => {
        tabla.innerHTML+=`
        <tr>
          <td>${element.idArea}</td>
          <td>${element.area}</td>
          <td>
          
            <a href='editar.php?id=${element.idArea}' title='Editar' class='btn btn-info btn-sm edit'><i class="fa-solid fa-pencil"></i></a>
            <a href='#' title='Eliminar' data-idarea='${element.idArea}' class='btn btn-danger btn-sm delete'><i class="fa-solid fa-trash"></i></a>
            
          </td>

        </tr>
        `;
      });
    })
    .catch(error =>{console.error(error)});
  }
  document.addEventListener("DOMContentLoaded",()=>{
    obtenerDatos();
    //¿comó enlazar un evento(click) a un control que NO existe?
    //RPTA:Delegación de evento(funcion asíncronas)
    tabla.addEventListener("click",(event)=>{
      //solo debemos detectar el CLICK en el botón(Eliminar= .delete)

      //CSS=> "pointer-events:none"
      const enlace=event.target.closest('a');//referencia a la etiqueta <a> mas cercana
      //¿Existe el enlace?, ¿El enlace tiene la clase "delete"?
      if(enlace && enlace.classList.contains('delete')){
        event.preventDefault();
        const idarea=enlace.getAttribute('data-idarea');
          if(confirm("¿Está seguro de eliminar el registro?")){
            fetch(`../../controller/AreaController.php/${idarea}`,{method:'DELETE'})
            .then(response =>{return response.json()})
            .then(datos=>{
              if(datos.filas>0){
                //forma 1: renderizar toda la tabl
                //obtenerDatos();
                //forma 2: Eliminar de la fila
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


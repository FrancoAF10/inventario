<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <div class="container mt-5">
<button id="pgaddcaracteristicas" type="button" onclick="window.location.href='././registrarCaracteristicas.php'">Agregar Caracteristica</button>
    
    <hr>

    <h3>Caracteristicas Registradas</h3>
    <div class="card mt-3">
      <div class="card-header">Caracteristicas</div>
      <div class="card-body">
        <table class="table table-bordered table-striped w-100" id="tabla-Caracteristica">
            <colgroup>
            <col style="width:10%;"><!--id-->
            <col style="width:35%;"><!--Segmento-->
            <col style="width:35%;"><!--Bien-->
            <col style="width:20%;"><!--Acciones-->

            </colgroup>
          <thead>
            <tr>
              <th>ID</th>
              <th>Segmento</th>
              <th>Bien</th>
              <th>Acciones</th>

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
  const tabla=document.querySelector("#tabla-Caracteristica tbody");
  function obtenerDatos(){
    //fetch(RUTA_CONTROLADOR).then(JSON).then(DATA).catch(ERRORES)
    fetch(`../../controller/CracteristicaController.php?task=getAll`,{
      method:'GET'
    })
    .then(response =>{return response.json()})
    .then(data =>{
      tabla.innerHTML=``;
      data.forEach(element => {
        tabla.innerHTML+=`
        <tr>
          <td>${element.idCaracteristica}</td>
          <td>${element.caracteristica}</td>
          <td>${element.marca}</td>


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
  <!DOCTYPE html>
  <html lang="es">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--Font Awesone-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <title>Document</title>
  </head>
  <body>
  <div class="container mt-5">
    
    <button id="pgaddBien" type="button" onclick="window.location.href='././agregarBien.php'">Registrar Nuevo Bien</button>
      <hr>
  
    <div class="card mt-3">
      <div class="card-header">Bienes Registrados</div>
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
    const tablabien=document.querySelector("#tabla-bienes tbody");
    function obtenerDatos(){
      //fetch(RUTA_CONTROLADOR).then(JSON).then(DATA).catch(ERRORES)
      fetch(`../../controller/BienController.php?task=getAll`,{
        method:'GET'
      })
      .then(response =>{return response.json()})
      .then(data =>{
        tablabien.innerHTML=``;
        data.forEach(element => {
          tablabien.innerHTML+=`
          <tr>
            <td>${element.idBien}</td>
            <td>${element.marca}</td>
            <td>${element.modelo}</td>
            <td>${element.numSerie}</td>
            <td>${element.descripcion}</td>   
            <td>${element.condicion}</td>
            <td>${element.fotografia}</td>
            <td>${element.nomUser}</td>


            <td>
            
              <a href='editar.php?id=${element.idBien}' title='Editar' class='btn btn-info btn-sm edit'><i class="fa-solid fa-pencil"></i></a>
              <a href='#' title='Eliminar' data-idbien='${element.idBien}' class='btn btn-danger btn-sm delete'><i class="fa-solid fa-trash"></i></a>
              
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
      tablabien.addEventListener("click",(event)=>{
        //solo debemos detectar el CLICK en el botón(Eliminar= .delete)

        //CSS=> "pointer-events:none"
        const enlace=event.target.closest('a');//referencia a la etiqueta <a> mas cercana
        //¿Existe el enlace?, ¿El enlace tiene la clase "delete"?
        if(enlace && enlace.classList.contains('delete')){
          event.preventDefault();
          const idbien=enlace.getAttribute('data-idbien');
            if(confirm("¿Está seguro de eliminar el registro?")){
              fetch(`../../controller/BienController.php/${idbien}`,{method:'DELETE'})
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
  </div>
  </body>
  </html>
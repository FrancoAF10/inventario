<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<div class="container">

<button id="pgaddpersonas" type="button" onclick="window.location.href='././RegistrarPersonas.php'" >Registrar Persona</button>

  <h2>Formulario de Registro de Persona</h2>

  <div class="card mt-3">
      <div class="card-header">Personas</div>
      <div class="card-body">
    <div class="table-responsive">
    <table class="table table-bordered table-striped w-100" id="tabla-Personas">

          <thead>
            <tr>
              <th>ID</th>
              <th>Apellidos</th>
              <th>Nombres</th>
              <th>tipoDoc</th>
              <th>nroDocumento</th>
              <th>Telefono</th>
              <th>Email</th>
              <th>Direccion</th>
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
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
 const tabla=document.querySelector("#tabla-Personas tbody");
  function obtenerPersonas(){
     

    //fetch(RUTA_CONTROLADOR).then(JSON).then(DATA).catch(ERRORES)
    fetch(`../../controller/PersonasController.php?task=getAll`,{
      method:'GET'
    })
    .then(response =>{return response.json()})
    .then(data =>{
      tabla.innerHTML=``;
      data.forEach(element => {
        tabla.innerHTML+=`
        <tr>
          <td>${element.idPersona}</td>
          <td>${element.apellidos}</td>
          <td>${element.nombres}</td>
          <td>${element.tipoDoc}</td>
          <td>${element.nroDocumento}</td>
          <td>${element.telefono}</td>
          <td>${element.email}</td>
          <td>${element.direccion}</td>

          <td>
          
              <a href='editar.php?id=${element.id}' title='Editar' class='btn btn-info btn-sm edit'><i class="fa-solid fa-pencil"></i></a>
              <a href='#' title='Eliminar' data-idpersona='${element.idPersona}' class='btn btn-danger btn-sm delete'><i class="fa-solid fa-trash"></i></a>
              
            </td>

          </tr>
          `;
        });
      })
      .catch(error =>{console.error(error)});
    }
    document.addEventListener("DOMContentLoaded",()=>{
    obtenerPersonas();
    //¿comó enlazar un evento(click) a un control que NO existe?
    //RPTA:Delegación de evento(funcion asíncronas)
    tabla.addEventListener("click",(event)=>{
      //solo debemos detectar el CLICK en el botón(Eliminar= .delete)

      //CSS=> "pointer-events:none"
      const enlace=event.target.closest('a');//referencia a la etiqueta <a> mas cercana
      //¿Existe el enlace?, ¿El enlace tiene la clase "delete"?
      if(enlace && enlace.classList.contains('delete')){
        event.preventDefault();
        const idpersona=enlace.getAttribute('data-idpersona');
          if(confirm("¿Está seguro de eliminar el registro?")){
            fetch(`../../controller/PersonasController.php/${idpersona}`,{method:'DELETE'})
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
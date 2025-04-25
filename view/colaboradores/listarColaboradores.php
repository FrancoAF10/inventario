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
<div class="container mt-5">
    <form action="" method="">
        <h2>Formulario de Registro de Colaborador</h2>
        <br>
        <button id="pgaddColaboradores" type="button" onclick="window.location.href='././registrarColaborador.php'">AGREGAR COLABORADOR</button>
        
        <h3 class="mt-5">Listado de Colaboradores Registrados</h3>
        <table class="table" id="tablaColaboradores">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Persona</th>
                    <th>Area</th>
                    <th>Rol</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody >
 
            </tbody>
        </table>
    </div>
    <script>
           //acceso global
   //OBTENEMOS TODOS LOS DATOS
  const tabla=document.querySelector("#tablaColaboradores tbody");
  function obtenerDatos(){
     

    //fetch(RUTA_CONTROLADOR).then(JSON).then(DATA).catch(ERRORES)
    fetch(`../../controller/ColaboradorController.php?task=getAll`,{
      method:'GET'
    })
    .then(response =>{return response.json()})
    .then(data =>{
      tabla.innerHTML=``;
      data.forEach(element => {
        tabla.innerHTML+=`
        <tr>
          <td>${element.idColaborador}</td>
          <td>${element.apellidos} ${element.nombres}</td>
          <td>${element.area}</td>
          <td>${element.rol}</td>
          <td>${element.inicio}</td>
          <td>${element.fin}</td>


          <td>
          
            <a href='editar.php?id=${element.id}' title='Editar' class='btn btn-info btn-sm edit'><i class="fa-solid fa-pencil"></i></a>
            <a href='#' title='Eliminar' data-idcolaborador='${element.idColaborador}' class='btn btn-danger btn-sm delete'><i class="fa-solid fa-trash"></i></a>
            
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
      //¿Existe el enlace?, ¿El enlace tiene la clase "delete"?
      if(enlace && enlace.classList.contains('delete')){
        event.preventDefault();
        const idcolaborador=enlace.getAttribute('data-idcolaborador');
          if(confirm("¿Está seguro de eliminar el registro?")){
            fetch(`../../controller/ColaboradorController.php/${idcolaborador}`,{method:'DELETE'})
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
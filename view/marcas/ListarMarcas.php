<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
    <style>
        body {
            background-color: #f8f9fa;
            padding: 40px;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-weight: 600;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
            font-weight: 600;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .select-box {
            margin-bottom: 20px;
        }
        .alert-custom {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="container my-5">
        <button id="pgaddmarca" type="button" onclick="window.location.href='././RegistrarMarcas.php'">REGISTRAR NUEVA MARCA</button>

        <div id="successAlert" class="alert alert-success alert-custom" style="display: none;">
            Marca agregada correctamente.
        </div>

        <div class="card mt-3">
            <div class="card-header">MARCAS REGISTRADAS</div>
            <div class="card-body">
                <table class="table table-bordered table-striped w-100" id="tabla-marcas">
                    <colgroup>
                    <col style="width:10%;"><!--idMarca-->
                    <col style="width:25%;"><!--marca-->
                    <col style="width:30%;"><!--SubCategorias-->
                    <col style="width:25%;"><!--Categorias-->
                    <col style="width:10%;"><!--Acciones-->

                    </colgroup>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Marca</th>
                            <th>SubCategoría</th>
                            <th>Categoría</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Las marcas se cargarán aquí dinámicamente -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
   //acceso global
   //OBTENEMOS TODOS LOS DATOS
  const tabla=document.querySelector("#tabla-marcas tbody");
  function obtenerMarcas(){
     

    //fetch(RUTA_CONTROLADOR).then(JSON).then(DATA).catch(ERRORES)
    fetch(`../../controller/MarcaController.php?task=getAll`,{
      method:'GET'
    })
    .then(response =>{return response.json()})
    .then(data =>{
      tabla.innerHTML=``;
      data.forEach(element => {
        tabla.innerHTML+=`
        <tr>
          <td>${element.idMarca}</td>
          <td>${element.marca}</td>
          <td>${element.subCategoria}</td>
          <td>${element.categoria}</td>

          <td>
          
              <a href='editar.php?id=${element.id}' title='Editar' class='btn btn-info btn-sm edit'><i class="fa-solid fa-pencil"></i></a>
              <a href='#' title='Eliminar' data-idmarca='${element.idMarca}' class='btn btn-danger btn-sm delete'><i class="fa-solid fa-trash"></i></a>
              
            </td>

          </tr>
          `;
        });
      })
      .catch(error =>{console.error(error)});
    }
  document.addEventListener("DOMContentLoaded",()=>{
    obtenerMarcas();
    //¿comó enlazar un evento(click) a un control que NO existe?
    //RPTA:Delegación de evento(funcion asíncronas)
    tabla.addEventListener("click",(event)=>{
      //solo debemos detectar el CLICK en el botón(Eliminar= .delete)

      //CSS=> "pointer-events:none"
      const enlace=event.target.closest('a');//referencia a la etiqueta <a> mas cercana
      //¿Existe el enlace?, ¿El enlace tiene la clase "delete"?
      if(enlace && enlace.classList.contains('delete')){
        event.preventDefault();
        const idMarca=enlace.getAttribute('data-idmarca');
          if(confirm("¿Está seguro de eliminar el registro?")){
            fetch(`../../controller/MarcaController.php/${idMarca}`,{method:'DELETE'})
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

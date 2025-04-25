<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
      
<div class="container my-5">
        <form action="" method="" id="formulario-registrar">
        <h2 class="text-center mb-4">Agregar Configuraciones:</h2>
    
        <div class="mb-3">
            <label for="configuraciones" class="form-label">Configuraciones:</label>
            <input type="text" id="configuraciones" name="configuraciones" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="categoriaSelect" class="form-label">Seleccionar categoria:</label>
            <select id="categoriaSelect" class="form-select" required>
                <option value="">Seleccione categoria:</option>
            </select>
        </div>
        
        <div class="d-grid gap-2">
            <button class="btn btn-primary" id="addConfiguraciones">Agregar</button>
        </div>
        <hr>
    
    </form>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", () => {
    const categoriaSelect = document.querySelector("#categoriaSelect"); // Tu <select> de categorías
    
        // Obtener las categorías cuando cargue la página
        fetch("../../controller/ConfiguracionController.php?task=getCategorias")
          .then(response => response.json())
          .then(data => {

            // Llenar el <select> con las categorías
            data.forEach(categoria => {
              categoriaSelect.innerHTML += `<option value="${categoria.idCategoria}">${categoria.categoria}</option>`;
            });
          })
          .catch(error => {
            console.error(error);
          });
        });

    //AGREGAMOS UN REGISTRO
    const formulario=document.querySelector("#formulario-registrar");
  
    function registrarConfiguracion(){
        fetch(`../../controller/ConfiguracionController.php`,{
          method:'POST',
          headers:{'Content-Type' : 'application/json'},
          body:JSON.stringify({
            configuracion         :document.querySelector('#configuraciones').value,
            idCategoria         :document.querySelector('#categoriaSelect').value ,

          })
        })
        .then(response =>{return response.json()})
        .then(data => {
          if(data.filas>0){
            formulario.reset();
            alert("Guardado correctamente");
          }
        })
        .catch(error=> {console.error(error)});
      }
      //formulario=botonb[submit](validar Front)
      formulario.addEventListener("submit",function(event){
        event.preventDefault();//cancela el evento

        if(confirm("¿Está seguro de registrar?")){
          registrarConfiguracion();
        }
    });

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
   
</body>
</html>
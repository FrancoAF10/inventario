<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    <div class="container">
        <form action="" autocomplete="off" id="formulario-registrar">
            <h2 class="text-center mb-4">Gestión de Roles</h2>

            <div class="mb-3">
                <label for="rol" class="form-label">ROLES:</label>
                <input type="text" id="rol" name="rol" class="form-control" required>
            </div>

            <div class="d-grid gap-2">
                <button class="btn btn-primary" id="addRoles" type="submit">Agregar Rol</button>
            </div>
        </form>
    </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


  <script>
      //AGREGAMOS UN REGISTRO
    const formulario=document.querySelector("#formulario-registrar");

      function registrarRol(){
          fetch(`../../controller/RolesController.php`,{
            method:'POST',
            headers:{'Content-Type' : 'application/json'},
            body:JSON.stringify({
              rol         :document.querySelector('#rol').value,
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
            registrarRol();
          }
        });

  </script>
</body>
</html>
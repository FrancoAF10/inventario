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
    <form  action="" method="POST" id="formulario-personas">
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
            </div>
            <div class="mb-3">
                <label for="nombres" class="form-label">Nombres</label>
                <input type="text" class="form-control" id="nombres" name="nombres" required>
            </div>
            <div class="mb-3">
                <label for="tipoDoc" class="form-label">Tipo de Documento</label>
                <input type="text" class="form-control" id="tipoDoc" name="tipoDoc" required>
            </div>
            <div class="mb-3">
                <label for="nroDocumento" class="form-label">Número de Documento</label>
                <input type="text" class="form-control" id="nroDocumento" name="nroDocumento" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
    </div>
    <script>
        const formulario=document.querySelector("#formulario-personas");
  
  function registrarPersona(){
      fetch(`../../controller/PersonasController.php`,{
        method:'POST',
        headers:{'Content-Type' : 'application/json'},
        body:JSON.stringify({
          apellidos         :document.querySelector('#apellidos').value,
          nombres         :document.querySelector('#nombres').value,
          tipoDoc         :document.querySelector('#tipoDoc').value,
          nroDocumento         :document.querySelector('#nroDocumento').value,
          telefono         :document.querySelector('#telefono').value,
          email         :document.querySelector('#email').value,
          direccion         :document.querySelector('#direccion').value
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
        registrarPersona();
      }
    });

    </script>
</body>
</html>
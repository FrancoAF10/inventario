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
            <h2 class="text-center mb-4">Gestión de Áreas</h2>

            <div class="mb-3">
                <label for="area" class="form-label">Área:</label>
                <input type="text" id="area" name="area" class="form-control" required>
            </div>

            <div class="d-grid gap-2">
                <button class="btn btn-primary" id="addArea" type="submit">Agregar Área</button>
            </div>
        </form>
  </div>

  <script>
    //AGREGAMOS UN REGISTRO
  const formulario=document.querySelector("#formulario-registrar");
  
  function registrarArea(){
      fetch(`../../controller/AreaController.php`,{
        method:'POST',
        headers:{'Content-Type' : 'application/json'},
        body:JSON.stringify({
          area         :document.querySelector('#area').value,
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
        registrarArea();
      }
    });

  </script>
</body>
</html>
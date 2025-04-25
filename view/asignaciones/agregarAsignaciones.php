<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<div class="container my-5">
        <form action="" method="" autocomplete="off" id="formulario-registrar">
        <h2 class="text-center mb-4">Asignaciones</h2>
    
         <div class="mb-3">
            <label for="bienes" class="form-label">Bien:</label>
            <select id="bienes" class="form-select" required>
                <option value="">Seleccionar Bien</option>
            </select>
        </div>
    
        <div class="mb-3">
            <label for="colaboradorSelect" class="form-label">colaborador:</label>
            <select id="colaboradores" class="form-select" required>
                <option value="">Seleccionar colaborador</option>
            </select>
        </div>
    
        <div class="mb-3">
            <label for="inicio" class="form-label">Fecha Inicio:</label>
            <input type="date" class="form-control" id="inicio" name="inicio" required>
        </div>
        <div class="mb-3">
            <label for="fin" class="form-label">Fecha Final</label>
            <input type="date" class="form-control" id="fin" name="fin" required>
        </div>
        <button class="btn btn-primary" id="addAsignaciones">AGREGAR</button>
</form>
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
    const colaboradores = document.querySelector("#colaboradores");
    
    // Obtener las colaboradores cuando cargue la página
    fetch("../../controller/AsignacionesController.php?task=getColaboradores")
      .then(response => response.json())
      .then(data => {
        data.forEach(colaborador => {
          colaboradores.innerHTML += `<option value="${colaborador.idColaborador}">${colaborador.nombres} ${colaborador.apellidos}</option>`;
        });
      })
      .catch(error => {
        console.error(error);
      });
  });
  document.addEventListener("DOMContentLoaded", () => {
    const bienes = document.querySelector("#bienes");
    
    // Obtener las bienes cuando cargue la página
    fetch("../../controller/AsignacionesController.php?task=getBienes")
      .then(response => response.json())
      .then(data => {
        data.forEach(bien => {
          bienes.innerHTML += `<option value="${bien.idBien}">${bien.subCategoria} ${bien.marca} ${bien.numSerie}</option>`;
        });
      })
      .catch(error => {
        console.error(error);
      });
  });

  //NUEVO REGISTRO
  const formulario=document.querySelector("#formulario-registrar");
  function registrarAsignaciones(){
      fetch(`../../controller/AsignacionesController.php`,{
        method:'POST',
        headers:{'Content-Type' : 'application/json'},
        body:JSON.stringify({
          idBien            :parseInt(document.querySelector('#bienes').value),
          idColaborador     :parseInt(document.querySelector('#colaboradores').value),
          inicio               :document.querySelector('#inicio').value,
          fin            :document.querySelector('#fin').value,
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
        registrarAsignaciones();
      }
    });

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
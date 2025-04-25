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
        <form id="registro-persona" autocomplete="off" method="POST">
        <h1>REGISTRAR NUEVO COLABORADOR</h1>
        <br>
        <div class="mb-3">
            <label for="personaSelect" class="form-label">Seleccionar Persona:</label>
            <select id="persona" class="form-select" required>
                <option value="">Seleccione Persona:</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="areaSelect" class="form-label">Seleccionar Area:</label>
            <select id="areas" class="form-select" required>
                <option value="">Seleccione Area:</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="rolSelect" class="form-label">Seleccionar Rol:</label>
            <select id="rol" class="form-select" required>
                <option value="">Seleccione Rol:</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="fechainicio" class="form-label">Fecha Inicio:</label>
            <input type="date" class="form-control" id="fechainicio" name="fechainicio" required>
        </div>
        <div class="mb-3">
            <label for="fechafin" class="form-label">Fecha Final</label>
            <input type="date" class="form-control" id="fechafin" name="fechafin" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
</div>
<script>
    
    document.addEventListener("DOMContentLoaded", () => {
    const Persona = document.querySelector("#persona"); // Tu <select> de personas
    const areas= document.querySelector("#areas"); //areas
    const roles= document.querySelector("#rol"); //roles

    // Obtener las personas cuando cargue la página
    fetch("../../controller/ColaboradorController.php?task=getPersonas")
      .then(response => response.json())
      .then(data => {

        // Llenar el <select> con las personas
        data.forEach(persona => {
          Persona.innerHTML += `<option value="${persona.idPersona}">${persona.apellidos} ${persona.nombres}</option>`;
        });
      })
      .catch(error => {
        console.error(error);
      });

      // Obtener las areas cuando cargue la página
    fetch("../../controller/ColaboradorController.php?task=getAreas")
      .then(response => response.json())
      .then(data => {

        // Llenar el <select> con las areas
        data.forEach(area => {
          areas.innerHTML += `<option value="${area.idArea}">${area.area}</option>`;
        });
      })
      .catch(error => {
        console.error(error);
      });

      // Obtener los roles cuando cargue la página
    fetch("../../controller/ColaboradorController.php?task=getRoles")
      .then(response => response.json())
      .then(data => {

        // Llenar el <select> con los roles
        data.forEach(rol => {
          roles.innerHTML += `<option value="${rol.idRol}">${rol.rol}</option>`;
        });
      })
      .catch(error => {
        console.error(error);
      });
    });


const formulario=document.querySelector("#registro-persona");
  
  function registrarColaborador(){
      fetch(`../../controller/ColaboradorController.php`,{
        method:'POST',
        headers:{'Content-Type' : 'application/json'},
        body:JSON.stringify({
          idPersona         :parseInt(document.querySelector('#persona').value),
          idArea            :parseInt(document.querySelector('#areas').value),
          idRol             :parseInt(document.querySelector('#rol').value),
          inicio            :document.querySelector('#fechainicio').value,
          fin               :document.querySelector('#fechafin').value,
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
        registrarColaborador();
      }
    });

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
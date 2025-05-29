<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
  <div class="container">
    <form id="registro-colaborador" autocomplete="off" method="POST">
      <h2 class="text-center mt-5">REGISTRAR COLABORADOR</h2>
      <button id="volverColaborador" type="button" onclick="window.location.href='././listarColaboradores.php'" class="btn btn-success"><i class="fa-solid fa-arrow-left"></i> VOLVER</button>
      <hr>
      <div class="card mt-3">
        <div class="card-header bg-info"><strong>REGISTRAR</strong></div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="form-floating">
                <select id="persona" class="form-select" required>
                  <option value="">Seleccione Persona:</option>
                </select>
                <label for="personaSelect" class="form-label">Seleccionar Persona:</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="form-floating">
                <select id="areas" class="form-select" required>
                  <option value="">Seleccione Area:</option>
                </select>
                <label for="areaSelect" class="form-label">Seleccionar Area:</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="form-floating">
                <select id="rol" class="form-select" required>
                  <option value="">Seleccione Rol:</option>
                </select>
                <label for="rolSelect" class="form-label">Seleccionar Rol:</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <div class="form-floating">
                <input type="date" class="form-control" id="fechainicio" name="fechainicio" required>
                <label for="fechainicio" class="form-label">Fecha Inicio:</label>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-floating">
                <input type="date" class="form-control" id="fechafin" name="fechafin" required>
                <label for="fechafin" class="form-label">Fecha Final</label>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer d-grid gap-2">
          <button type="submit" class="btn btn-primary">Registrar</button>
        </div>
      </div>
    </form>
  </div>
  <script>

    document.addEventListener("DOMContentLoaded", () => {
      const Persona = document.querySelector("#persona"); // personas
      const areas = document.querySelector("#areas"); //areas
      const roles = document.querySelector("#rol"); //roles

      // Obtener las personas 
      fetch("../../controller/ColaboradorController.php?task=getPersonas")
        .then(response => response.json())
        .then(data => {

          data.forEach(persona => {
            Persona.innerHTML += `<option value="${persona.idPersona}">${persona.apellidos} ${persona.nombres}</option>`;
          });
        })
        .catch(error => {
          console.error(error);
        });

      // Obtener las areas 
      fetch("../../controller/ColaboradorController.php?task=getAreas")
        .then(response => response.json())
        .then(data => {

          data.forEach(area => {
            areas.innerHTML += `<option value="${area.idArea}">${area.area}</option>`;
          });
        })
        .catch(error => {
          console.error(error);
        });

      // Obtener los roles 
      fetch("../../controller/ColaboradorController.php?task=getRoles")
        .then(response => response.json())
        .then(data => {

          data.forEach(rol => {
            roles.innerHTML += `<option value="${rol.idRol}">${rol.rol}</option>`;
          });
        })
        .catch(error => {
          console.error(error);
        });
    });


    const formulario = document.querySelector("#registro-colaborador");
    function registrarColaborador() {
      fetch(`../../controller/ColaboradorController.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          idPersona: parseInt(document.querySelector('#persona').value),
          idArea: parseInt(document.querySelector('#areas').value),
          idRol: parseInt(document.querySelector('#rol').value),
          inicio: document.querySelector('#fechainicio').value,
          fin: document.querySelector('#fechafin').value,
        })
      })
        .then(response => { return response.json() })
        .then(data => {
          if (data.filas > 0) {
            formulario.reset();
            Swal.fire({
              title: 'CONFIRMADO',
              text: 'Colaborador Registrado',
              icon: 'success',
              footer: 'SENATI ING. SOFTWARE',
              confirmButtonText: 'OK',
              confirmButtonColor: '#2980b9',
            })
          }
        })
        .catch(error => { console.error(error) });
    }
    formulario.addEventListener("submit", function (event) {
      event.preventDefault();//cancela el evento
      Swal.fire({
        title: 'COLABORADOR',
        text: '¿Está seguro de registrar?',
        icon: 'question',
        footer: 'SENATI ING. SOFTWARE',
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#2980b9',
        showCancelButton: true,
        cancelButtonText: 'cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          registrarColaborador();
        }
      })
    });

  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
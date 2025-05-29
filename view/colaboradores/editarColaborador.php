<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Document</title>
</head>
<body>
    <div class="container">
    <form id="registro-colaborador" autocomplete="off" method="POST">
      <h2 class="text-center mt-5">ACTUALIZACIÓN DE DATOS</h2>
      <hr>
      <div class="card mt-3">
        <div class="card-header bg-info"><strong>ACTUALIZAR </strong></div>
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
          <button type="submit" class="btn btn-primary">ACTUALIZAR</button>
        </div>
      </div>
    </form>
  </div>
  <script>
document.addEventListener("DOMContentLoaded", () => {

  const personaSelect = document.getElementById("persona");
  const areaSelect = document.getElementById("areas");
  const rolSelect = document.getElementById("rol");

  const URL = new URLSearchParams(window.location.search);
  const idcolaborador = URL.get("id");

  // Cargar personas
  function cargarPersonas() {
    fetch("../../controller/ColaboradorController.php?task=getPersonas")
      .then(response => response.json())
      .then(data => {
        data.forEach(persona => {
          const option = document.createElement("option");
          option.value = persona.idPersona;
          option.textContent = `${persona.apellidos} ${persona.nombres}`;
          personaSelect.appendChild(option);
        });
      })
      .catch(error => console.error(error));
  }

  // Cargar áreas
  function cargarAreas() {
    fetch("../../controller/ColaboradorController.php?task=getAreas")
      .then(response => response.json())
      .then(data => {
        data.forEach(area => {
          const option = document.createElement("option");
          option.value = area.idArea;
          option.textContent = area.area;
          areaSelect.appendChild(option);
        });
      })
      .catch(error => console.error( error));
  }

  // Cargar roles
  function cargarRoles() {
    fetch("../../controller/ColaboradorController.php?task=getRoles")
      .then(response => response.json())
      .then(data => {
        data.forEach(rol => {
          const option = document.createElement("option");
          option.value = rol.idRol;
          option.textContent = rol.rol;
          rolSelect.appendChild(option);
        });
      })
      .catch(error => console.error( error));
  }

  // Obtener datos del colaborador
  function obtenerRegistro() {
    const parametros = new URLSearchParams();
    parametros.append("task", "getById");
    parametros.append("idColaborador", idcolaborador);

    fetch(`../../controller/ColaboradorController.php?${parametros}`, {
      method: "GET"
    })
      .then(response => response.json())
      .then(data => {
        if (data.length > 0) {
          document.getElementById("fechainicio").value = data[0].inicio;
          document.getElementById("fechafin").value = data[0].fin;
          personaSelect.value = data[0].idPersona;
          areaSelect.value = data[0].idArea;
          rolSelect.value = data[0].idRol;
        }
      })
      .catch(error => console.error(error));
  }

  // Ejecutar cargas
  cargarPersonas();
  cargarAreas();
  cargarRoles();

  obtenerRegistro()

  // Manejar envío del formulario
  const formulario = document.getElementById("registro-colaborador");

  formulario.addEventListener("submit", function (event) {
    event.preventDefault();

    const fechainicio = document.getElementById("fechainicio").value;
    const fechafin = document.getElementById("fechafin").value;
    const idPersona = personaSelect.value;
    const idArea = areaSelect.value;
    const idRol = rolSelect.value;

    Swal.fire({
      title: "COLABORADOR",
      text: "¿Está seguro de actualizar?",
      icon: "question",
      footer: "SENATI ING. SOFTWARE",
      confirmButtonText: "Aceptar",
      confirmButtonColor: "#2980b9",
      showCancelButton: true,
      cancelButtonText: "Cancelar"
    }).then((result) => {
      if (result.isConfirmed) {
        const datos = {
          idColaborador: idcolaborador,
          inicio: fechainicio,
          fin: fechafin,
          idPersona: idPersona,
          idArea: idArea,
          idRol: idRol
        };

        fetch("../../controller/ColaboradorController.php", {
          method: "PUT",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify(datos)
        })
          .then(response => response.json())
          .then(data => {
            if (data.filas > 0) {
              Swal.fire({
                title: "ACTUALIZADO",
                text: "Datos del Colaborador actualizados",
                icon: "success",
                footer: "SENATI ING. SOFTWARE",
                confirmButtonText: "OK",
                confirmButtonColor: "#2980b9"
              }).then(() => {
                window.location.href = "../../view/colaboradores/listarColaboradores.php";
              });
            }
          })
          .catch(error => console.error(error));
      }
    });
  });
});
</script>

</body>
</html>
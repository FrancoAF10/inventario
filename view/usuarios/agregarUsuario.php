<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    <div class="container mt-5">
    <div class="card mb-4">
            <div class="card-header">
                <h3>Agregar Usuario</h3>
            </div>
            <div class="card-body">
                <form id="registrar-usuario" autocomplete="off" method="POST">
                    <div class="mb-3">
                        <label for="nomUser" class="form-label">Nombre de Usuario:</label>
                        <input type="text" class="form-control" id="nomUser" name="nomUser" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña:</label>
                        <input type="passWord" class="form-control" id="password" name="password">
                    </div>

                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado:</label>
                        <select id="estado" name="estado" class="form-select" required>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="idColaborador" class="form-label">Seleccionar Colaborador:</label>
                        <select id="idColaborador" name="idColaborador" class="form-select" required>
                            <option value="">Seleccione un colaborador</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Agregar Usuario</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
    const colaborador= document.querySelector("#idColaborador"); // Tu <select> de categorías
    
    // Obtener las categorías cuando cargue la página
    fetch("../../controller/UsuariosController.php?task=getColaboradores")
      .then(response => response.json())
      .then(data => {

        // Llenar el <select> con las categorías
        data.forEach(colaboradores => {
          colaborador.innerHTML += `<option value="${colaboradores.idColaborador}">${colaboradores.nombres} ${colaboradores.apellidos}</option>`;
        });
      })
      .catch(error => {
        console.error(error);
      });
  });

  const formulario=document.querySelector("#registrar-usuario");
  function registrarUsuario(){
        fetch(`../../controller/UsuariosController.php`,{
          method:'POST',
          headers:{'Content-Type' : 'application/json'},
          body:JSON.stringify({
            nomUser                     :document.querySelector('#nomUser').value,
            passUser                     :document.querySelector('#password').value,
            estado                     :document.querySelector('#estado').value,
            idColaborador               :parseInt(document.querySelector('#idColaborador').value)
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
          registrarUsuario();
        }
      });
</script>
</body>
</html>
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
    <form action="" method="" id="formulario-registro">

            <h3>Gestión de Subcategorías</h3>

            <div class="mb-3">
                <label for="subCategoriaSelect" class="form-label">Seleccionar Categoría:</label>
                <select id="categoriaSelect" class="form-select" required>
                    <option value="">Selecciona una categoría</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="subcategoria" class="form-label">Subcategoría:</label>
                <input type="text" id="subCategoria" name="subcategoria" class="form-control" required>
            </div>

            <div class="d-grid gap-2">
                <button class="btn btn-success" id="addSubcategoria" type="submit">Agregar Subcategoría</button>
            </div>
    </form>
    </div>
    <script>
  document.addEventListener("DOMContentLoaded", () => {
    const categoriaSelect = document.querySelector("#categoriaSelect"); // Tu <select> de categorías
    
    // Obtener las categorías cuando cargue la página
    fetch("../../controller/SubCategoriaController.php?task=getCategorias")
      .then(response => response.json())
      .then(data => {
        // Limpiar el <select>
        categoriaSelect.innerHTML = '<option value="">Selecciona una categoría</option>';

        // Llenar el <select> con las categorías
        data.forEach(categoria => {
          categoriaSelect.innerHTML += `<option value="${categoria.idCategoria}">${categoria.categoria}</option>`;
        });
      })
      .catch(error => {
        console.error(error);
      });
  });

  const formulario=document.querySelector("#formulario-registro");
  function registrarSubCategoria(){
        fetch(`../../controller/SubCategoriaController.php`,{
          method:'POST',
          headers:{'Content-Type' : 'application/json'},
          body:JSON.stringify({
            subCategoria          :document.querySelector('#subCategoria').value,
            idCategoria           :parseInt(document.querySelector('#categoriaSelect').value)
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
          registrarSubCategoria();
        }
      });
    </script>
</body>
</html>
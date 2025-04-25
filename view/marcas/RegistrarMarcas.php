<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background-color: #f4f7fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
            max-width: 500px;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #343a40;
            margin-bottom: 30px;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn-custom:hover {
            background-color: #0056b3;
            transition: background-color 0.3s ease;
        }
    </style>
    <title>Agregar Marca</title>
</head>
<body>
    <div class="container">
        <form action="" method="POST" id="formulario-registrarMarca">
            <h2 class="text-center mb-4">Agregar Marca</h2>
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría:</label>
                <select id="categoria" name="categoria" class="form-select" required>
                    <option value="">Seleccione una categoría</option>
                    <!-- Opciones de categorías serán cargadas aquí -->
                </select>
            </div>
            
            <div class="mb-3">
                <label for="subcategoria" class="form-label">Subcategoría:</label>
                <select id="subcategoria" name="subcategoria" class="form-select" required>
                    <option value="">Seleccione una Subcategoría</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="marca" class="form-label">Marca:</label>
                <input type="text" id="marca" name="marca" class="form-control" placeholder="Ingrese la marca" required>
            </div>

            <button type="submit" class="btn btn-custom w-100">Agregar Marca</button>
        </form>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", () => {
      const categoriaSelect = document.querySelector("#categoria");
      const subCategoriaSelect = document.querySelector("#subcategoria");

      // Cargar Categorías
      fetch("../../controller/MarcaController.php?task=getCategorias")
        .then(response => response.json())
        .then(data => {
          data.forEach(categoria => {
            categoriaSelect.innerHTML += `<option value="${categoria.idCategoria}">${categoria.categoria}</option>`;
          });
        });

      // Cuando se seleccione una categoría
      categoriaSelect.addEventListener("change", () => {
        const idCategoria = categoriaSelect.value;

        fetch(`../../controller/MarcaController.php?task=getsubCategorias&idCategoria=${idCategoria}`)
          .then(response => response.json())
          .then(data => {
              data.forEach(subcategoria => {
                subCategoriaSelect.innerHTML += `<option value="${subcategoria.idSubCategoria}">${subcategoria.subCategoria}</option>`;
              });
            });
          });
        });

     const formulario=document.querySelector("#formulario-registrarMarca");

      function registrarMarca(){
          fetch(`../../controller/MarcaController.php`,{
            method:'POST',
            headers:{'Content-Type' : 'application/json'},
            body:JSON.stringify({
              marca         :document.querySelector('#marca').value,
              idSubCategoria         :parseInt(document.querySelector('#subcategoria').value)

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
            registrarMarca();
          }
        });
    </script>
</body>
</html>

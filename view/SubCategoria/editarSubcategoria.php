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
    <form action="" method="post" id="formulario-registro" autocomplete="off">
      
      <h2 class="text-center mt-3">ACTUALIZACIÓN DE DATOS</h2>
      <hr>
      <div class="card mt-3">
        <div class="card-header bg-info"><strong>ACTUALIZAR SUBCATEGORIA</strong></div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="form-floating">
                <select id="categoriaSelect" class="form-select" required>
                  <option value="">Selecciona una categoría</option>
                </select>
                <label for="CategoriaSelect" class="form-label">Seleccionar Categoría:</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="form-floating">
                <input type="text" id="subCategoria" name="subcategoria" class="form-control" placeholder="Subcategoria"
                  required>
                <label for="subcategoria" class="form-label">Subcategoría:</label>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer d-grid gap-2">
          <button class="btn btn-primary" id="addSubcategoria" type="submit">Actualizar Subcategoría</button>
        </div>
      </div>
    </form>
  </div>
  <script>
  document.addEventListener("DOMContentLoaded", () => {
    // Cargar las categorías primero
    function cargarCategorias() {
        return new Promise((resolve, reject) => {
        const parametros = new URLSearchParams();
        parametros.append("task", "getCategorias");

        fetch(`../../controller/SubCategoriaController.php?${parametros}`, { method: 'GET' })
          .then(response => response.json())
          .then(data => {
            const select = document.getElementById("categoriaSelect");
            data.forEach(categoria => {
              const option = document.createElement("option");
              option.value = categoria.idCategoria;
              option.textContent = categoria.categoria;
              select.appendChild(option);
            });
            resolve();  
          })
          .catch(error => {
            console.error( error);
          });
      });
    }

    // Obtener los datos de la subcategoría
    function obtenerRegistro() {
      const URL = new URLSearchParams(window.location.search);
      const idsubcategoria = URL.get('id');

      const parametros = new URLSearchParams();
      parametros.append("task", "getById");
      parametros.append("idSubCategoria", idsubcategoria);

      fetch(`../../controller/SubCategoriaController.php?${parametros}`, { method: 'GET' })
        .then(response => response.json())
        .then(data => {
          if (data.length > 0) {
            // Asignar valores a los campos del formulario
            document.getElementById("subCategoria").value = data[0].subCategoria;
            document.getElementById("categoriaSelect").value = data[0].idCategoria;  // Asignar la categoría correcta
          }
        })
        .catch(error => {
          console.error(error);
        });
    }

    // Ejecutar la carga de categorías y luego obtener el registro
    cargarCategorias().then(() => {
      obtenerRegistro();
    });

    const formulario = document.getElementById('formulario-registro');

    formulario.addEventListener('submit', function (event) {
      event.preventDefault();

      const idsubcategoria = new URLSearchParams(window.location.search).get('id');
      const subcategoria = document.getElementById('subCategoria').value;
      const idCategoria = document.getElementById('categoriaSelect').value;

      Swal.fire({
        title: 'SUBCATEGORIA',
        text: '¿Está seguro de actualizar?',
        icon: 'question',
        footer: 'SENATI ING. SOFTWARE',
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#2980b9',
        showCancelButton: true,
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          const datos = {
            idSubCategoria: idsubcategoria,
            subCategoria: subcategoria,
            idCategoria: idCategoria
          };

          fetch('../../controller/SubCategoriaController.php', {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(datos)
          })
            .then(response => response.json())
            .then(data => {
              if (data.filas > 0) {
                Swal.fire({
                  title: 'ACTUALIZADO',
                  text: 'Subcategoría actualizada',
                  icon: 'success',
                  footer: 'SENATI ING. SOFTWARE',
                  confirmButtonText: 'OK',
                  confirmButtonColor: '#2980b9',
                }).then(() => {
                  // Redirigir después de aceptar el mensaje de éxito
                  window.location.href = "../../view/SubCategoria/ListarSubcategorias.php";
                });
              }
            })
            .catch(error => {
              console.error(error);
            });
        }
      });
    });
  });
</script>

</body>
</html>
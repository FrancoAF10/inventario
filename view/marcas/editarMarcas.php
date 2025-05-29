<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Gestión de Marcas</title>
</head>
<body>
    <div class="container">
        <form action="" method="POST" id="formulario-registrarMarca">
            <h2 class="text-center mt-3">ACTUALIZACIÓN DE DATOS</h2>
            <hr>    
            <div class="card mt-3">
                <div class="card-header bg-info"><strong>ACTUALIZAR MARCA</strong></div>
                <input type="hidden" id="idmarca" name="idmarca">
                <div class="card-body">
                    <div class="row"> 
                        <div class="col-md-12 mb-3">
                            <div class="form-floating">
                                <select id="categoria" name="categoria" class="form-select" required>
                                    <option value="">Seleccione una categoría</option>
                                    <!-- Las opciones de categorías se cargarán aquí -->
                                </select>
                                <label for="categoria" class="form-label">Categoría:</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-floating">
                                <select id="subcategoria" name="subcategoria" class="form-select" required>
                                    <option value="">Seleccione una Subcategoría</option>
                                    <!-- Las opciones de subcategorías se cargarán aquí -->
                                </select>
                                <label for="subcategoria" class="form-label">Subcategoría:</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-floating">
                                <input type="text" id="marca" name="marca" class="form-control" placeholder="Ingrese la marca" required>
                                <label for="marca" class="form-label">Marca:</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Actualizar Marca</button>
                </div>
            </div>
        </form>
    </div>

    
<script>
 document.addEventListener("DOMContentLoaded", () => {
  const categoriaSelect = document.querySelector("#categoria");
  const subCategoriaSelect = document.querySelector("#subcategoria");
  const marcaInput = document.querySelector("#marca");

  const URLparams = new URLSearchParams(window.location.search);
  const idmarca = URLparams.get("id");

  if (!idmarca) {
    console.warn("No se proporcionó ID de marca.");
    return;
  }

  // Cargar Categorías
  fetch("../../controller/MarcaController.php?task=getCategorias")
    .then(res => res.json())
    .then(categorias => {
      categorias.forEach(c => {
        categoriaSelect.innerHTML += `<option value="${c.idCategoria}">${c.categoria}</option>`;
      });

      obtenerRegistro(); // 👉 solo después de tener las categorías
    });

  // Cargar Subcategorías según categoría
  categoriaSelect.addEventListener("change", () => {
    const idCategoria = categoriaSelect.value;
    subCategoriaSelect.innerHTML = '<option value="">Selecciona una Subcategoria</option>';

    fetch(`../../controller/MarcaController.php?task=getsubCategorias&idCategoria=${idCategoria}`)
      .then(res => res.json())
      .then(subcategorias => {
        subcategorias.forEach(s => {
          subCategoriaSelect.innerHTML += `<option value="${s.idSubCategoria}">${s.subCategoria}</option>`;
        });
      });
  });

  // Obtener datos de la marca
  function obtenerRegistro() {
    const parametros = new URLSearchParams();
    parametros.append("task", "getById");
    parametros.append("idMarca", idmarca); // asegúrate de que coincide con PHP

    fetch(`../../controller/MarcaController.php?${parametros}`)
      .then(res => res.json())
      .then(data => {
        if (data.length > 0) {
          marcaInput.value = data[0].marca;
          categoriaSelect.value = data[0].idCategoria;

          // Cargar subcategorías primero y luego seleccionar
          fetch(`../../controller/MarcaController.php?task=getsubCategorias&idCategoria=${data[0].idCategoria}`)
            .then(res => res.json())
            .then(subcategorias => {
              subCategoriaSelect.innerHTML = '<option value="">Seleccione una Subcategoría</option>';
              subcategorias.forEach(s => {
                subCategoriaSelect.innerHTML += `<option value="${s.idSubCategoria}">${s.subCategoria}</option>`;
              });
              subCategoriaSelect.value = data[0].idSubCategoria;
            });
        }
      })
      .catch(error => console.error("Error al obtener datos de marca:", error));
  }

    const formulario = document.getElementById('formulario-registrarMarca');
    formulario.addEventListener('submit', function (event) {
      event.preventDefault();

      const idMarca = new URLSearchParams(window.location.search).get('id');
      const marca = document.getElementById('marca').value;
      const subcategoria = document.getElementById('subcategoria').value;

      Swal.fire({
        title: 'MARCAS',
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
            idMarca: idMarca,
            idSubCategoria:subcategoria,
            marca: marca,
          };
          fetch('../../controller/MarcaController.php', {
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
                  text: 'Marca actualizada',
                  icon: 'success',
                  footer: 'SENATI ING. SOFTWARE',
                  confirmButtonText: 'OK',
                  confirmButtonColor: '#2980b9',
                }).then(() => {
                  // Redirigir después de aceptar el mensaje de éxito
                  window.location.href = "../../view/marcas/ListarMarcas.php";
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

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
    <form action="" method="post" id="formulario-registro" autocomplete="off">

      <h2 class="text-center mt-3">REGISTRAR SUBCATEGORIA</h2>
      <button id="listadosubcategorias" type="button" onclick="window.location.href='././ListarSubCategorias.php'" class="btn btn-success"><i class="fa-solid fa-arrow-left"></i> VOLVER </button>
      <hr>
      <div class="card mt-3">
        <div class="card-header bg-info"><strong>REGISTRAR SUBCATEGORIA</strong></div>
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
          <button class="btn btn-primary" id="addSubcategoria" type="submit">Agregar Subcategoría</button>
        </div>
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

    const formulario = document.querySelector("#formulario-registro");
    function registrarSubCategoria() {
      fetch(`../../controller/SubCategoriaController.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          subCategoria: document.querySelector('#subCategoria').value,
          idCategoria: parseInt(document.querySelector('#categoriaSelect').value)
        })
      })
        .then(response => { return response.json() })
        .then(data => {
          if (data.filas > 0) {
            formulario.reset();
            Swal.fire({
              title: 'CONFIRMADO',
              text: 'SubCategoria Registrada',
              icon: 'success',
              footer: 'SENATI ING. SOFTWARE',
              confirmButtonText: 'OK',
              confirmButtonColor: '#2980b9',
            })
          }
        })
        .catch(error => { console.error(error) });
    }
    //formulario=botonb[submit](validar Front)
    formulario.addEventListener("submit", function (event) {
      event.preventDefault();//cancela el evento

      Swal.fire({
        title: 'SUBCATEGORIA',
        text: '¿Está seguro de registrar?',
        icon: 'question',
        footer: 'SENATI ING. SOFTWARE',
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#2980b9',
        showCancelButton: true,
        cancelButtonText: 'cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          registrarSubCategoria();
        }
      })
    });
  </script>
</body>

</html>
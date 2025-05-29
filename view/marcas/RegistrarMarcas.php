<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <title>Agregar Marca</title>
</head>

<body>
  <form action="" method="POST" id="formulario-registrarMarca">
    <div class="container">
      <h2 class="text-center mt-3">REGISTRAR MARCA</h2>
      <button id="volvermarca" type="button" onclick="window.location.href='././ListarMarcas.php'" class="btn btn-success"><i class="fa-solid fa-arrow-left"></i> VOLVER</button>
      <hr>
      <div class="card mt-3">
        <div class="card-header bg-info"><strong>REGISTRAR</strong></div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="form-floating">
                <select id="categoria" name="categoria" class="form-select" required>
                  <option value="">Seleccione una categoría</option>
                  <!-- Opciones de categorías serán cargadas aquí -->
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
          <div class="card-footer d-grid gap-2">
            <button type="submit" class="btn btn-primary">Agregar Marca</button>
          </div>
        </div>
  </form>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const categoriaSelect = document.querySelector("#categoria");
      const subCategoriaSelect = document.querySelector("#subcategoria");
      const marcaSelect = document.querySelector("#marca");


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
        // Limpiar opciones anteriores
        subCategoriaSelect.innerHTML = '<option value="">Seleccione una Subcategoria</option>';

        fetch(`../../controller/MarcaController.php?task=getsubCategorias&idCategoria=${idCategoria}`)
          .then(response => response.json())
          .then(data => {
            data.forEach(subcategoria => {
              subCategoriaSelect.innerHTML += `<option value="${subcategoria.idSubCategoria}">${subcategoria.subCategoria}</option>`;
            });
          });
      });
    });

    const formulario = document.querySelector("#formulario-registrarMarca");

    function registrarMarca() {
      fetch(`../../controller/MarcaController.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          marca: document.querySelector('#marca').value,
          idSubCategoria: parseInt(document.querySelector('#subcategoria').value)

        })
      })
        .then(response => { return response.json() })
        .then(data => {
          if (data.filas > 0) {
            formulario.reset();
            Swal.fire({
              title: 'CONFIRMADO',
              text: 'Marca Registrada',
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
        title: 'MARCA',
        text: '¿Está seguro de registrar?',
        icon: 'question',
        footer: 'SENATI ING. SOFTWARE',
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#2980b9',
        showCancelButton: true,
        cancelButtonText: 'cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          registrarMarca();
        }
      })
    });
  </script>
</body>

</html>
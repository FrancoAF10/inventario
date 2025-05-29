<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<title>Document</title>
</head>

<body>
  <div class="container my-5">
    <form action="" method="" autocomplete="off" id="formulario-registrar">
      <h2 class="text-center mb-4">REGISTRAR ASIGNACIÓN</h2>
    <button id="vlvlstAsignacion" type="button" onclick="window.location.href='././listarasignacion.php'" class="btn btn-success"><i class="fa-solid fa-arrow-left"></i> VOLVER</button>
    <hr>
      <div class="card mt-3">
        <div class="card-header bg-info"><strong>REGISTRAR</strong></div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4 mb-3">
              <div class="form-floating">
                <select id="Categoria" class="form-select" required>
                  <option value="">Seleccionar Categoria</option>
                </select>
                <label for="Categoria" class="form-label">Categoria:</label>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="form-floating">
                <select id="SubCategoria" class="form-select" required>
                  <option value="">Seleccionar SubCategoria</option>
                </select>
                <label for="SubCategoria" class="form-label">SubCategoria:</label>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="form-floating">
                <select id="marca" class="form-select" required>
                  <option value="">Seleccionar Marca</option>
                </select>
                <label for="marca" class="form-label">Marca:</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="form-floating">
                <select id="bienes" class="form-select" required>
                  <option value="">Seleccionar Bien</option>
                </select>
                <label for="bienes" class="form-label">Bien:</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="form-floating">
                <select id="colaboradores" class="form-select" required>
                  <option value="">Seleccionar colaborador</option>
                </select>
                <label for="colaboradorSelect" class="form-label">colaborador:</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <div class="form-floating">
                <input type="date" class="form-control" id="inicio" name="inicio" required>
                <label for="inicio" class="form-label">Fecha Inicio:</label>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-floating">
                <input type="date" class="form-control" id="fin" name="fin">
                <label for="fin" class="form-label">Fecha Final</label>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer d-grid gap-2">
          <button class="btn btn-primary" id="addAsignaciones">AGREGAR</button>
        </div>
      </div>
    </form>
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const colaboradores = document.querySelector("#colaboradores");

      // Obtener las colaboradores cuando cargue la página
      fetch("../../controller/AsignacionesController.php?task=getColaboradores")
        .then(response => response.json())
        .then(data => {
          data.forEach(colaborador => {
            colaboradores.innerHTML += `<option value="${colaborador.idColaborador}">${colaborador.nombres} ${colaborador.apellidos}</option>`;
          });
        })
        .catch(error => {
          console.error(error);
        });

      const bienes = document.querySelector("#bienes");
      const categoriaSelect = document.querySelector("#Categoria");
      const subCategoriaSelect = document.querySelector("#SubCategoria");
      const marcaSelect = document.querySelector("#marca");


      // Cargar Categorías
      fetch("../../controller/AsignacionesController.php?task=getCategorias")
        .then(response => response.json())
        .then(data => {
          data.forEach(categoria => {
            categoriaSelect.innerHTML += `<option value="${categoria.idCategoria}">${categoria.categoria}</option>`;
          });
        });

      // 👇 Este es el nuevo código para cargar subcategorías
      categoriaSelect.addEventListener("change", () => {
        const idCategoria = categoriaSelect.value;

        // Limpiar subcategorías anteriores
        subCategoriaSelect.innerHTML = '<option value="">Selecciona una Subcategoria</option>';


        fetch(`../../controller/AsignacionesController.php?task=getSubCategorias&idCategoria=${idCategoria}`)
          .then(response => response.json())
          .then(data => {
            data.forEach(subcategoria => {
              subCategoriaSelect.innerHTML += `<option value="${subcategoria.idSubCategoria}">${subcategoria.subCategoria}</option>`;
            });
          })
          .catch(error => {
            console.error("Error al cargar subcategorías:", error);
          });
      });

      //  Este es el código para cargar marcas
      subCategoriaSelect.addEventListener("change", () => {
        const idsubCategoria = subCategoriaSelect.value;

        // Limpiar subcategorías anteriores
        marcaSelect.innerHTML = '<option value="">Selecciona una Marca</option>';

        fetch(`../../controller/AsignacionesController.php?task=getMarcas&idSubCategoria=${idsubCategoria}`)
          .then(response => response.json())
          .then(data => {
            data.forEach(marcas => {
              marcaSelect.innerHTML += `<option value="${marcas.idMarca}">${marcas.marca}</option>`;
            });
          })
          .catch(error => {
            console.error("Error al cargar subcategorías:", error);
          });
      });

      marcaSelect.addEventListener("change", () => {
        const idMarca = marcaSelect.value;

        // Limpiar bienes anteriores
        bienes.innerHTML = '<option value="">Seleccionar Bien</option>';

        fetch(`../../controller/AsignacionesController.php?task=getBienesPorMarca&idMarca=${idMarca}`)
          .then(response => response.json())
          .then(data => {
            data.forEach(bien => {
              bienes.innerHTML += `<option value="${bien.idBien}">${bien.modelo} ${bien.numSerie} ${bien.descripcion}</option>`;
            });
          })
          .catch(error => {
            console.error("Error al cargar bienes:", error);
          });
      });



     
    });

    //NUEVO REGISTRO
    const formulario = document.querySelector("#formulario-registrar");
    function registrarAsignaciones() {
      const idBien = parseInt(document.querySelector('#bienes').value);
      const idColaborador = parseInt(document.querySelector('#colaboradores').value);
      const inicio = document.querySelector('#inicio').value;


      fetch(`../../controller/AsignacionesController.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          idBien,
          idColaborador,
          inicio,
          fin: document.querySelector('#fin').value,
        })
      })
        .then(response => response.json())
        .then(data => {
          if (data.filas > 0) {
            formulario.reset();
            alert("Guardado correctamente");
          } else {
            alert("Error al guardar. Intente nuevamente.");
          }
        })
        .catch(error => {
          console.error(error);
          alert("Error de red o servidor.");
        });
    }

    //formulario=botonb[submit](validar Front)
    formulario.addEventListener("submit", function (event) {
      event.preventDefault();//cancela el evento

      if (confirm("¿Está seguro de registrar?")) {
        registrarAsignaciones();
      }
    });

  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</body>

</html>
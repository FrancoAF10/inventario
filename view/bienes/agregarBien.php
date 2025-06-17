<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Registrar Bien</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      background-color: #f8f9fa;
    }
    .navbar-brand {
      font-weight: bold;
      letter-spacing: 1px;
    }
    .card {
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }
    .btn {
      transition: all 0.3s ease;
    }
    .btn:hover {
      transform: scale(1.05);
    }
  </style>
</head>

<body>
  <?php include_once(__DIR__ . '/../../layouts/navbar.php'); ?>

  <div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="text-primary">Registrar Bien</h2>
      <button type="button" onclick="window.location.href='./listarBien.php'" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Volver
      </button>
    </div>

    <form autocomplete="off" id="registrar-bien" enctype="multipart/form-data">
      <div class="card">
        <div class="card-header bg-primary text-white">
          <strong>Formulario de Registro</strong>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-4">
              <div class="form-floating">
                <select id="categoria" name="categoria" class="form-select" required>
                  <option value="">Selecciona una Categoria</option>
                </select>
                <label for="categoria">Categoría</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating">
                <select id="subcategoria" name="idSubCategoria" class="form-select" required>
                  <option value="">Selecciona una Subcategoría</option>
                </select>
                <label for="subcategoria">Subcategoría</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating">
                <select id="marca" name="idMarca" class="form-select" required>
                  <option value="">Selecciona una Marca</option>
                </select>
                <label for="marca">Marca</label>
              </div>
            </div>
          </div>

          <div class="row g-3 mt-2">
            <div class="col-md-6">
              <div class="form-floating">
                <select id="condicion" name="condicion" class="form-select" required>
                  <option value="">Selecciona una condición</option>
                  <option value="Dañado">Dañado</option>
                  <option value="Reparación">En Reparación</option>
                  <option value="Bueno">Bueno</option>
                </select>
                <label for="condicion">Condición</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating">
                <input type="text" id="modelo" name="modelo" class="form-control" placeholder="Modelo" required />
                <label for="modelo">Modelo</label>
              </div>
            </div>
          </div>

          <div class="row g-3 mt-2">
            <div class="col-md-6">
              <div class="form-floating">
                <input type="text" id="numSerie" name="numSerie" class="form-control" placeholder="Número de Serie" required />
                <label for="numSerie">Número de Serie</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating">
                <input type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Descripción" required />
                <label for="descripcion">Descripción</label>
              </div>
            </div>
          </div>

          <div class="row g-3 mt-2">
            <div class="col-md-6">
              <div class="form-floating">
                <input type="file" id="fotografia" name="fotografia" class="form-control" accept="image/*" required />
                <label for="fotografia">Imagen</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating">
                <select id="idusuario" name="idUsuario" class="form-select" required>
                  <option value="">Seleccione Usuario a Cargo</option>
                </select>
                <label for="idusuario">Usuario a Cargo</label>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer text-end">
          <button class="btn btn-primary" id="addBien" type="submit">
            <i class="fa-solid fa-check me-1"></i> Agregar Bien
          </button>
        </div>
      </div>
    </form>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const categoriaSelect = document.querySelector("#categoria");
      const subCategoriaSelect = document.querySelector("#subcategoria");
      const marcaSelect = document.querySelector("#marca");
      const usuarioSelect = document.querySelector("#idusuario");

      // Cargar Categorías
      fetch("../../controller/BienController.php?task=getCategorias")
        .then((response) => response.json())
        .then((data) => {
          data.forEach((categoria) => {
            categoriaSelect.innerHTML += `<option value="${categoria.idCategoria}">${categoria.categoria}</option>`;
          });
        });

      // Cargar Subcategorías
      categoriaSelect.addEventListener("change", () => {
        const idCategoria = categoriaSelect.value;
        subCategoriaSelect.innerHTML = '<option value="">Selecciona una Subcategoría</option>';

        fetch(`../../controller/BienController.php?task=getSubCategorias&idCategoria=${idCategoria}`)
          .then((response) => response.json())
          .then((data) => {
            data.forEach((subcategoria) => {
              subCategoriaSelect.innerHTML += `<option value="${subcategoria.idSubCategoria}">${subcategoria.subCategoria}</option>`;
            });
          })
          .catch((error) => {
            console.error("Error al cargar subcategorías:", error);
          });
      });

      // Cargar Marcas
      subCategoriaSelect.addEventListener("change", () => {
        const idSubCategoria = subCategoriaSelect.value;
        marcaSelect.innerHTML = '<option value="">Selecciona una Marca</option>';

        fetch(`../../controller/BienController.php?task=getMarcas&idSubCategoria=${idSubCategoria}`)
          .then((response) => response.json())
          .then((data) => {
            data.forEach((marca) => {
              marcaSelect.innerHTML += `<option value="${marca.idMarca}">${marca.marca}</option>`;
            });
          })
          .catch((error) => {
            console.error("Error al cargar marcas:", error);
          });
      });

      // Cargar Usuarios
      fetch("../../controller/BienController.php?task=getUsuarios")
        .then((response) => response.json())
        .then((data) => {
          data.forEach((usuario) => {
            usuarioSelect.innerHTML += `<option value="${usuario.idUsuario}">${usuario.nomUser}</option>`;
          });
        })
        .catch((error) => {
          console.error("Error al cargar usuarios:", error);
        });
    });

    const formulario = document.querySelector("#registrar-bien");

    function registrarBien() {
      const form = document.querySelector("#registrar-bien");
      const formData = new FormData(form);

      fetch(`../../controller/BienController.php`, {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.filas > 0) {
            formulario.reset();
            Swal.fire({
              title: "CONFIRMADO",
              text: "Bien Registrado",
              icon: "success",
              footer: "SENATI ING. SOFTWARE",
              confirmButtonText: "OK",
              confirmButtonColor: "#198754",
            });
          } else {
            Swal.fire({
              icon: 'warning',
              title: 'Sin cambios',
              text: 'No se realizó el registro.',
              confirmButtonColor: '#ffc107'
            });
          }
        })
        .catch((error) => {
          console.error(error);
          Swal.fire({
            icon: "error",
            title: "Error del servidor",
            text: "No se pudo registrar el bien.",
            confirmButtonColor: "#dc3545",
          });
        });
    }

    formulario.addEventListener("submit", function (event) {
      event.preventDefault();

      Swal.fire({
        title: "¿Registrar Bien?",
        text: "Confirme si desea registrar el nuevo bien.",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#0d6efd",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Registrar",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.isConfirmed) {
          registrarBien();
        }
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>

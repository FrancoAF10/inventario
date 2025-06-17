<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Editar Bien</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      background-color: #f8f9fa;
    }
    .card {
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .btn {
      transition: all 0.3s ease-in-out;
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
      <h2 class="text-primary">Editar Bien</h2>
      <button onclick="window.location.href='./listarBien.php'" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Volver
      </button>
    </div>

    <form id="form-editar-bien" autocomplete="off" novalidate>
      <div class="card">
        <div class="card-header bg-primary text-white">
          <strong>Formulario de Edición</strong>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-4">
              <div class="form-floating">
                <select id="categoria" class="form-select" required>
                  <option value="">Seleccione una Categoría</option>
                </select>
                <label for="categoria">Categoría</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating">
                <select id="subcategoria" class="form-select" required>
                  <option value="">Seleccione una Subcategoría</option>
                </select>
                <label for="subcategoria">Subcategoría</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating">
                <select id="marca" class="form-select" required>
                  <option value="">Seleccione una Marca</option>
                </select>
                <label for="marca">Marca</label>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-floating">
                <select id="condicion" class="form-select" required>
                  <option value="">Seleccione condición</option>
                  <option value="Bueno">Bueno</option>
                  <option value="Dañado">Dañado</option>
                  <option value="Reparación">Reparación</option>
                </select>
                <label for="condicion">Condición</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating">
                <input type="text" id="modelo" class="form-control" placeholder="Modelo" required />
                <label for="modelo">Modelo</label>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-floating">
                <input type="text" id="numSerie" class="form-control" placeholder="Número de Serie" required />
                <label for="numSerie">Número de Serie</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating">
                <input type="text" id="descripcion" class="form-control" placeholder="Descripción" required />
                <label for="descripcion">Descripción</label>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label for="fotografia" class="form-label">Fotografía</label>
                <input type="file" id="fotografia" name="fotografia" class="form-control" accept="image/*" />
                <img id="previewImagen" src="" alt="Imagen actual" width="150" class="mt-2 rounded shadow-sm" />
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-floating">
                <select id="idusuario" class="form-select" required>
                  <option value="">Seleccione un Usuario</option>
                </select>
                <label for="idusuario">Usuario</label>
              </div>
            </div>
          </div>
        </div>

        <div class="card-footer text-end">
          <button class="btn btn-primary" type="submit">
            <i class="fa-solid fa-floppy-disk me-1"></i> Actualizar Bien
          </button>
        </div>
      </div>
    </form>
  </div>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    const idBien = urlParams.get("id");

    let imagenActualBase64 = "";

    // Cargar datos del bien
    fetch(`../../controller/BienController.php?task=getById&idBien=${idBien}`)
      .then(res => res.json())
      .then(bien => {
        document.getElementById("modelo").value = bien.modelo || "";
        document.getElementById("numSerie").value = bien.numSerie || "";
        document.getElementById("descripcion").value = bien.descripcion || "";
        document.getElementById("condicion").value = bien.condicion || "";
        if (bien.fotografia) {
          imagenActualBase64 = bien.fotografia;
          document.getElementById("previewImagen").src = `data:image/jpeg;base64,${imagenActualBase64}`;
        } else {
          document.getElementById("previewImagen").src = "";
        }
        cargarCategorias(bien.idCategoria, bien.idSubCategoria, bien.idMarca);
        cargarUsuarios(bien.idUsuario);
      });

    function cargarCategorias(idCategoria, idSubCategoria, idMarca) {
      fetch(`../../controller/BienController.php?task=getCategorias`)
        .then(res => res.json())
        .then(data => {
          const select = document.getElementById("categoria");
          select.innerHTML = '<option value="">Seleccione una Categoría</option>';
          data.forEach(c => {
            select.innerHTML += `<option value="${c.idCategoria}" ${c.idCategoria == idCategoria ? "selected" : ""}>${c.categoria}</option>`;
          });
          cargarSubcategorias(idCategoria, idSubCategoria, idMarca);
        });
    }

    function cargarSubcategorias(idCategoria, idSubCategoria, idMarca) {
      fetch(`../../controller/BienController.php?task=getSubCategorias&idCategoria=${idCategoria}`)
        .then(res => res.json())
        .then(data => {
          const select = document.getElementById("subcategoria");
          select.innerHTML = '<option value="">Seleccione una Subcategoría</option>';
          data.forEach(s => {
            select.innerHTML += `<option value="${s.idSubCategoria}" ${s.idSubCategoria == idSubCategoria ? "selected" : ""}>${s.subCategoria}</option>`;
          });
          cargarMarcas(idSubCategoria, idMarca);
        });
    }

    function cargarMarcas(idSubCategoria, idMarca) {
      fetch(`../../controller/BienController.php?task=getMarcas&idSubCategoria=${idSubCategoria}`)
        .then(res => res.json())
        .then(data => {
          const select = document.getElementById("marca");
          select.innerHTML = '<option value="">Seleccione una Marca</option>';
          data.forEach(m => {
            select.innerHTML += `<option value="${m.idMarca}" ${m.idMarca == idMarca ? "selected" : ""}>${m.marca}</option>`;
          });
        });
    }

    function cargarUsuarios(idUsuario) {
      fetch(`../../controller/BienController.php?task=getUsuarios`)
        .then(res => res.json())
        .then(data => {
          const select = document.getElementById("idusuario");
          select.innerHTML = '<option value="">Seleccione un Usuario</option>';
          data.forEach(u => {
            select.innerHTML += `<option value="${u.idUsuario}" ${u.idUsuario == idUsuario ? "selected" : ""}>${u.nomUser}</option>`;
          });
        });
    }

    // Actualizar preview de imagen al seleccionar archivo
    document.getElementById("fotografia").addEventListener("change", e => {
      const file = e.target.files[0];
      if (!file) {
        document.getElementById("previewImagen").src = imagenActualBase64 ? `data:image/jpeg;base64,${imagenActualBase64}` : "";
        return;
      }
      const reader = new FileReader();
      reader.onload = () => {
        document.getElementById("previewImagen").src = reader.result;
      };
      reader.readAsDataURL(file);
    });

    // Enviar formulario
    document.getElementById("form-editar-bien").addEventListener("submit", async e => {
      e.preventDefault();

      let fotografiaBase64 = imagenActualBase64;

      const inputFile = document.getElementById("fotografia");
      if (inputFile.files.length > 0) {
        const file = inputFile.files[0];
        fotografiaBase64 = await new Promise((resolve, reject) => {
          const reader = new FileReader();
          reader.onload = () => resolve(reader.result.split(",")[1]);
          reader.onerror = reject;
          reader.readAsDataURL(file);
        });
      }

      Swal.fire({
        title: "¿Actualizar bien?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Sí, actualizar",
        confirmButtonColor: "#0d6efd",
        cancelButtonText: "Cancelar"
      }).then(result => {
        if (result.isConfirmed) {
          fetch("../../controller/BienController.php", {
            method: "PUT",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
              idBien,
              condicion: document.getElementById("condicion").value,
              modelo: document.getElementById("modelo").value,
              numSerie: document.getElementById("numSerie").value,
              descripcion: document.getElementById("descripcion").value,
              fotografia: fotografiaBase64,
              idMarca: parseInt(document.getElementById("marca").value),
              idUsuario: parseInt(document.getElementById("idusuario").value),
            }),
          })
            .then(res => res.json())
            .then(data => {
              if (data.filas > 0) {
                Swal.fire("Actualizado", "El bien fue actualizado con éxito", "success").then(() => {
                  window.location.href = "./listarBien.php";
                });
              } else {
                Swal.fire("Sin cambios", "No se realizó ninguna actualización", "info");
              }
            })
            .catch(() => {
              Swal.fire("Error", "No se pudo actualizar el bien.", "error");
            });
        }
      });
    });
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

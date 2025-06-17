<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Actualizar Categoría</title>

  <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      background-color: #f8f9fa;
    }
    .card {
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
    <h2 class="text-primary">Actualizar Categoría</h2>
    <button onclick="window.location.href='./listarCategoria.php'" class="btn btn-outline-secondary">
      <i class="fa-solid fa-arrow-left me-1"></i> Volver
    </button>
  </div>

  <form id="formulario-registrar" autocomplete="off">
    <div class="card">
      <div class="card-header bg-info text-white">
        <strong>Formulario de Actualización</strong>
      </div>
      <div class="card-body">
        <div class="form-floating mb-3">
          <input type="text" id="categoria" name="categoria" class="form-control" placeholder="Nombre de la categoría" required />
          <label for="categoria">Nombre de la Categoría</label>
        </div>
      </div>
      <div class="card-footer text-end">
        <button class="btn btn-primary" type="submit">
          <i class="fa-solid fa-floppy-disk me-1"></i> Guardar Cambios
        </button>
      </div>
    </div>
  </form>
</div>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    const idcategoria = urlParams.get("id");

    fetch(`../../controller/CategoriaController.php?task=getById&idCategoria=${idcategoria}`)
      .then(response => response.json())
      .then(data => {
        if (data.length > 0) {
          document.getElementById("categoria").value = data[0].categoria;
        }
      })
      .catch(error => {
        console.error("Error al cargar la categoría:", error);
        Swal.fire("Error", "No se pudo cargar la información.", "error");
      });

    document.getElementById("formulario-registrar").addEventListener("submit", function (e) {
      e.preventDefault();
      const nombreCategoria = document.getElementById("categoria").value.trim();

      if (!nombreCategoria) {
        Swal.fire("Campo vacío", "Por favor ingrese un nombre de categoría.", "warning");
        return;
      }

      Swal.fire({
        title: '¿Actualizar categoría?',
        text: "Esta acción modificará la información.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, actualizar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          fetch('../../controller/CategoriaController.php', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ idCategoria: idcategoria, categoria: nombreCategoria })
          })
            .then(res => res.json())
            .then(data => {
              if (data.filas > 0) {
                Swal.fire({
                  title: 'Actualizado',
                  text: 'Categoría actualizada correctamente.',
                  icon: 'success',
                  confirmButtonColor: '#198754'
                }).then(() => {
                  window.location.href = "./listarCategoria.php";
                });
              } else {
                Swal.fire("Sin cambios", "No se actualizó el registro.", "info");
              }
            })
            .catch(err => {
              console.error("Error al actualizar:", err);
              Swal.fire("Error", "No se pudo actualizar la categoría.", "error");
            });
        }
      });
    });
  });
</script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

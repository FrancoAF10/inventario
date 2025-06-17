<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registrar Categoría</title>

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
    <h2 class="text-primary">Registrar Nueva Categoría</h2>
    <button onclick="window.location.href='./listarCategoria.php'" class="btn btn-outline-secondary">
      <i class="fa-solid fa-arrow-left me-1"></i> Volver
    </button>
  </div>

  <form autocomplete="off" id="formulario-registrar">
    <div class="card">
      <div class="card-header bg-primary text-white">
        <strong>Formulario de Registro</strong>
      </div>
      <div class="card-body">
        <div class="form-floating mb-3">
          <input type="text" id="categoria" name="categoria" class="form-control" placeholder="Nombre de la categoría" required />
          <label for="categoria">Nombre de la Categoría</label>
        </div>
      </div>
      <div class="card-footer text-end">
        <button class="btn btn-primary" type="submit">
          <i class="fa-solid fa-check me-1"></i> Registrar Categoría
        </button>
      </div>
    </div>
  </form>
</div>

<script>
  const formulario = document.getElementById("formulario-registrar");

  function registrarCategoria() {
    const nombreCategoria = document.getElementById("categoria").value.trim();

    fetch(`../../controller/CategoriaController.php`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ categoria: nombreCategoria })
    })
      .then(response => response.json())
      .then(data => {
        if (data.filas > 0) {
          formulario.reset();
          Swal.fire({
            icon: 'success',
            title: 'Categoría registrada',
            text: 'La nueva categoría se registró correctamente.',
            footer: 'SENATI ING. SOFTWARE',
            confirmButtonColor: '#198754'
          }).then(() => {
            window.location.href = "./listarCategoria.php";
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
      .catch(error => {
        console.error("Error:", error);
        Swal.fire({
          icon: 'error',
          title: 'Error del servidor',
          text: 'No se pudo registrar la categoría.',
          confirmButtonColor: '#dc3545'
        });
      });
  }

  formulario.addEventListener("submit", function (event) {
    event.preventDefault();

    Swal.fire({
      title: '¿Registrar Categoría?',
      text: 'Confirme si desea registrar la nueva categoría.',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#0d6efd',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Registrar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        registrarCategoria();
      }
    });
  });
</script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>

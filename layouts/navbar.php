<?php include_once(__DIR__ . '/url.php'); ?>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand text-primary fw-bold" href="<?= $base_url ?>/index.php">
      <i class="fa-solid fa-boxes-stacked me-2"></i>Inventario
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">

        <!-- Catálogos -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="catalogosDropdown" role="button" data-bs-toggle="dropdown">
            <i class="fa-solid fa-layer-group me-1"></i>Catálogos
          </a>
          <ul class="dropdown-menu" aria-labelledby="catalogosDropdown">
            <li><a class="dropdown-item" href="<?= $base_url ?>/view/areas/listarArea.php">Áreas</a></li>
            <li><a class="dropdown-item" href="<?= $base_url ?>/view/roles/ListarRoles.php">Roles</a></li>
            <li><a class="dropdown-item" href="<?= $base_url ?>/view/categorias/listarCategoria.php">Categorías</a></li>
            <li><a class="dropdown-item" href="<?= $base_url ?>/view/SubCategoria/ListarSubcategorias.php">Subcategorías</a></li>
            <li><a class="dropdown-item" href="<?= $base_url ?>/view/marcas/ListarMarcas.php">Marcas</a></li>
          </ul>
        </li>

        <!-- Personas -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="personasDropdown" role="button" data-bs-toggle="dropdown">
            <i class="fa-solid fa-user-group me-1"></i>Personas
          </a>
          <ul class="dropdown-menu" aria-labelledby="personasDropdown">
            <li><a class="dropdown-item" href="<?= $base_url ?>/view/personas/ListarPersonas.php">Personas</a></li>
            <li><a class="dropdown-item" href="<?= $base_url ?>/view/colaboradores/listarColaboradores.php">Colaboradores</a></li>
            <li><a class="dropdown-item" href="<?= $base_url ?>/view/usuarios/listarUsuarios.php">Usuarios</a></li>
          </ul>
        </li>

        <!-- Gestión -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="gestionDropdown" role="button" data-bs-toggle="dropdown">
            <i class="fa-solid fa-gear me-1"></i>Gestión
          </a>
          <ul class="dropdown-menu" aria-labelledby="gestionDropdown">
            <li><a class="dropdown-item" href="<?= $base_url ?>/view/bienes/listarBien.php">Bienes</a></li>
            <li><a class="dropdown-item" href="<?= $base_url ?>/view/asignaciones/listarAsignaciones.php">Asignaciones</a></li>
            <li><a class="dropdown-item" href="<?= $base_url ?>/view/caracteristicas/listarCaracteristicas.php">Características</a></li>
            <li><a class="dropdown-item" href="<?= $base_url ?>/view/detalles/listarDetalles.php">Detalles</a></li>
            <li><a class="dropdown-item" href="<?= $base_url ?>/view/configuracion/listarConfiguracion.php">Configuraciones</a></li>
          </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>

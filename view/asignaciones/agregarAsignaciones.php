<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<div class="container my-5">
        <form action="" method="" autocomplete="off">
        <h2 class="text-center mb-4">Asignaciones</h2>
    
         <div class="mb-3">
            <label for="bienSelect" class="form-label">Bien:</label>
            <select id="bienSelect" class="form-select" required>
                <option value="">Seleccionar Bien</option>
            </select>
        </div>
    
        <div class="mb-3">
            <label for="colaboradorSelect" class="form-label">colaborador:</label>
            <select id="colaboradorSelect" class="form-select" required>
                <option value="">Seleccionar colaborador</option>
            </select>
        </div>
    
        <div class="mb-3">
            <label for="fechainicioasig" class="form-label">Fecha Inicio:</label>
            <input type="date" class="form-control" id="fechainicioasig" name="fechainicioasig" required>
        </div>
        <div class="mb-3">
            <label for="fechafinasig" class="form-label">Fecha Final</label>
            <input type="date" class="form-control" id="fechafinasig" name="fechafinasig" required>
        </div>

</form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
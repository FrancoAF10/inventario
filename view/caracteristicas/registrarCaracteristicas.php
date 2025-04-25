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
        <form action="" method="">
        <h2 class="text-center mb-4">Agregar Caracteristicas:</h2>
    
        <div class="mb-3">
            <label for="caracteristica" class="form-label">Segmento:</label>
            <input type="text" id="caracteristica" name="caracteristica" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="bienSelect" class="form-label">Seleccionar Bien:</label>
            <select id="bienSelect" class="form-select" required>
                <option value="">Seleccione Bien:</option>
            </select>
        </div>

        <div class="d-grid gap-2">
            <button class="btn btn-primary" id="addCaracteristica">Agregar</button>
        </div>
    </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
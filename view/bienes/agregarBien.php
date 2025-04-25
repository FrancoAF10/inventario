<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container my-5">
        <form action="" id="registrar-bien">
            <h2 class="text-center mb-4">Gestión de Bienes</h2>

            <div class="mb-3">
                <label for="idmarca" class="form-label">Marca:</label>
                <select id="idmarca" class="form-select" required>
                    <option value="">Selecciona una marca</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="condicionSelect" class="form-label">condición:</label>
                <select id="condicion" class="form-select" required>
                    <option value="">Selecciona una condicion</option>
                    <option value="Dañado">Dañado</option>
                    <option value="Reparación">En Reparación</option>
                    <option value="Bueno">Bueno</option>

                </select>
            </div>
            <div class="mb-3">
                <label for="modelo" class="form-label">Modelo:</label>
                <input type="text" id="modelo" name="modelo" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="numSerie" class="form-label">Número de Serie:</label>
                <input type="text" id="numSerie" name="numSerie" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <input type="text" id="descripcion" name="descripcion" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="fotografia" class="form-label">imagen:</label>
                <input type="file" id="fotografia" name="fotografia" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="usuario" class="form-label">Seleccionar Usuario:</label>
                <select id="idusuario" class="form-select" required>
                    <option value="">Seleccione Usuario a Cargo:</option>
                </select>
            </div>

            <div class="d-grid gap-2">
                <button class="btn btn-primary" id="addBien">Agregar Bien</button>
            </div>
        </form>
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const marca = document.querySelector("#idmarca"); // Tu select de marcas
                // Obtener las las marcas cuando cargue la página
                fetch("../../controller/BienController.php?task=getMarcas")
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(marcas => {
                            marca.innerHTML += `<option value="${marcas.idMarca}">${marcas.marca}</option>`;
                        });
                    })
                    .catch(error => {
                        console.error(error);
                    });
            });
            document.addEventListener("DOMContentLoaded", () => {
                const usuario = document.querySelector('#idusuario'); //select usuarios
                // Obtener las las marcas cuando cargue la página
                fetch("../../controller/BienController.php?task=getUsuarios")
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(usuarios => {
                            usuario.innerHTML += `<option value="${usuarios.idUsuario}">${usuarios.nomUser}</option>`;
                        });
                    })
                    .catch(error => {
                        console.error(error);
                    });
            });

            //AGREGAMOS UN REGISTRO
            const formulario = document.querySelector("#registrar-bien");

            function registrarBien() {
                fetch(`../../controller/BienController.php`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        condicion       : document.querySelector('#condicion').value,
                        modelo          : document.querySelector('#modelo').value,
                        numSerie        : document.querySelector('#numSerie').value,
                        descripcion     : document.querySelector('#descripcion').value,
                        fotografia      : document.querySelector('#fotografia').value,
                        idMarca         : parseInt(document.querySelector('#idmarca').value),
                        idUsuario       : parseInt(document.querySelector('#idusuario').value),
                    })
                })
                    .then(response => { return response.json() })
                    .then(data => {
                        if (data.filas > 0) {
                            formulario.reset();
                            alert("Guardado correctamente");
                        }
                    })
                    .catch(error => { console.error(error) });
            }
            //formulario=botonb[submit](validar Front)
            formulario.addEventListener("submit", function (event) {
                event.preventDefault();//cancela el evento

                if (confirm("¿Está seguro de registrar?")) {
                    registrarBien();
                }
            });

        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>

</body>

</html>
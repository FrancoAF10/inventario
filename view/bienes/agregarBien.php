<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <div class="container my-5">
        <form action="" id="registrar-bien">
            <h2 class="text-center mt-5">REGISTRAR BIEN</h2>
            <button id="vlvlstbien" type="button" onclick="window.location.href='././listarBien.php'" class="btn btn-success"><i class="fa-solid fa-arrow-left"></i> VOLVER</button>
            <hr>
            <div class="card mt-3">
                <div class="card-header bg-info"><strong>REGISTRAR</strong></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div class="form-floating">
                                <select id="categoria" name="categoria" class="form-select" required>
                                    <option value="">Selecciona una Categoria</option>
                                </select>
                                <label for="categoria" class="form-label">Categoria:</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-floating">
                                <select id="subcategoria" class="form-select" required>
                                    <option value="">Selecciona una Subcategoria</option>
                                </select>
                                <label for="subcategoria" class="form-label">Subcategoria:</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-floating">
                                <select id="marca" class="form-select" required>
                                    <option value="">Selecciona una Marca</option>
                                </select>
                                <label for="marca" class="form-label">Marca:</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-floating">
                                <select id="condicion" class="form-select" required>
                                    <option value="">Selecciona una condicion</option>
                                    <option value="Dañado">Dañado</option>
                                    <option value="Reparación">En Reparación</option>
                                    <option value="Bueno">Bueno</option>
                                </select>
                                <label for="condicionSelect" class="form-label">condición:</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-floating">
                                <input type="text" id="modelo" name="modelo" class="form-control" placeholder="Modelo"
                                    required>
                                <label for="modelo" class="form-label">Modelo:</label>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-floating">
                                <input type="text" id="numSerie" name="numSerie" class="form-control"
                                    placeholder="Número de Serie" required>
                                <label for="numSerie" class="form-label">Número de Serie:</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-floating">
                                <input type="text" id="descripcion" name="descripcion" class="form-control"
                                    placeholder="Descripción" required>
                                <label for="descripcion" class="form-label">Descripción:</label>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-floating">
                                <input type="file" id="fotografia" name="fotografia" class="form-control" required>
                                <label for="fotografia" class="form-label">Imagen:</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <select id="idusuario" class="form-select" required>
                                    <option value="">Seleccione Usuario a Cargo:</option>
                                </select>
                                <label for="usuario" class="form-label">Seleccionar Usuario:</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-grid gap-2">
                        <button class="btn btn-primary" id="addBien">Agregar Bien</button>
                    </div>
                </div>
            </div>
        </form>
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const categoriaSelect = document.querySelector("#categoria");
                const subCategoriaSelect = document.querySelector("#subcategoria");
                const marcaSelect = document.querySelector("#marca");
                const usuarioSelect = document.querySelector("#idusuario");



                // Cargar Categorías
                fetch("../../controller/BienController.php?task=getCategorias")
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


                    fetch(`../../controller/BienController.php?task=getSubCategorias&idCategoria=${idCategoria}`)
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

                    fetch(`../../controller/BienController.php?task=getMarcas&idSubCategoria=${idsubCategoria}`)
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

                fetch("../../controller/BienController.php?task=getUsuarios")
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(usuario => {
                            usuarioSelect.innerHTML += `<option value="${usuario.idUsuario}">${usuario.nomUser}</option>`;
                        });
                    })
                    .catch(error => {
                        console.error("Error al cargar usuarios:", error);
                    });

            });

            //AGREGAMOS UN REGISTRO
            const formulario = document.querySelector("#registrar-bien");

            function registrarBien() {
                fetch(`../../controller/BienController.php`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        condicion: document.querySelector('#condicion').value,
                        modelo: document.querySelector('#modelo').value,
                        numSerie: document.querySelector('#numSerie').value,
                        descripcion: document.querySelector('#descripcion').value,
                        fotografia: document.querySelector('#fotografia').value,
                        idMarca: parseInt(document.querySelector('#marca').value),
                        idUsuario: parseInt(document.querySelector('#idusuario').value),
                    })
                })
                    .then(response => { return response.json() })
                    .then(data => {
                        if (data.filas > 0) {
                            formulario.reset();
                            Swal.fire({
                                title: 'CONFIRMADO',
                                text: 'Bien Registrado',
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
                    title: 'BIENES',
                    text: '¿Está seguro de registrar?',
                    icon: 'question',
                    footer: 'SENATI ING. SOFTWARE',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#2980b9',
                    showCancelButton: true,
                    cancelButtonText: 'cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        registrarBien();
                    }
                })
            });

        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>

</body>

</html>
<?php


if(isset($_SERVER['REQUEST_METHOD'])){
  
  require_once "../models/Bien.php";
  $bien = new Bien();

  switch($_SERVER["REQUEST_METHOD"]){
    case "GET":
      header("Content-Type: application/json; charset=utf-8");

      //DEBEMOS IDENTIFICAR SI EL USUARIO REQUIERE LISTAR/BUSCAR
      if($_GET["task"]=='getAll'){
        echo json_encode($bien->getAll());
      }else if($_GET["task"] == 'getCategorias') {
        echo json_encode($bien->getCategorias());
      }else if($_GET["task"] == 'getSubCategorias') {
        echo json_encode($bien->getSubCategorias($_GET['idCategoria']));
      }else if($_GET["task"]=='getMarcas'){
        echo json_encode($bien->getMarcas($_GET['idSubCategoria']));
      }else if($_GET["task"]=='getUsuarios'){
        echo json_encode($bien->getUsuarios() );
      }else if($_GET["task"]=='getById'){
        echo json_encode($bien->getById($_GET['idBien']));
      }
      break;

case "POST":
    header("Content-Type: application/json; charset=utf-8");

    // Manejo de imagen subida (file)
    $imagenBase64 = null;
    if (isset($_FILES['fotografia']) && $_FILES['fotografia']['tmp_name'] != "") {
        $imagenBinaria = file_get_contents($_FILES['fotografia']['tmp_name']);
        $imagenBase64 = base64_encode($imagenBinaria);
    }

    $registro = [
        "condicion"   => $_POST["condicion"],
        "modelo"      => $_POST["modelo"],
        "numSerie"    => $_POST["numSerie"],
        "descripcion" => $_POST["descripcion"],
        "fotografia"  => $imagenBase64,
        "idMarca"     => $_POST["idMarca"],
        "idUsuario"   => $_POST["idUsuario"],
    ];

    $filasAfectadas = $bien->add($registro);
    echo json_encode(["filas" => $filasAfectadas]);
    break;

      case "PUT":
    $input = file_get_contents("php://input");
    $dataJSON = json_decode($input, true);

    $registro = [
        "idBien"      => $dataJSON["idBien"],
        "condicion"   => $dataJSON["condicion"],
        "modelo"      => $dataJSON["modelo"],
        "numSerie"    => $dataJSON["numSerie"],
        "descripcion" => $dataJSON["descripcion"],
        "fotografia"  => $dataJSON["fotografia"],
        "idMarca"     => $dataJSON["idMarca"],
        "idUsuario"   => $dataJSON["idUsuario"]
    ];

    $filasAfectadas = $bien->update($registro);

    header("Content-Type: application/json; charset=utf-8");
    echo json_encode(["filas" => $filasAfectadas]);
    break;

      
      case "DELETE":
          header("Content-Type: application/json; charset=utf-8");
          //El usuario enviará el id en la url => miurl.com/ideliminar
          //PASO 1: Obtener la URL desde el cliente
          $url= $_SERVER['REQUEST_URI'];
          //Paso 2: convertir la URL en un array
          $arrayURL=explode('/',$url);
          //paso 3: obtener el id
          $idbien=end($arrayURL);

          $filasafectadas=$bien-> delete (['idBien'=>$idbien]);
          echo json_encode(['filas'=>$filasafectadas]);
          break;
        
    }
    
}
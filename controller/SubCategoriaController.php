<?php

if(isset($_SERVER['REQUEST_METHOD'])){
  
  require_once "../models/SubCategoria.php";
  $subcategoria = new SubCategoria();
 
  switch($_SERVER["REQUEST_METHOD"]){
    case "GET":
      header("Content-Type: application/json; charset=utf-8");

      //DEBEMOS IDENTIFICAR SI EL USUARIO REQUIERE LISTAR/BUSCAR
      if($_GET["task"]=='getAll'){
        echo json_encode($subcategoria->getAll() );
      }else if ($_GET["task"] == 'getCategorias') {
        echo json_encode($subcategoria->getCategorias()); 
      }else if ($_GET["task"] == 'getById') {
        echo json_encode($subcategoria->getById($_GET["idSubCategoria"])); 
      }
      break;
      case "POST":
        //Obtener los datos enviados desde el cliente
        $input = file_get_contents("php://input");
        $dataJSON=json_decode($input,true);

        //creamos un array asociativo con lo datossd el nuevo registro 
        $registro=[
          "subCategoria"        =>$dataJSON["subCategoria"],
          "idCategoria"         =>$dataJSON["idCategoria"],

        ];
        //Obtenemos el némero de registros
        $filasAfectadas=$subcategoria->add($registro);

        //Notificamos al usuari el número de filas en formato JSON
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode(["filas"=>$filasAfectadas]);
      break;  

      case "PUT":
        $input = file_get_contents("php://input");
        $dataJSON = json_decode($input, true);
  
        $registro = [
          "idSubCategoria" => $dataJSON["idSubCategoria"],
          "subCategoria" => $dataJSON["subCategoria"],
          "idCategoria"=> $dataJSON["idCategoria"],
        ];
  
        $filasAfectadas = $subcategoria->update($registro);
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
        $idSubCategoria=end($arrayURL);

        $filasafectadas=$subcategoria-> delete (['idSubCategoria'=>$idSubCategoria]);
        echo json_encode(['filas'=>$filasafectadas]);
        break;
  }
    
    
}
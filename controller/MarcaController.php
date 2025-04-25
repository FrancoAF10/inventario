<?php

if(isset($_SERVER['REQUEST_METHOD'])){
  
  require_once "../models/Marca.php";
  $marca = new Marca();

  switch($_SERVER["REQUEST_METHOD"]){
    case "GET":

      header("Content-Type: application/json; charset=utf-8");

      //DEBEMOS IDENTIFICAR SI EL USUARIO REQUIERE LISTAR/BUSCAR
      if($_GET["task"]=='getAll'){
        echo json_encode($marca->getAll() );
      }else if ($_GET["task"] == 'getCategorias') {
        echo json_encode($marca->getCategorias());
      } else if ($_GET["task"] == 'getsubCategorias') {
        echo json_encode($marca->getsubCategorias($_GET['idCategoria']));
      }
      break;
      case "POST":
        //Obtener los datos enviados desde el cliente
        $input = file_get_contents("php://input");
        $dataJSON=json_decode($input,true);

        //creamos un array asociativo con lo datos del nuevo registro 
        $registro=[
          "marca"                 =>$dataJSON["marca"],
          "idSubCategoria"        =>$dataJSON["idSubCategoria"],

        ];
        //Obtenemos el número de registros
        $filasAfectadas=$marca->add($registro);

        //Notificamos al usuari el número de filas en formato JSON
        //{"filas":1}
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode(["filas"=>$filasAfectadas]);
      break;
      case "DELETE":
        header("Content-Type: application/json; charset=utf-8");
        //El usuario enviará el id en la url => miurl.com/ideliminar
        //PASO 1: Obtener la URL desde el cliente
        $url= $_SERVER['REQUEST_URI'];
        //Paso 2: convertir la URL en un array
        $arrayURL=explode('/',$url);
        //paso 3: obtener el id
        $idMarca=end($arrayURL);

        $filasafectadas=$marca-> delete (['idMarca'=>$idMarca]);
        echo json_encode(['filas'=>$filasafectadas]);
        break;
    
  }
}
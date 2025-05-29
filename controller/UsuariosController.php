<?php

if(isset($_SERVER['REQUEST_METHOD'])){
  
  require_once "../models/Usuarios.php";
  $usuario = new Usuarios();

  switch($_SERVER["REQUEST_METHOD"]){
    case "GET":
      header("Content-Type: application/json; charset=utf-8");

      //DEBEMOS IDENTIFICAR SI EL USUARIO REQUIERE LISTAR/BUSCAR
      if($_GET["task"]=='getAll'){
        echo json_encode($usuario->getAll() );
      }else if($_GET["task"]=='getColaboradores'){
        echo json_encode($usuario->getColaboradores());
      }else if($_GET["task"]=='getById'){
        echo json_encode($usuario->getById($_GET['idUsuario']));
      }
      break;

      case "POST":
        //Obtener los datos enviados
        $input = file_get_contents("php://input");
        $dataJSON=json_decode($input,true);

        //creamos un array asociativo con lo datos del nuevo registro 
        $registro=[
          "nomUser"             =>$dataJSON["nomUser"],
          "passUser"            =>$dataJSON["passUser"],
          "estado"              =>$dataJSON["estado"],
          "idColaborador"       =>$dataJSON["idColaborador"],


        ];
        //Obtenemos el número de registros
        $filasAfectadas=$usuario->add($registro);

        //Notificamos al usuario el número de filas en formato JSON
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode(["filas"=>$filasAfectadas]);
      break;
      case "PUT":
        $input = file_get_contents("php://input");
        $dataJSON = json_decode($input, true);
  
        $registro = [
          "nomUser"             =>$dataJSON["nomUser"],
          "passUser"            =>$dataJSON["passUser"],
          "estado"              =>$dataJSON["estado"],
          "idColaborador"       =>$dataJSON["idColaborador"],
          "idUsuario"           =>$dataJSON["idUsuario"],
        ];
  
        $filasAfectadas = $usuario->update($registro);
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
          $idusuario=end($arrayURL);

          $filasafectadas=$usuario-> delete (['idUsuario'=>$idusuario]);
          echo json_encode(['filas'=>$filasafectadas]);
          break;
        
    }
    
}
<?php

if(isset($_SERVER['REQUEST_METHOD'])){
  
  require_once "../models/Colaborador.php";
  $colaborador = new Colaborador();

  switch($_SERVER["REQUEST_METHOD"]){
    case "GET":
      //sleep(3);
      header("Content-Type: application/json; charset=utf-8");

      //DEBEMOS IDENTIFICAR SI EL USUARIO REQUIERE LISTAR/BUSCAR
      if($_GET["task"]=='getAll'){
        echo json_encode($colaborador->getAll() );
      }else if($_GET["task"]=='getPersonas'){
        echo json_encode($colaborador->getPersonas() );
      }else if($_GET["task"]=='getAreas'){
        echo json_encode($colaborador->getAreas() );
      }else if($_GET["task"]=='getRoles'){
        echo json_encode($colaborador->getRoles() );
      }else if($_GET["task"]=='getById'){
        echo json_encode($colaborador->getById($_GET['idColaborador']));
      }
      break;

      case "POST":
        //Obtener los datos enviados desde el cliente
        $input = file_get_contents("php://input");
        $dataJSON=json_decode($input,true);

        //creamos un array asociativo con lo datos del nuevo registro 
        $registro=[
          "inicio"          =>$dataJSON["inicio"],
          "fin"             =>$dataJSON["fin"],
          "idPersona"       =>$dataJSON["idPersona"],
          "idArea"          =>$dataJSON["idArea"],
          "idRol"           =>$dataJSON["idRol"],

        ];
        //Obtenemos el número de registros
        $filasAfectadas=$colaborador->add($registro);

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
          $idcolaborador=end($arrayURL);

          $filasafectadas=$colaborador-> delete (['idColaborador'=>$idcolaborador]);
          echo json_encode(['filas'=>$filasafectadas]);
          break;
        
    }
    
}
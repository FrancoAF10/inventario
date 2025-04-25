<?php

if(isset($_SERVER['REQUEST_METHOD'])){
  
  require_once "../models/Asignaciones.php";
  $asignaciones = new Asignaciones();

  switch($_SERVER["REQUEST_METHOD"]){
    case "GET":
      //sleep(3);
      header("Content-Type: application/json; charset=utf-8");

      //DEBEMOS IDENTIFICAR SI EL USUARIO REQUIERE LISTAR/BUSCAR
      if($_GET["task"]=='getAll'){
        echo json_encode($asignaciones->getAll() );
      }else if($_GET["task"]=='getBienes'){
        echo json_encode($asignaciones->getBienes());
      }else if($_GET["task"]=='getColaboradores'){
        echo json_encode($asignaciones->getColaboradores());
      }else if($_GET["task"]=='getById'){
        echo json_encode($asignaciones->getById($_GET['idAsignacion']));
      }
      break;

      case "POST":
        //Obtener los datos enviados
        $input = file_get_contents("php://input");
        $dataJSON=json_decode($input,true);

        //creamos un array asociativo con lo datos del nuevo registro 
        $registro=[
          "idBien"              =>$dataJSON["idBien"],
          "idColaborador"       =>$dataJSON["idColaborador"],
          "inicio"              =>$dataJSON["inicio"],
          "fin"                 =>$dataJSON["fin"],
        ];
        //Obtenemos el número de registros
        $filasAfectadas=$asignaciones->add($registro);

        //Notificamos al usuario el número de filas en formato JSON
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
          $idasignacion=end($arrayURL);

          $filasafectadas=$asignaciones-> delete (['idAsignacion'=>$idasignacion]);
          echo json_encode(['filas'=>$filasafectadas]);
          break;
        
    }
    
}
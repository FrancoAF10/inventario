<?php

if(isset($_SERVER['REQUEST_METHOD'])){
  
  require_once "../models/Personas.php";
  $persona = new Persona();

  switch($_SERVER["REQUEST_METHOD"]){
    case "GET":
      //sleep(3);
      header("Content-Type: application/json; charset=utf-8");

      //DEBEMOS IDENTIFICAR SI EL USUARIO REQUIERE LISTAR/BUSCAR
      if($_GET["task"]=='getAll'){
        echo json_encode($persona->getAll() );
      }
      break;
      case "POST":
        //Obtener los datos enviados desde el cliente
        $input = file_get_contents("php://input");
        $dataJSON=json_decode($input,true);

        //creamos un array asociativo con lo datos del nuevo registro 
        $registro=[
          "apellidos"           =>$dataJSON["apellidos"],
          "nombres"             =>$dataJSON["nombres"],
          "tipoDoc"             =>$dataJSON["tipoDoc"],
          "nroDocumento"        =>$dataJSON["nroDocumento"],
          "telefono"            =>$dataJSON["telefono"],
          "email"               =>$dataJSON["email"],
          "direccion"           =>$dataJSON["direccion"],

        ];
        //Obtenemos el número de registros
        $filasAfectadas=$persona->add($registro);

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
        $idpersona=end($arrayURL);

        $filasafectadas=$persona-> delete (['idPersona'=>$idpersona]);
        echo json_encode(['filas'=>$filasafectadas]);
        break;
    }
    
}
<?php

if (isset($_SERVER['REQUEST_METHOD'])) {

  require_once "../models/detalles.php";
  $detalle = new Detalle();

  switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
      header("Content-Type: application/json; charset=utf-8");

      //DEBEMOS IDENTIFICAR SI EL USUARIO REQUIERE LISTAR/BUSCAR
      if ($_GET["task"] == 'getAll') {
        echo json_encode($detalle->getAll());
      }else if ($_GET["task"] == 'getCaracteristica') {
        echo json_encode($detalle->getCaracteristica());
      }else if ($_GET["task"] == 'getConfiguracion') {
        echo json_encode($detalle->getConfiguracion());
      } else if ($_GET["task"] == 'getById') {
        echo json_encode($detalle->getById($_GET['idDetalle']));
      }
      break;

    case "POST":
      //Obtener los datos enviados
      $input = file_get_contents("php://input");
      $dataJSON = json_decode($input, true);

      //creamos un array asociativo con lo datos del nuevo registro 
      $registro = [
        "caracteristica" => $dataJSON["caracteristica"],
        "idCaracteristica" => $dataJSON["idCaracteristica"],
        "idConfiguracion"=>$dataJSON["idConfiguracion"],
      ];
      //Obtenemos el número de registros
      $filasAfectadas = $detalle->add($registro);

      //Notificamos al usuario el número de filas en formato JSON
      header("Content-Type: application/json; charset=utf-8");
      echo json_encode(["filas" => $filasAfectadas]);
      break;

    case "PUT":
      $input = file_get_contents("php://input");
      $dataJSON = json_decode($input, true);

      $registro = [
        "caracteristica" => $dataJSON["caracteristica"],
        "idCaracteristica" => $dataJSON["idCaracteristica"],
        "idConfiguracion"=> $dataJSON["idConfiguracion"],
        "idDetalle" => $dataJSON["idDetalle"],
      ];

      $filasAfectadas = $detalle->update($registro);
      header("Content-Type: application/json; charset=utf-8");
      echo json_encode(["filas" => $filasAfectadas]);
      break;

    case "DELETE":
      header("Content-Type: application/json; charset=utf-8");
      //El usuario enviará el id en la url => miurl.com/ideliminar
      //PASO 1: Obtener la URL desde el cliente
      $url = $_SERVER['REQUEST_URI'];
      //Paso 2: convertir la URL en un array
      $arrayURL = explode('/', $url);
      //paso 3: obtener el id
      $iddetalle = end($arrayURL);

      $filasafectadas = $detalle->delete(['idDetalle' => $iddetalle]);
      echo json_encode(['filas' => $filasafectadas]);
      break;

  }

}
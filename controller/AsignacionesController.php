<?php

if (isset($_SERVER['REQUEST_METHOD'])) {

  require_once "../models/Asignaciones.php";
  $asignaciones = new Asignaciones();

  switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
      header("Content-Type: application/json; charset=utf-8");

      //DEBEMOS IDENTIFICAR SI EL USUARIO REQUIERE LISTAR/BUSCAR
      if ($_GET["task"] == 'getAll') {
        echo json_encode($asignaciones->getAll());
      } else if ($_GET["task"] == 'getCategorias') {
        echo json_encode($asignaciones->getCategorias());
      } else if ($_GET["task"] == 'getSubCategorias') {
        echo json_encode($asignaciones->getSubCategorias($_GET['idCategoria']));
      } else if ($_GET["task"] == 'getMarcas') {
        echo json_encode($asignaciones->getMarcas($_GET['idSubCategoria']));
      } else if ($_GET["task"] == 'getBienesPorMarca') {
        echo json_encode($asignaciones->getBienesPorMarca($_GET['idMarca']));
      } else if ($_GET["task"] == 'getColaboradores') {
        echo json_encode($asignaciones->getColaboradores());
      } else if ($_GET["task"] == 'getById') {
        echo json_encode($asignaciones->getById($_GET['idAsignacion']));
      }
      break;

    case "POST":
      $input = file_get_contents("php://input");
      $dataJSON = json_decode($input, true);

      $registro = [
        "idBien" => $dataJSON["idBien"],
        "idColaborador" => $dataJSON["idColaborador"],
        "inicio" => $dataJSON["inicio"],
        "fin" => $dataJSON["fin"],
      ];
      $filasAfectadas = $asignaciones->add($registro);

      //Notificamos al usuario el número de filas en formato JSON
      header("Content-Type: application/json; charset=utf-8");
      echo json_encode(["filas" => $filasAfectadas]);
      break;
          
      case "PUT":
      $input = file_get_contents("php://input");
      $dataJSON = json_decode($input, true);

      $registro = [
        "inicio" => $dataJSON["inicio"],
        "fin" => $dataJSON["fin"],
        "idBien" => $dataJSON["idBien"],
        "idColaborador" => $dataJSON["idColaborador"],
        "idAsignacion" => $dataJSON["idAsignacion"],
      ];

      $filasAfectadas = $asignaciones->update($registro);
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
      $idasignacion = end($arrayURL);

      $filasafectadas = $asignaciones->delete(['idAsignacion' => $idasignacion]);
      echo json_encode(['filas' => $filasafectadas]);
      break;

  }

}
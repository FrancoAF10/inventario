<?php
require_once "../config/Database.php";
class Caracteristica{
  private $conexion;
  public function __construct() {
    $this->conexion = Database::getConexion();
  }
  /**
   * Devuelve un conjunto de Caracteristicas contenidos en un arreglo
   * @return array
   */
  public function getAll(): array{
    $sql="SELECT * FROM CARACTERISTICAS";
    $stmt = $this->conexion->prepare($sql); //preparación
    $stmt->execute(); //ejecución
    return $stmt->fetchAll(PDO::FETCH_ASSOC); //retorno
  }

  /**
   * Registra una nueva Caracteristica en la base de datos
   * @param mixed $params
   * @return int
   */
  public function add($params = []): int{
   $sql="INSERT INTO  () VALUES(?)";
   $stmt = $this->conexion->prepare($sql);
   $stmt->execute(
    array(
      $params[""]
    )
    );
    return $stmt->rowCount();
  }
  public function update($params = []): int{
    return 0;
  }
  public function delete($params = []): int{
    $sql= "DELETE FROM CARACTERISTICAS WHERE idCaracteristica=? ";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array(
        $params["idCaracteristica"],
      )

      );
    return $stmt->rowCount();
  }
  public function getById ($idcaracteristica): array{
    //obtenemos los datos mediante el id
    $sql= "SELECT * FROM CARACTERISTICAS WHERE id=?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array($idcaracteristica)
      );  
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  
}


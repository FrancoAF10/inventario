<?php
require_once "../config/Database.php";
class Area{
  private $conexion;
  public function __construct() {
    $this->conexion = Database::getConexion();
  }
  /**
   * Devuelve un conjunto de Areas contenidos en un arreglo
   * @return array
   */
  public function getAll(): array{
    $sql="SELECT * FROM AREAS";
    $stmt = $this->conexion->prepare($sql); //preparación
    $stmt->execute(); //ejecución
    return $stmt->fetchAll(PDO::FETCH_ASSOC); //retorno
  }

  /**
   * Registra una nueva Area en la base de datos
   * @param mixed $params
   * @return int
   */
  public function add($params = []): int{
   $sql="INSERT INTO AREAS (area) VALUES(?)";
   $stmt = $this->conexion->prepare($sql);
   $stmt->execute(
    array(
      $params["area"]
    )
    );
    return $stmt->rowCount();
  }
  public function update($params = []): int{
    $sql = "UPDATE Areas SET area = ? WHERE idArea = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([
        $params["area"],
        $params["idArea"]
    ]);
    return $stmt->rowCount();  
  }
  public function delete($params = []): int{
    $sql= "DELETE FROM Areas WHERE idArea=? ";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array(
        $params["idArea"],
      )

      );
    return $stmt->rowCount();
  }
  public function getById ($idarea): array{
    //obtenemos los datos mediante el id
    $sql= "SELECT * FROM Areas WHERE idArea=?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array($idarea)
      );  
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  
}


<?php
require_once "../config/Database.php";
class Detalle{
  private $conexion;
  public function __construct() {
    $this->conexion = Database::getConexion();
  }
  /**
   * Devuelve un conjunto de Detalles contenidos en un arreglo
   * @return array
   */
  public function getAll(): array{
    $sql="SELECT * FROM vista_detalles";
    $stmt = $this->conexion->prepare($sql); //preparación
    $stmt->execute(); //ejecución
    return $stmt->fetchAll(PDO::FETCH_ASSOC); //retorno
  }
    public function getCaracteristica(): array{
    $sql="SELECT * FROM CARACTERISTICAS";
    $stmt = $this->conexion->prepare($sql); //preparación
    $stmt->execute(); //ejecución
    return $stmt->fetchAll(PDO::FETCH_ASSOC); //retorno
  }
    public function getConfiguracion(): array{
    $sql="SELECT * FROM CONFIGURACIONES";
    $stmt = $this->conexion->prepare($sql); //preparación
    $stmt->execute(); //ejecución
    return $stmt->fetchAll(PDO::FETCH_ASSOC); //retorno
  }
  /**
   * Registra un nuevo detalle en la base de datos
   * @param mixed $params
   * @return int
   */
  public function add($params = []): int{
   $sql="INSERT INTO DETALLES (caracteristica,idCaracteristica,idConfiguracion) VALUES(?,?,?)";
   $stmt = $this->conexion->prepare($sql);
   $stmt->execute(
    array(
      $params["caracteristica"],
      $params["idCaracteristica"],
      $params["idConfiguracion"]
    )
    );
    return $stmt->rowCount();
  }
  public function update($params = []): int{
    $sql = "UPDATE DETALLES SET caracteristica = ?, idCaracteristica=?, idConfiguracion=? WHERE idDetalle= ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([
        $params["caracteristica"],
        $params["idCaracteristica"],
        $params["idConfiguracion"],
        $params["idDetalle"],
    ]);
    return $stmt->rowCount();  
  }
  public function delete($params = []): int{
    $sql= "DELETE FROM DETALLES WHERE idDetalle=? ";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array(
        $params["idDetalle"],
      )

      );
    return $stmt->rowCount();
  }
  public function getById ($iddetalle): array{
    //obtenemos los datos mediante el id
    $sql= "SELECT * FROM DETALLES WHERE idDetalle=?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array($iddetalle)
      );  
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  
}


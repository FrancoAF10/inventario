<?php
require_once "../config/Database.php";
class Roles{
  private $conexion;
  public function __construct() {
    $this->conexion = Database::getConexion();
  }
  /**
   * Devuelve un conjunto de roles contenidos en un arreglo
   * @return array
   */
  public function getAll(): array{
    $sql="SELECT * FROM ROLES";
    $stmt = $this->conexion->prepare($sql); //preparación
    $stmt->execute(); //ejecución
    return $stmt->fetchAll(PDO::FETCH_ASSOC); //retorno
  }

  /**
   * Registra un nuevo roles en la base de datos
   * @param mixed $params
   * @return int
   */
  public function add($params = []): int{
   $sql="INSERT INTO ROLES (rol) VALUES(?)";
   $stmt = $this->conexion->prepare($sql);
   $stmt->execute(
    array(
      $params["rol"]
    )
    );
    return $stmt->rowCount();
  }
  public function update($params = []): int{
    $sql = "UPDATE ROLES SET rol = ? WHERE idRol = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([
        $params["rol"],
        $params["idRol"]
    ]); 
    return $stmt->rowCount();  
  }
  public function delete($params = []): int{
    $sql= "DELETE FROM ROLES WHERE idRol=? ";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array(
        $params["idRol"],
      )

      );
    return $stmt->rowCount();
  }
  public function getById ($idrol): array{
    $sql= "SELECT * FROM ROLES WHERE idRol=?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array($idrol)
      );  
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  
}


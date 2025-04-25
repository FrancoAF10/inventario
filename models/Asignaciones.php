<?php
require_once "../config/Database.php";
class Asignaciones{
  private $conexion;
  public function __construct() {
    $this->conexion = Database::getConexion();
  }
  /**
   * Devuelve un conjunto de Asignaciones contenidos en un arreglo
   * @return array
   */
  public function getAll(): array{
    $sql="SELECT * FROM vista_asignaciones";
    $stmt = $this->conexion->prepare($sql); //preparación
    $stmt->execute(); //ejecución
    return $stmt->fetchAll(PDO::FETCH_ASSOC); //retorno
  }
  public function getBienes(): array{
    $sql="SELECT * FROM vista_bienes_asignaciones";
    $stmt = $this->conexion->prepare($sql); //preparación
    $stmt->execute(); //ejecución
    return $stmt->fetchAll(PDO::FETCH_ASSOC); //retorno
  }
  
  public function getColaboradores(): array{
    $sql="SELECT * FROM vista_usuarios_colaboradores";
    $stmt = $this->conexion->prepare($sql); //preparación
    $stmt->execute(); //ejecución
    return $stmt->fetchAll(PDO::FETCH_ASSOC); //retorno
  }
  /**
   * Registra una nueva Asignaciones en la base de datos
   * @param mixed $params
   * @return int
   */
  public function add($params = []): int{
   $sql="CALL spu_asignacion_registrar (?,?,?,?)";
   $stmt = $this->conexion->prepare($sql);
   $stmt->execute(
    array(
      $params["idBien"],
      $params["idColaborador"],
      $params["inicio"],
      $params["fin"],
    )
    );
    return $stmt->rowCount();
  }
  public function update($params = []): int{
    return 0;
  }
  public function delete($params = []): int{
    $sql= "DELETE FROM ASIGNACIONES WHERE idAsignacion=? ";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array(
        $params["idAsignacion"],
      )

      );
    return $stmt->rowCount();
  }
  public function getById ($idasignacion): array{
    //obtenemos los datos mediante el id
    $sql= "SELECT * FROM ASIGNACIONES WHERE id=?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array($idasignacion)
      );  
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  
}


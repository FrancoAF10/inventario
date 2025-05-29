<?php
require_once "../config/Database.php";
class Colaborador{
  private $conexion;
  public function __construct() {
    $this->conexion = Database::getConexion();
  }
  /**
   * Devuelve un conjunto de colaboradores contenidos en un arreglo
   * @return array
   */
  public function getAll(): array{
    $sql="SELECT * FROM vista_colaboradores";
    $stmt = $this->conexion->prepare($sql); //preparación
    $stmt->execute(); //ejecución
    return $stmt->fetchAll(PDO::FETCH_ASSOC); //retorno
  }
  public function getAreas(): array{
    $sql="SELECT * FROM AREAS";
    $stmt = $this->conexion->prepare($sql); 
    $stmt->execute(); 
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
  }
  public function getPersonas(): array{
    $sql="SELECT * FROM PERSONA";
    $stmt = $this->conexion->prepare($sql); 
    $stmt->execute(); 
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
  }
  public function getRoles(): array{
    $sql="SELECT * FROM ROLES";
    $stmt = $this->conexion->prepare($sql); 
    $stmt->execute(); 
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
  }

  /**
   * Registra un nuevo colaborador en la base de datos
   * @param mixed $params
   * @return int
   */
  public function add($params = []): int{
   $sql="CALL spu_colaborador_registrar (?,?,?,?,?)";
   $stmt = $this->conexion->prepare($sql);
   $stmt->execute(
    array(
      $params["inicio"],
      $params["fin"],
      $params["idPersona"],
      $params["idArea"],
      $params["idRol"]
    )
    );
    return $stmt->rowCount();
  }
  public function update($params = []): int{
    $sql = "UPDATE COLABORADORES SET inicio = ?,fin=?,idPersona=?,idArea=?,idRol=? WHERE idColaborador = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([
      $params["inicio"],
      $params["fin"],
      $params["idPersona"],
      $params["idArea"],
      $params["idRol"],
      $params["idColaborador"],
    ]);
    return $stmt->rowCount();  
  }
  public function delete($params = []): int{
    $sql= "DELETE FROM COLABORADORES WHERE idColaborador=? ";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array(
        $params["idColaborador"],
      )

      );
    return $stmt->rowCount();
  }
  public function getById ($idcolaborador): array{
    $sql= "SELECT * FROM COLABORADORES WHERE idColaborador=?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array($idcolaborador)
      );  
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  
}


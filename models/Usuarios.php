<?php
require_once "../config/Database.php";
class Usuarios{
  private $conexion;
  public function __construct() {
    $this->conexion = Database::getConexion();
  }
  /**
   * Devuelve un conjunto de Usuarios contenidos en un arreglo
   * @return array
   */
  public function getAll(): array{
    $sql="SELECT * FROM vista_usuarios";
    $stmt = $this->conexion->prepare($sql); //preparación
    $stmt->execute(); //ejecución
    return $stmt->fetchAll(PDO::FETCH_ASSOC); //retorno
  }
  public function getColaboradores(): array{
    $sql="SELECT * FROM vista_usuarios_colaboradores";
    $stmt = $this->conexion->prepare($sql); 
    $stmt->execute(); 
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Registra un nuevo usuario en la base de datos
   * @param mixed $params
   * @return int
   */
  public function add($params = []): int{
   $sql="CALL spu_usuario_registrar (?,?,?,?)";
   $stmt = $this->conexion->prepare($sql);
   $stmt->execute(
    array(
      $params["nomUser"],
      $params["passUser"],
      $params["estado"],
      $params["idColaborador"]

    )
    );
    return $stmt->rowCount();
  }
  public function update($params = []): int{
    $sql="UPDATE USUARIOS SET nomUser=?, passUser=?, estado=?,idColaborador=? WHERE idUsuario=?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
     array(
       $params["nomUser"],
       $params["passUser"],
       $params["estado"],
       $params["idColaborador"],
       $params["idUsuario"],
 
     )
     );
     return $stmt->rowCount();  }
  public function delete($params = []): int{
    $sql= "DELETE FROM USUARIOS WHERE idUsuario=? ";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array(
        $params["idUsuario"],
      )

      );
    return $stmt->rowCount();
  }
  public function getById ($idusuario): array{
    //obtenemos los datos mediante el id
    $sql= "SELECT * FROM USUARIOS WHERE idUsuario=?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array($idusuario)
      );  
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  
}


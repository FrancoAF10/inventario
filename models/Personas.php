<?php
require_once "../config/Database.php";
class Persona{
  private $conexion;
  public function __construct() {
    $this->conexion = Database::getConexion();
  }
  /**
   * Devuelve un conjunto de personas contenidos en un arreglo
   * @return array
   */
  public function getAll(): array{
    $sql="SELECT * FROM PERSONA ";
    $stmt = $this->conexion->prepare($sql); //preparación
    $stmt->execute(); //ejecución
    return $stmt->fetchAll(PDO::FETCH_ASSOC); //retorno
  }

  /**
   * Registra una nueva persona en la base de datos
   * @param mixed $params
   * @return int
   */
  public function add($params = []): int{
    $sql="INSERT INTO Persona (apellidos, nombres,tipoDoc,nroDocumento,telefono,email,direccion) VALUES(?,?,?,?,?,?,?)";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
     array(
       $params["apellidos"],
       $params["nombres"],
       $params["tipoDoc"],
       $params["nroDocumento"],
       $params["telefono"],
       $params["email"],
       $params["direccion"]
     )
     );
     return $stmt->rowCount();
   }
   public function update($params = []): int{
    $sql = "UPDATE Persona SET apellidos = ?, nombres=?, tipoDoc=?, nroDocumento=?, telefono=?, email=?, direccion=?  WHERE idPersona = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array(
        $params["apellidos"],
        $params["nombres"],
        $params["tipoDoc"],
        $params["nroDocumento"],
        $params["telefono"],
        $params["email"],
        $params["direccion"],
        $params["idPersona"],
      ));
    return $stmt->rowCount();  
  }
   public function delete($params = []): int{
    $sql= "DELETE FROM Persona WHERE idPersona=? ";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array(
        $params["idPersona"],
      )

      );
    return $stmt->rowCount();
  }
  public function getById ($idpersona): array{
    //obtenemos los datos mediante el id
    $sql= "SELECT * FROM Persona WHERE idPersona=?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array($idpersona)
      );  
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  
  
}


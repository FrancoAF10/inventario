<?php
require_once "../config/Database.php";
class Configuracion{
  private $conexion;
  public function __construct() {
    $this->conexion = Database::getConexion();
  }
  /**
   * Devuelve un conjunto de configuraciones contenidos en un arreglo
   * @return array
   */
  public function getAll(): array{
    $sql="SELECT * FROM CONFIGURACIONES";
    $stmt = $this->conexion->prepare($sql); //preparación
    $stmt->execute(); //ejecución
    return $stmt->fetchAll(PDO::FETCH_ASSOC); //retorno
  }
  public function getCategorias(): array {
    $sql = "SELECT * FROM CATEGORIAS"; // Consulta para obtener las categorías
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Devolvemos todas las categorías
}

  /**
   * Registra una nueva configuracion en la base de datos
   * @param mixed $params
   * @return int
   */
  public function add($params = []): int{
   $sql="INSERT INTO CONFIGURACIONES (configuracion,idCategoria) VALUES(?,?)";
   $stmt = $this->conexion->prepare($sql);
   $stmt->execute(
    array(
      $params["configuracion"],
      $params["idCategoria"]

    )
    );
    return $stmt->rowCount();
  }
  public function update($params = []): int{
    return 0;
  }
  public function delete($params = []): int{
    $sql= "DELETE FROM CONFIGURACIONES WHERE idConfiguracion=? ";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array(
        $params["idConfiguracion"],
      )

      );
    return $stmt->rowCount();
  }
  public function getById ($idconfiguracion): array{
    //obtenemos los datos mediante el id
    $sql= "SELECT * FROM CONFIGURACIONES WHERE id=?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array($idconfiguracion)
      );  
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  
}


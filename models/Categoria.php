<?php
require_once "../config/Database.php";
class Categoria{
  private $conexion;
  public function __construct() {
    $this->conexion = Database::getConexion();
  }
  /**
   * Devuelve un conjunto de Categorias contenidos en un arreglo
   * @return array
   */
  public function getAll(): array{
    $sql="SELECT * FROM CATEGORIAS";
    $stmt = $this->conexion->prepare($sql); //preparación
    $stmt->execute(); //ejecución
    return $stmt->fetchAll(PDO::FETCH_ASSOC); //retorno
  }

  /**
   * Registra una nueva categoria en la base de datos
   * @param mixed $params
   * @return int
   */
  public function add($params = []): int{
   $sql="INSERT INTO CATEGORIAS (categoria) VALUES(?)";
   $stmt = $this->conexion->prepare($sql);
   $stmt->execute(
    array(
      $params["categoria"]
    )
    );
    return $stmt->rowCount();
  }
  public function update($params = []): int{
    return 0;
  }
  public function delete($params = []): int{
    //tipos de eliminacion:fisica(delete) - lógica(update)
    $sql= "DELETE FROM CATEGORIAS WHERE idCategoria=? ";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array(
        $params["idCategoria"],
      )

      );
    return $stmt->rowCount();
  }
  public function getById ($idcategoria): array{
    //obtenemos los datos mediante el id
    $sql= "SELECT * FROM CATEGORIAS WHERE id=?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array($idcategoria)
      );  
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  
}


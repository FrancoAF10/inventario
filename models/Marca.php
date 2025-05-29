<?php
require_once "../config/Database.php";
class Marca{
  private $conexion;
  public function __construct() {
    $this->conexion = Database::getConexion();
  }
  /**
   * Devuelve un conjunto de Marcas contenidos en un arreglo
   * @return array
   */
  public function getAll(): array{
    $sql="SELECT * FROM vista_marcas_categorias_subcategorias";
    $stmt = $this->conexion->prepare($sql); //preparación
    $stmt->execute(); //ejecución
    return $stmt->fetchAll(PDO::FETCH_ASSOC); //retorno
  }

  public function getCategorias(): array {
    $sql = "SELECT * FROM CATEGORIAS";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
  }
  public function getsubCategorias($idCategoria): array {
    // Consulta para obtener las subcategorías dependiendo de que categoria se seleccione
    $sql = "SELECT * FROM vista_subcategorias_con_categorias WHERE idCategoria = ?"; 
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(

      [$idCategoria]
    );
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Devolvemos todas las subcategorías
  }
  
  /**
   * Registra una nueva Marca en la base de datos
   * @param mixed $params
   * @return int
   */
  public function add($params = []): int{
    $sql="INSERT INTO MARCAS (marca, idSubCategoria) VALUES(?,?)";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
     array(
       $params["marca"],
       $params["idSubCategoria"]

     )
     );
     return $stmt->rowCount();
   }
   public function update($params = []): int{
    $sql = "UPDATE MARCAS SET marca = ?,idSubCategoria=? WHERE idMarca = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([
        $params["marca"],
        $params["idSubCategoria"],
        $params["idMarca"]
    ]);
    return $stmt->rowCount();  
  }
  public function delete($params = []): int{
    $sql= "DELETE FROM MARCAS WHERE idMarca=? ";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array(
        $params["idMarca"],
      )
      );
    return $stmt->rowCount();
  }
  public function getById ($idMarca): array{
    $sql= "SELECT m.*, s.idCategoria 
           FROM MARCAS m 
           INNER JOIN SUBCATEGORIAS s ON m.idSubCategoria = s.idSubCategoria
           WHERE m.idMarca = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array($idMarca)
      );  
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  
}


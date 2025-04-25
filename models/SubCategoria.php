<?php
require_once "../config/Database.php";
class SubCategoria{
  private $conexion;
  public function __construct() {
    $this->conexion = Database::getConexion();
  }

  public function getCategorias(): array {
    $sql = "SELECT * FROM CATEGORIAS"; // Consulta para obtener las categorías
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Devolvemos todas las categorías
}
  public function getAll(): array{
    $sql="SELECT * FROM vista_categorias_subcategorias";
    $stmt = $this->conexion->prepare($sql); //preparación
    $stmt->execute(); //ejecución
    return $stmt->fetchAll(PDO::FETCH_ASSOC); //retorno
  }
  public function add($params = []): int{
    $sql="CALL spu_SubCategorias_registrar (?,?)";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
     array(
       $params["subCategoria"],
       $params["idCategoria"]
     )
     );
     return $stmt->rowCount();
   }
   public function delete($params = []): int{
    $sql= "DELETE FROM SUBCATEGORIAS WHERE idSubCategoria=? ";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array(
        $params["idSubCategoria"],
      )

      );
    return $stmt->rowCount();
  }
}
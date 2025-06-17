<?php
require_once "../config/Database.php";
class Caracteristica{
  private $conexion;
  public function __construct() {
    $this->conexion = Database::getConexion();
  }
  /**
   * Devuelve un conjunto de Caracteristicas contenidos en un arreglo
   * @return array
   */
  public function getAll(): array{
    $sql="SELECT * FROM vista_bienes_segmento";
    $stmt = $this->conexion->prepare($sql); //preparación
    $stmt->execute(); //ejecución
    return $stmt->fetchAll(PDO::FETCH_ASSOC); //retorno
  }

    public function getCategorias(): array
  {
    $sql = "SELECT * FROM CATEGORIAS";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function getSubCategorias($idCategoria): array
  {
    // Consulta para obtener las subcategorías dependiendo de que categoria se seleccione
    $sql = "SELECT * FROM vista_subcategorias_con_categorias WHERE idCategoria = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(

      [$idCategoria]
    );
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Devolvemos todas las subcategorías
  }
  public function getMarcas($idSubCategoria): array
  {
    $sql = "SELECT * FROM vista_marcas_bien WHERE idSubCategoria = ?";
    $stmt = $this->conexion->prepare($sql); //preparación
    $stmt->execute(
      [$idSubCategoria]
    ); //ejecución
    return $stmt->fetchAll(PDO::FETCH_ASSOC); //retorno
  }
  public function getBienesPorMarca($idMarca): array
  {
    $sql = "SELECT * FROM vista_bienes_asignaciones WHERE idMarca = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([$idMarca]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Registra una nueva Caracteristica en la base de datos
   * @param mixed $params
   * @return int
   */
  public function add($params = []): int{
   $sql="INSERT INTO CARACTERISTICAS (segmento,idBien) VALUES(?,?)";
   $stmt = $this->conexion->prepare($sql);
   $stmt->execute(
    array(
      $params["segmento"],
      $params["idBien"]

    )
    );
    return $stmt->rowCount();
  }
  public function update($params = []): int{
        $sql = "UPDATE CARACTERISTICAS SET segmento = ?, idBien=? WHERE idCaracteristica = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([
        $params["segmento"],
        $params["idBien"],
        $params["idCaracteristica"]
    ]);
    return $stmt->rowCount();
  }
  public function delete($params = []): int{
    $sql= "DELETE FROM CARACTERISTICAS WHERE idCaracteristica=? ";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array(
        $params["idCaracteristica"],
      )

      );
    return $stmt->rowCount();
  }
  public function getById ($idcaracteristica): array{
    //obtenemos los datos mediante el id
    $sql= "SELECT 
    C.idCaracteristica,
    C.segmento,
    B.idBien,
    M.idMarca,
    S.idSubCategoria,
    CA.idCategoria
FROM CARACTERISTICAS C
INNER JOIN BIENES B ON C.idBien = B.idBien
INNER JOIN MARCAS M ON B.idMarca = M.idMarca
INNER JOIN SUBCATEGORIAS S ON M.idSubCategoria = S.idSubCategoria
INNER JOIN CATEGORIAS CA ON S.idCategoria = CA.idCategoria
WHERE C.idCaracteristica = ?
";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array($idcaracteristica)
      );  
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  
}


<?php
require_once "../config/Database.php";
class Asignaciones
{
  private $conexion;
  public function __construct()
  {
    $this->conexion = Database::getConexion();
  }
  /**
   * Devuelve un conjunto de Asignaciones contenidos en un arreglo
   * @return array
   */
  public function getAll(): array
  {
    $sql = "SELECT * FROM vista_asignaciones";
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

  public function getColaboradores(): array
  {
    $sql = "SELECT * FROM vista_usuarios_colaboradores";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  /**
   * Registra una nueva Asignacion en la base de datos
   * @param mixed $params
   * @return int
   */
  public function add($params = []): int
  {
    $sql = "CALL spu_asignacion_registrar (?,?,?,?)";
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
    $sql = "UPDATE ASIGNACIONES SET inicio = ?, fin=?, idBien=?,idColaborador=? WHERE idAsignacion = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([
        $params["inicio"],
        $params["fin"],
        $params["idBien"],
        $params["idColaborador"],
        $params["idAsignacion"]
    ]);
    return $stmt->rowCount();  
  }
  public function delete($params = []): int
  {
    $sql = "DELETE FROM ASIGNACIONES WHERE idAsignacion=? ";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute(
      array(
        $params["idAsignacion"],
      )

    );
    return $stmt->rowCount();
  }
public function getById($idAsignacion): array
{
    $sql = "SELECT * FROM vistaAsignaciones_actualizar WHERE idAsignacion = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([$idAsignacion]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
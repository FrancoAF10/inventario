<?php
require_once "../config/Database.php";
class Bien
{
    private $conexion;
    public function __construct()
    {
        $this->conexion = Database::getConexion();
    }
    /**
     * Devuelve un conjunto de Bienes contenidos en un arreglo
     * @return array
     */
    public function getAll(): array{
        $sql="SELECT * FROM vista_bienes_registrados";
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
      public function getSubCategorias($idCategoria): array {
        // Consulta para obtener las subcategorías dependiendo de que categoria se seleccione
        $sql = "SELECT * FROM vista_subcategorias_con_categorias WHERE idCategoria = ?"; 
        $stmt = $this->conexion->prepare(query: $sql);
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
    public function getUsuarios(): array
    {
        $sql = "SELECT * FROM USUARIOS";
        $stmt = $this->conexion->prepare($sql); 
        $stmt->execute(); 
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Registra un nuevo Bien en la base de datos
     * @param mixed $params
     * @return int
     */
    public function add($params = []): int
    {
        $sql = "CALL spu_bienes_registrar (?,?,?,?,?,?,?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(
            array(
                $params["condicion"],
                $params["modelo"],
                $params["numSerie"],
                $params["descripcion"],
                $params["fotografia"],
                $params["idMarca"],
                $params["idUsuario"]
            )
        );
        return $stmt->rowCount();
    }
    public function update($params = []): int
    {
        return 0;
    }
    public function delete($params = []): int
    {
        $sql = "DELETE FROM BIENES WHERE idBien=? ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(
            array(
                $params["idBien"],
            )
        );
        return $stmt->rowCount();
    }
    public function getById($idbien): array
    {
        //obtenemos los datos mediante el id
        $sql = "SELECT * FROM BIENES WHERE id=?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(
            array($idbien)
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}


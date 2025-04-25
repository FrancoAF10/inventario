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
    
    public function getMarcas(): array
    {
        $sql = "SELECT * FROM MARCAS";
        $stmt = $this->conexion->prepare($sql); //preparación
        $stmt->execute(); //ejecución
        return $stmt->fetchAll(PDO::FETCH_ASSOC); //retorno
    }
    public function getUsuarios(): array
    {
        $sql = "SELECT * FROM USUARIOS";
        $stmt = $this->conexion->prepare($sql); //preparación
        $stmt->execute(); //ejecución
        return $stmt->fetchAll(PDO::FETCH_ASSOC); //retorno
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


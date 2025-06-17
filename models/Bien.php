<?php
require_once "../config/Database.php";

class Bien
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = Database::getConexion();
    }

public function getAll(): array
{
    $sql = "SELECT * FROM vista_bienes_registrados";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Convertir BLOB a base64
    foreach ($results as &$row) {
        if (!empty($row['fotografia'])) {
            $row['fotografia'] = 'data:image/jpeg;base64,' . base64_encode($row['fotografia']);
        } else {
            $row['fotografia'] = null; // o alguna imagen por defecto
        }
    }
    return $results;
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
        $sql = "SELECT * FROM vista_subcategorias_con_categorias WHERE idCategoria = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$idCategoria]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMarcas($idSubCategoria): array
    {
        $sql = "SELECT * FROM vista_marcas_bien WHERE idSubCategoria = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$idSubCategoria]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsuarios(): array
    {
        $sql = "SELECT * FROM USUARIOS";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($params = []): int
    {
        $sql = "CALL spu_bienes_registrar (?,?,?,?,?,?,?)";
        $stmt = $this->conexion->prepare($sql);
        $imagenBinaria = base64_decode($params["fotografia"]);

        $stmt->execute([
            $params["condicion"],
            $params["modelo"],
            $params["numSerie"],
            $params["descripcion"],
            $imagenBinaria,
            $params["idMarca"],
            $params["idUsuario"]
        ]);
        return $stmt->rowCount();
    }

    public function update($params = []): int
    {
        $sql = "
                    UPDATE BIENES SET 
                    condicion = ?, 
                    modelo = ?, 
                    numSerie = ?, 
                    descripcion = ?, 
                    fotografia = ?, 
                    idMarca = ?, 
                    idUsuario = ?
                WHERE idBien = ?";
        $stmt = $this->conexion->prepare($sql);
        $imagenBinaria = base64_decode($params["fotografia"]);

        $stmt->execute([
            $params["condicion"],
            $params["modelo"],
            $params["numSerie"],
            $params["descripcion"],
            $imagenBinaria,
            $params["idMarca"],
            $params["idUsuario"],
            $params["idBien"]
        ]);
        return $stmt->rowCount();
    }

    public function delete($params = []): int
    {
        $sql = "DELETE FROM BIENES WHERE idBien = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$params["idBien"]]);
        return $stmt->rowCount();
    }

   public function getById($idbien): array
{
    $sql = "SELECT 
                b.idBien, b.modelo, b.numSerie, b.descripcion, b.condicion, b.fotografia,
                b.idMarca, b.idUsuario AS idUsuario,
                m.idSubCategoria, s.idCategoria
            FROM BIENES b
            INNER JOIN MARCAS m ON m.idMarca = b.idMarca
            INNER JOIN SUBCATEGORIAS s ON s.idSubCategoria = m.idSubCategoria
            WHERE b.idBien = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([$idbien]);
    $bien = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($bien && !empty($bien['fotografia'])) {
        $bien['fotografia'] = base64_encode($bien['fotografia']);
    }
    return $bien;
}

}
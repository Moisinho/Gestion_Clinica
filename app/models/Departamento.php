<?php
class Departamento
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function obtenerTodos()
    {
        $stmt = $this->db->prepare("SELECT * FROM departamento");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id_departamento)
    {
        $stmt = $this->db->prepare("SELECT * FROM departamento WHERE id_departamento = :id");
        $stmt->bindParam(':id', $id_departamento, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($nombre_departamento, $descripcion)
    {
        $stmt = $this->db->prepare("INSERT INTO departamento (nombre_departamento, descripcion) VALUES (:nombre, :descripcion)");
        $stmt->bindParam(':nombre', $nombre_departamento, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function actualizar($id_departamento, $nombre_departamento, $descripcion)
    {
        $stmt = $this->db->prepare("UPDATE departamento SET nombre_departamento = :nombre, descripcion = :descripcion WHERE id_departamento = :id");
        $stmt->bindParam(':id', $id_departamento, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre_departamento, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function eliminar($id_departamento)
    {
        $stmt = $this->db->prepare("DELETE FROM departamento WHERE id_departamento = :id");
        $stmt->bindParam(':id', $id_departamento, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

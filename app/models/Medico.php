<?php
class Medico
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function obtenerMedicos()
    {
        $query = "SELECT id_medico, nombre_medico FROM Medico";
        $stmt = $this->conn->prepare($query);

        if (!$stmt->execute()) {
            // Muestra el error de SQL si hay uno
            print_r($stmt->errorInfo());
            return [];
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agregarMedico($nombre_medico)
    {
        $query = "INSERT INTO Medico (nombre_medico) VALUES (:nombre_medico)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre_medico', $nombre_medico);

        return $stmt->execute();
    }

    public function actualizarMedico($id_medico, $nombre_medico)
    {
        $query = "UPDATE Medico SET nombre_medico = :nombre_medico WHERE id_medico = :id_medico";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre_medico', $nombre_medico);
        $stmt->bindParam(':id_medico', $id_medico);

        return $stmt->execute();
    }

    public function borrarMedico($id_medico)
    {
        $query = "DELETE FROM Medico WHERE id_medico = :id_medico";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_medico', $id_medico);

        return $stmt->execute();
    }

    public function obtenerMedicoPorId($id_medico)
    {
        $query = "SELECT * FROM Medico WHERE id_medico = :id_medico";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_medico', $id_medico);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

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
    
    // Quita o comenta la línea de depuración
    // echo "Ejecutando la consulta: $query\n"; 

    if (!$stmt->execute()) {
        print_r($stmt->errorInfo());
        return [];
    }

    $medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Devuelve el JSON
    echo json_encode($medicos);
    exit();
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

    public function obtenerMedicosPorServicio($id_servicio) {
        // Definir la consulta con JOIN para obtener médicos por id_servicio
        $query = "
            SELECT m.nombre_medico, m.id_medico
            FROM medico m
            JOIN servicio s ON m.id_departamento = s.id_departamento
            WHERE s.id_servicio = :id_servicio
        ";
    
        // Preparar la consulta
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_servicio', $id_servicio, PDO::PARAM_INT);
    
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }  
}

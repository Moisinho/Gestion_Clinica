<?php
class Medico {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerMedicos() {
        $query = "SELECT id_medico, nombre_medico FROM medicos"; // Asegúrate de que la tabla sea correcta
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<?php
class Medico {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerMedicos() {
        $query = "SELECT id_medico, nombre_medico FROM Medico";
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt->execute()) {
            // Muestra el error de SQL si hay uno
            print_r($stmt->errorInfo());
            return [];
        }
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>

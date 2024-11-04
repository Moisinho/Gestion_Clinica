<?php
class Farmacia {
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }
    
    public function obtenerRecetas() {
        try {
            $stmt = $this->conn->prepare("CALL ObtenerDatosRecetas()");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Error al obtener recetas: " . $e->getMessage();
            return [];
        }
    }
    
    public function actualizarEstadoReceta($idReceta, $nuevoEstado) {
        try {
            $stmt = $this->conn->prepare("UPDATE receta SET estado = :estado WHERE id_receta = :id");
            $stmt->bindParam(':estado', $nuevoEstado);
            $stmt->bindParam(':id', $idReceta);
            return $stmt->execute();
        } catch(PDOException $e) {
            echo "Error al actualizar estado: " . $e->getMessage();
            return false;
        }
    }
}
?>
<?php
class Medicamento {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function agregarMedicamento($nombre, $descripcion, $cantidad, $precio) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO medicamento (nombre, descripcion, cant_stock, precio) VALUES (?, ?, ?, ?)");
            return $stmt->execute([$nombre, $descripcion, $cantidad, $precio]);
        } catch (Exception $e) {
            error_log("Error al agregar medicamento: " . $e->getMessage());
            return false;
        }
    }
    
    
    

    // Método para actualizar un medicamento existente
    public function actualizarMedicamento($id, $nombre, $descripcion, $stock, $precio) {
        try {
            $query = $this->conn->prepare("UPDATE medicamento SET nombre = ?, descripcion = ?, cant_stock = ?, precio = ? WHERE id_medicamento = ?");
            return $query->execute([$nombre, $descripcion, $stock, $precio, $id]);
        } catch (Exception $e) {
            error_log("Error al actualizar medicamento: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerMedicamentoPorId($id) {
        $query = $this->conn->prepare("SELECT * FROM medicamento WHERE id_medicamento = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    

    // Método para obtener todos los medicamentos
    public function obtenerMedicamentos() {
        try {
            $query = $this->conn->prepare("SELECT * FROM medicamento");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al obtener medicamentos: " . $e->getMessage());
            return [];
        }
    }
}
?>

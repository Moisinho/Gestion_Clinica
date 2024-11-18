<?php
class Habitacion {

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM habitacion";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id_habitacion) {
        $stmt = $this->conn->prepare("SELECT * FROM habitacion WHERE id_habitacion = :id_habitacion");
        $stmt->bindParam(':id_habitacion', $id_habitacion, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO habitacion (capacidad_disponible, ubicacion, tipo) VALUES (:capacidad_disponible, :ubicacion, :tipo)");
        $stmt->bindParam(':capacidad_disponible', $data['capacidad_disponible'], PDO::PARAM_INT);
        $stmt->bindParam(':ubicacion', $data['ubicacion'], PDO::PARAM_STR);
        $stmt->bindParam(':tipo', $data['tipo'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function update($id_habitacion, $data) {
        $stmt = $this->conn->prepare("UPDATE habitacion SET capacidad_disponible = :capacidad_disponible, ubicacion = :ubicacion, tipo = :tipo WHERE id_habitacion = :id_habitacion");
        $stmt->bindParam(':capacidad_disponible', $data['capacidad_disponible'], PDO::PARAM_INT);
        $stmt->bindParam(':ubicacion', $data['ubicacion'], PDO::PARAM_STR);
        $stmt->bindParam(':tipo', $data['tipo'], PDO::PARAM_STR);
        $stmt->bindParam(':id_habitacion', $id_habitacion, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function patch($id_habitacion, $data) {
        $updateFields = [];
        $params = [];
        $i = 0;

        if (isset($data['capacidad_disponible'])) {
            $updateFields[] = "capacidad_disponible = :capacidad_disponible";
            $params[':capacidad_disponible'] = $data['capacidad_disponible'];
        }
        if (isset($data['ubicacion'])) {
            $updateFields[] = "ubicacion = :ubicacion";
            $params[':ubicacion'] = $data['ubicacion'];
        }
        if (isset($data['tipo'])) {
            $updateFields[] = "tipo = :tipo";
            $params[':tipo'] = $data['tipo'];
        }

        if (empty($updateFields)) {
            return false;
        }

        $sql = "UPDATE habitacion SET " . implode(", ", $updateFields) . " WHERE id_habitacion = :id_habitacion";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_habitacion', $id_habitacion, PDO::PARAM_INT);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        return $stmt->execute();
    }

    public function delete($id_habitacion) {
        $stmt = $this->conn->prepare("DELETE FROM habitacion WHERE id_habitacion = :id_habitacion");
        $stmt->bindParam(':id_habitacion', $id_habitacion, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Destructor: cerrar la conexión a la base de datos
    public function __destruct() {
        $this->conn = null;
    }
}
?>

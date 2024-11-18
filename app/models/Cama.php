<?php
class Cama {

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM cama";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id_cama) {
        $stmt = $this->conn->prepare("SELECT * FROM cama WHERE id_cama = :id_cama");
        $stmt->bindParam(':id_cama', $id_cama, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO cama (estado, id_habitacion, tipo_cama) VALUES (:estado, :id_habitacion, :tipo_cama)");
        $estado = $data['estado'] ?? 'Disponible';
        $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        $stmt->bindParam(':id_habitacion', $data['id_habitacion'], PDO::PARAM_INT);
        $stmt->bindParam(':tipo_cama', $data['tipo_cama'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function update($id_cama, $data) {
        $stmt = $this->conn->prepare("UPDATE cama SET estado = :estado, id_habitacion = :id_habitacion, tipo_cama = :tipo_cama WHERE id_cama = :id_cama");
        $stmt->bindParam(':estado', $data['estado'], PDO::PARAM_STR);
        $stmt->bindParam(':id_habitacion', $data['id_habitacion'], PDO::PARAM_INT);
        $stmt->bindParam(':tipo_cama', $data['tipo_cama'], PDO::PARAM_STR);
        $stmt->bindParam(':id_cama', $id_cama, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function patch($id_cama, $data) {
        $updateFields = [];
        $params = [];
        $i = 0;

        if (isset($data['estado'])) {
            $updateFields[] = "estado = :estado";
            $params[':estado'] = $data['estado'];
        }
        if (isset($data['id_habitacion'])) {
            $updateFields[] = "id_habitacion = :id_habitacion";
            $params[':id_habitacion'] = $data['id_habitacion'];
        }
        if (isset($data['tipo_cama'])) {
            $updateFields[] = "tipo_cama = :tipo_cama";
            $params[':tipo_cama'] = $data['tipo_cama'];
        }

        if (empty($updateFields)) {
            return false;
        }

        $sql = "UPDATE cama SET " . implode(", ", $updateFields) . " WHERE id_cama = :id_cama";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_cama', $id_cama, PDO::PARAM_INT);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        return $stmt->execute();
    }

    public function delete($id_cama) {
        $stmt = $this->conn->prepare("DELETE FROM cama WHERE id_cama = :id_cama");
        $stmt->bindParam(':id_cama', $id_cama, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Destructor: cerrar la conexión a la base de datos
    public function __destruct() {
        $this->conn = null;
    }
}
?>

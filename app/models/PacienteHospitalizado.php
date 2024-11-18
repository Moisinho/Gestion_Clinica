<?php
class PacienteHospitalizado {

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM paciente_hospitalizado";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByCedula($cedula) {
        $stmt = $this->conn->prepare("SELECT * FROM paciente_hospitalizado WHERE cedula = :cedula");
        $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function camaOcupada($id_cama, $fecha_ingreso) {
        $query = "SELECT COUNT(*) AS ocupado 
                  FROM paciente_hospitalizado 
                  WHERE id_cama = :id_cama 
                  AND estado_pacienteH = 'Hospitalizado' 
                  AND (fecha_ingreso <= :fecha_ingreso AND (fecha_egreso IS NULL OR fecha_egreso >= :fecha_ingreso))";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_cama', $id_cama, PDO::PARAM_INT);
        $stmt->bindParam(':fecha_ingreso', $fecha_ingreso, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data['ocupado'] > 0; // Retorna true si la cama está ocupada
    }

    public function habitacionDisponible($id_cama) {
        $query = "SELECT h.capacidad_disponible, COUNT(ph.cedula) AS camas_ocupadas 
                  FROM habitacion h 
                  JOIN cama c ON h.id_habitacion = c.id_habitacion 
                  LEFT JOIN paciente_hospitalizado ph ON c.id_cama = ph.id_cama 
                  WHERE c.id_cama = :id_cama 
                  GROUP BY h.id_habitacion";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_cama', $id_cama, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data['camas_ocupadas'] < $data['capacidad_disponible']; // Retorna true si hay camas disponibles
    }// Retorna true si hay camas disponibles

    private function isPacienteHospitalizado($cedula) {
        // Consulta para verificar si el paciente está hospitalizado
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM paciente_hospitalizado WHERE cedula = :cedula AND estado_pacienteH = 'Hospitalizado'");
        $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);
        $stmt->execute();
        
        // Retorna true si hay al menos un registro activo, false si no
        return $stmt->fetchColumn() > 0;
    }

    public function create($data) {
        // Verificar si el paciente ya está hospitalizado
        if ($this->isPacienteHospitalizado($data['cedula'])) {
            throw new Exception("El paciente ya está hospitalizado.");
        }
        // Verificar si la cama está ocupada
        if ($this->camaOcupada($data['id_cama'], $data['fecha_ingreso'])) {
            throw new Exception("La cama está ocupada por otro paciente.");
        }
        // Verificar si hay camas disponibles en la habitación
        if (!$this->habitacionDisponible($data['id_cama'])) {
            throw new Exception("No hay camas disponibles en la habitación.");
        }
         // Si todo está en orden, proceder a crear el registro
        $stmt = $this->conn->prepare("INSERT INTO paciente_hospitalizado (cedula, id_cama, id_medico, fecha_ingreso, motivo, estado_pacienteH) VALUES (:cedula, :id_cama, :id_medico, :fecha_ingreso, :motivo, :estado_pacienteH)");
        $stmt->bindParam(':cedula', $data['cedula'], PDO::PARAM_STR);
        $stmt->bindParam(':id_cama', $data['id_cama'], PDO::PARAM_INT);
        $stmt->bindParam(':id_medico', $data['id_medico'], PDO::PARAM_INT);
        $stmt->bindParam(':fecha_ingreso', $data['fecha_ingreso'], PDO::PARAM_STR);
        $stmt->bindParam(':motivo', $data['motivo'], PDO::PARAM_STR);
        $estado = $data['estado_pacienteH'] ?? 'Hospitalizado';
        $stmt->bindParam(':estado_pacienteH', $estado, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function update($cedula, $data) {
        $stmt = $this->conn->prepare("UPDATE paciente_hospitalizado SET id_cama = :id_cama, id_medico = :id_medico, fecha_ingreso = :fecha_ingreso, motivo = :motivo, estado_pacienteH = :estado_pacienteH WHERE cedula = :cedula");
        $stmt->bindParam(':id_cama', $data['id_cama'], PDO::PARAM_INT);
        $stmt->bindParam(':id_medico', $data['id_medico'], PDO::PARAM_INT);
        $stmt->bindParam(':fecha_ingreso', $data['fecha_ingreso'], PDO::PARAM_STR);
        $stmt->bindParam(':motivo', $data['motivo'], PDO::PARAM_STR);
        $stmt->bindParam(':estado_pacienteH', $data['estado_pacienteH'], PDO::PARAM_STR);
        $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function patch($cedula, $data) {
        $updateFields = [];
        $params = [];
        $i = 0;

        if (isset($data['id_cama'])) {
            $updateFields[] = "id_cama = :id_cama";
            $params[':id_cama'] = $data['id_cama'];
        }
        if (isset($data['id_medico'])) {
            $updateFields[] = "id_medico = :id_medico";
            $params[':id_medico'] = $data['id_medico'];
        }
        if (isset($data['fecha_ingreso'])) {
            $updateFields[] = "fecha_ingreso = :fecha_ingreso";
            $params[':fecha_ingreso'] = $data['fecha_ingreso'];
        }
        if (isset($data['motivo'])) {
            $updateFields[] = "motivo = :motivo";
            $params[':motivo'] = $data['motivo'];
        }
        if (isset($data['estado_pacienteH'])) {
            $updateFields[] = "estado_pacienteH = :estado_pacienteH";
            $params[':estado_pacienteH'] = $data['estado_pacienteH'];
        }

        if (empty($updateFields)) {
            return false;
        }

        $sql = "UPDATE paciente_hospitalizado SET " . implode(", ", $updateFields) . " WHERE cedula = :cedula";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        return $stmt->execute();
    }

    public function delete($cedula) {
        $stmt = $this->conn->prepare("DELETE FROM paciente_hospitalizado WHERE cedula = :cedula");
        $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Destructor: cerrar la conexión a la base de datos
    public function __destruct() {
        $this->conn = null;
    }
}
?>






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

    public function create($data) {
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






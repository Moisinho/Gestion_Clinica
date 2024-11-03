<?php
class Historial {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerHistorialPorUsuario($id_usuario) {
        try {
            $sql = "SELECT p.nombre_paciente, p.cedula, p.fecha_nacimiento, p.telefono, p.correo_paciente, 
                c.fecha_cita, m.nombre_medico AS medico, h.diagnostico, h.tratamiento, h.receta, h.examenes, h.recomendaciones
                FROM paciente AS p
                JOIN cita AS c ON p.cedula = c.cedula
                JOIN medico AS m ON c.id_medico = m.id_medico
                JOIN historial_medico AS h ON h.id_cita = c.id_cita
                WHERE p.id_usuario = :id_usuario";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error en obtenerHistorialPorUsuario: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerHistorialPorPaciente($id_paciente) {
        try {
            $sql = "SELECT p.nombre_paciente, p.cedula, p.fecha_nacimiento, p.telefono, p.correo_paciente, 
                c.fecha_cita, m.nombre_medico AS medico, h.diagnostico, h.tratamiento, h.receta, h.examenes, h.recomendaciones
                FROM paciente AS p
                JOIN cita AS c ON p.cedula = c.cedula
                JOIN medico AS m ON c.id_medico = m.id_medico
                JOIN historial_medico AS h ON h.id_cita = c.id_cita
                WHERE p.cedula = :id_paciente";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error en obtenerHistorialPorPaciente: " . $e->getMessage());
            return [];
        }
    }
}
?>

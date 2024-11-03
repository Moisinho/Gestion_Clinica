<?php
class Historial{
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }


    public function obtenerHistorialPorUsuario($id_usuario) {
        $sql = "SELECT p.nombre_paciente, p.cedula, p.fecha_nacimiento, p.telefono, p.correo_paciente, 
            c.fecha_cita, m.nombre_medico AS medico, h.diagnostico, h.tratamiento, h.receta, h.examenes, h.recomendaciones
            FROM paciente AS p
            JOIN cita AS c ON p.cedula = c.cedula
            JOIN medico AS m ON c.id_medico = m.id_medico
            JOIN historial_medico AS h ON h.id_cita = c.id_cita
            WHERE p.id_usuario = :id_usuario";
        
        // Preparar la consulta
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();

        // Obtener los resultados
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
?>

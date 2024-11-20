<?php
class Historial
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function obtenerHistorialPorUsuario($id_usuario)
    {
        try {
            $sql = "SELECT p.nombre_paciente, p.cedula, p.fecha_nacimiento, p.telefono, p.correo_paciente, 
                    c.fecha_cita, m.nombre_medico AS medico, h.diagnostico, h.tratamiento, h.receta, h.examenes, h.recomendaciones,
                    d.nombre_departamento AS departamento_referencia
                    FROM paciente AS p
                    JOIN cita AS c ON p.cedula = c.cedula
                    JOIN medico AS m ON c.id_medico = m.id_medico
                    JOIN historial_medico AS h ON h.id_cita = c.id_cita
                    LEFT JOIN departamento AS d ON h.id_departamento_referencia = d.id_departamento
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

    public function agregarHistorial($data)
    {
        try {
            $sql = "INSERT INTO historial_medico 
                    (cedula, id_cita, id_medico, peso, altura, presion_arterial, frecuencia_cardiaca, tipo_sangre, 
                    antecedentes_personales, otros_antecedentes, antecedentes_no_patologicos, otros_antecedentes_no_patologicos, 
                    condicion_general, examenes, laboratorios, diagnostico, recomendaciones, tratamiento, id_departamento_referencia) 
                    VALUES (:cedula, :id_cita, :id_medico, :peso, :altura, :presion_arterial, :frecuencia_cardiaca, :tipo_sangre, 
                    :antecedentes_patologicos, :otros_antecedentes_patologicos, :antecedentes_no_patologicos, 
                    :otros_antecedentes_no_patologicos, :condicion_general, :examenes_sangre, :laboratorios, :diagnostico, :recomendaciones, :tratamiento, :id_departamento_referencia)";

            $stmt = $this->conn->prepare($sql);

            foreach ($data as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en agregarHistorial: " . $e->getMessage());
            return false;
        }
    }

    public function agregarRecetas($id_cita, $recetas)
    {
        try {
            $sql = "INSERT INTO receta (id_cita, id_medicamento, dosis, duracion, frecuencia) 
                    VALUES (:id_cita, :id_medicamento, :dosis, :duracion, :frecuencia)";

            $stmt = $this->conn->prepare($sql);

            foreach ($recetas as $receta) {
                $stmt->bindValue(':id_cita', $id_cita);
                $stmt->bindValue(':id_medicamento', $receta['medicamento']);
                $stmt->bindValue(':dosis', $receta['dosis']);
                $stmt->bindValue(':duracion', $receta['duracion']);
                $stmt->bindValue(':frecuencia', $receta['frecuencia']);
                $stmt->execute();
            }

            return true;
        } catch (PDOException $e) {
            error_log("Error en agregarRecetas: " . $e->getMessage());
            return false;
        }
    }
    public function obtenerHistorialPorCedula($cedula) {
        $query = "SELECT p.nombre_paciente, p.cedula, p.fecha_nacimiento, p.telefono, p.correo_paciente, 
                c.fecha_cita, m.nombre_medico AS medico, h.diagnostico, h.tratamiento, h.receta, h.examenes, h.recomendaciones
                FROM paciente AS p
                JOIN cita AS c ON p.cedula = c.cedula
                JOIN medico AS m ON c.id_medico = m.id_medico
                JOIN historial_medico AS h ON h.id_cita = c.id_cita
                WHERE p.cedula = :cedula";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':cedula', $cedula);
    
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Devuelve todos los historiales como un arreglo
        }
    
        return []; // Devuelve un arreglo vacío si no hay resultados
    }
    
    
}

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
                    condicion_general, examenes, laboratorios, diagnostico, tratamiento, id_departamento_referencia) 
                    VALUES (:cedula, :id_cita, :id_medico, :peso, :altura, :presion_arterial, :frecuencia_cardiaca, :tipo_sangre, 
                    :antecedentes_patologicos, :otros_antecedentes_patologicos, :antecedentes_no_patologicos, 
                    :otros_antecedentes_no_patologicos, :condicion_general, :examenes_sangre, :laboratorios, :diagnostico, :tratamiento, :id_departamento_referencia)";

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
                // Convertir nombre del medicamento a su ID
                $id_medicamento = $this->obtenerIdMedicamentoPorNombre($receta['medicamento']);
                if (!$id_medicamento) {
                    throw new Exception("El medicamento '{$receta['medicamento']}' no existe en la base de datos.");
                }

                // Asociar valores para la receta
                $stmt->bindValue(':id_cita', $id_cita);
                $stmt->bindValue(':id_medicamento', $id_medicamento);
                $stmt->bindValue(':dosis', $receta['dosis']);
                $stmt->bindValue(':duracion', $receta['duracion']);
                $stmt->bindValue(':frecuencia', $receta['frecuencia']);

                // Ejecutar la consulta
                $stmt->execute();
            }

            return true;
        } catch (PDOException $e) {
            error_log("Error en agregarRecetas: " . $e->getMessage());
            return false;
        }
    }

    public function agregarReferencia($cedula_paciente, $id_departamento, $id_medico)
    {
        try {
            // Establecer la fecha de referencia
            $fecha_referencia = date('Y-m-d'); // Fecha actual

            // SQL para insertar en la tabla referencia_especialidad
            $sql = "INSERT INTO referencia_especialidad (cedula_paciente, id_departamento, fecha_referencia, id_medico) 
                VALUES (:cedula_paciente, :id_departamento, :fecha_referencia, :id_medico)";

            // Preparar la consulta
            $stmt = $this->conn->prepare($sql);

            // Vincular los parámetros
            $stmt->bindValue(':cedula_paciente', $cedula_paciente);
            $stmt->bindValue(':id_departamento', $id_departamento);
            $stmt->bindValue(':fecha_referencia', $fecha_referencia);
            $stmt->bindValue(':id_medico', $id_medico);

            // Ejecutar la consulta
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            // Manejo de errores
            error_log("Error al agregar referencia: " . $e->getMessage());
            return false;
        }
    }




    private function obtenerIdMedicamentoPorNombre($nombre_medicamento)
    {
        try {
            $sql = "SELECT id_medicamento FROM medicamento WHERE nombre = :nombre LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':nombre', $nombre_medicamento);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? $row['id_medicamento'] : null;
        } catch (PDOException $e) {
            error_log("Error en obtenerIdMedicamentoPorNombre: " . $e->getMessage());
            return null;
        }
    }


    public function obtenerHistorialPorCedula($cedula)
    {
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

    public function verificarCitaMedicinaGeneral($cedula)
    {
        try {
            $sql = "SELECT h.id_historial
                    FROM historial_medico AS h
                    JOIN medico AS m ON h.id_medico = m.id_medico
                    JOIN servicio AS s ON m.id_servicio = s.id_servicio
                    WHERE h.cedula = :cedula AND s.nombre_servicio = 'Cita Medicina General'";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);
            $stmt->execute();

            // Si hay resultados, el usuario tiene una cita de medicina general
            if ($stmt->rowCount() > 0) {
                return [
                    'tiene_cita_medicina_general' => true,
                    'mensaje' => 'El usuario ya tuvo una cita de medicina general.'
                ];
            }

            // Si no hay resultados, verificar si el usuario tiene historial
            $sqlHistorial = "SELECT id_historial 
                            FROM historial_medico 
                            WHERE cedula = :cedula";

            $stmtHistorial = $this->conn->prepare($sqlHistorial);
            $stmtHistorial->bindParam(':cedula', $cedula, PDO::PARAM_STR);
            $stmtHistorial->execute();

            if ($stmtHistorial->rowCount() > 0) {
                return [
                    'tiene_cita_medicina_general' => false,
                    'mensaje' => 'El usuario tiene historial, pero no una cita de medicina general.'
                ];
            }

            // Si no tiene historial
            return [
                'tiene_cita_medicina_general' => false,
                'mensaje' => 'El usuario no tiene historial médico registrado.'
            ];
        } catch (PDOException $e) {
            error_log("Error en verificarCitaMedicinaGeneral: " . $e->getMessage());
            return [
                'tiene_cita_medicina_general' => false,
                'mensaje' => 'Error al verificar la información del historial médico.'
            ];
        }
    }
}

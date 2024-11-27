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
            // Parte 1: Obtener los datos básicos del paciente
            $sqlPaciente = "SELECT p.nombre_paciente, p.cedula, p.fecha_nacimiento, p.telefono, p.correo_paciente
                        FROM paciente AS p
                        WHERE p.id_usuario = :id_usuario";

            $stmtPaciente = $this->conn->prepare($sqlPaciente);
            $stmtPaciente->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmtPaciente->execute();

            $paciente = $stmtPaciente->fetch(PDO::FETCH_OBJ);

            if (!$paciente) {
                return ["success" => false, "message" => "No se encontraron datos del paciente"];
            }

            // Parte 2: Intentar obtener el historial médico del paciente
            $sqlHistorial = "SELECT c.fecha_cita, c.motivo, m.nombre_medico AS medico, h.diagnostico, 
                        h.presion_arterial, h.frecuencia_cardiaca, h.peso, h.altura, h.tratamiento, 
                        h.condicion_general, h.examenes, r.duracion, r.frecuencia, r.dosis, med.nombre AS medicamento,
                        d.nombre_departamento AS departamento_referencia
                        FROM cita AS c
                        JOIN medico AS m ON c.id_medico = m.id_medico
                        JOIN historial_medico AS h ON h.id_cita = c.id_cita
                        LEFT JOIN receta AS r ON r.id_cita = c.id_cita
                        LEFT JOIN medicamento AS med ON r.id_medicamento = med.id_medicamento
                        LEFT JOIN departamento AS d ON h.id_departamento_referencia = d.id_departamento
                        WHERE c.cedula = :cedula";

            $stmtHistorial = $this->conn->prepare($sqlHistorial);
            $stmtHistorial->bindParam(':cedula', $paciente->cedula, PDO::PARAM_STR);
            $stmtHistorial->execute();

            $historial = $stmtHistorial->fetchAll(PDO::FETCH_OBJ);

            // Combinar los resultados
            return [
                "success" => true,
                "paciente" => $paciente,
                "historial" => $historial
            ];
        } catch (PDOException $e) {
            error_log("Error en obtenerHistorialPorUsuario: " . $e->getMessage());
            return ["success" => false, "message" => "Error al obtener los datos"];
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


    public function agregarHistorial($data)
    {
        try {
            $query = "INSERT INTO historial_medico (
            cedula, id_cita, id_medico, peso, altura, presion_arterial,
            frecuencia_cardiaca, tipo_sangre, antecedentes_personales,
            otros_antecedentes, antecedentes_no_patologicos,
            otros_antecedentes_no_patologicos, condicion_general,
            examenes, laboratorios, diagnostico,
            tratamiento, id_departamento_referencia
        ) VALUES (
            :cedula, :id_cita, :id_medico, :peso, :altura, :presion_arterial,
            :frecuencia_cardiaca, :tipo_sangre, :antecedentes_personales,
            :otros_antecedentes, :antecedentes_no_patologicos,
            :otros_antecedentes_no_patologicos, :condicion_general,
            :examenes, :laboratorios, :diagnostico,
            :tratamiento, :id_departamento_referencia
        )";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':cedula', $data['cedula']);
            $stmt->bindParam(':id_cita', $data['id_cita']);
            $stmt->bindParam(':id_medico', $data['id_medico']);
            $stmt->bindParam(':peso', $data['peso']);
            $stmt->bindParam(':altura', $data['altura']);
            $stmt->bindParam(':presion_arterial', $data['presion_arterial']);
            $stmt->bindParam(':frecuencia_cardiaca', $data['frecuencia_cardiaca']);
            $stmt->bindParam(':tipo_sangre', $data['tipo_sangre']);
            $stmt->bindParam(':antecedentes_personales', $data['antecedentes_personales']);
            $stmt->bindParam(':otros_antecedentes', $data['otros_antecedentes']);
            $stmt->bindParam(':antecedentes_no_patologicos', $data['antecedentes_no_patologicos']);
            $stmt->bindParam(':otros_antecedentes_no_patologicos', $data['otros_antecedentes_no_patologicos']);
            $stmt->bindParam(':condicion_general', $data['condicion_general']);
            $stmt->bindParam(':examenes', $data['examenes']);
            $stmt->bindParam(':laboratorios', $data['laboratorios']);
            $stmt->bindParam(':diagnostico', $data['diagnostico']);
            $stmt->bindParam(':tratamiento', $data['tratamiento']);
            $stmt->bindParam(':id_departamento_referencia', $data['id_departamento_referencia']);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al insertar historial: " . $e->getMessage());
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


    public function verificarCitaMedicinaGeneral($cedula)
    {
        try {
            $sql = "SELECT h.id_cita
                    FROM historial_medico AS h
                    JOIN medico AS m ON h.id_medico = m.id_medico
                    JOIN servicio AS s ON m.departamento = s.id_departamento
                    WHERE h.cedula = :cedula AND s.nombre_servicio = 'Consulta médica general'";

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
            $sqlHistorial = "SELECT id_cita
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


    public function obtenerHistorialPorCedula($cedula)
    {
        try {
            // Obtener datos del paciente
            $sqlPaciente = "SELECT nombre_paciente, cedula, fecha_nacimiento, telefono, correo_paciente
                        FROM paciente
                        WHERE cedula = :cedula";
            $stmtPaciente = $this->conn->prepare($sqlPaciente);
            $stmtPaciente->bindParam(':cedula', $cedula, PDO::PARAM_STR);
            $stmtPaciente->execute();

            $paciente = $stmtPaciente->fetch(PDO::FETCH_ASSOC);

            if (!$paciente) {
                return ["success" => false, "message" => "No se encontraron datos del paciente"];
            }

            // Obtener historial médico asociado con la consulta actualizada
            $sqlHistorial = "SELECT 
                            h.id_cita,
                            h.fecha_cita, 
                            h.motivo, 
                            m.nombre_medico AS medico, 
                            h.diagnostico, 
                            h.presion_arterial, 
                            h.frecuencia_cardiaca, 
                            h.peso, 
                            h.altura, 
                            h.tratamiento, 
                            h.condicion_general, 
                            h.examenes, 
                            GROUP_CONCAT(r.duracion SEPARATOR ', ') AS duracion,  
                            GROUP_CONCAT(r.frecuencia SEPARATOR ', ') AS frecuencia,  
                            GROUP_CONCAT(r.dosis SEPARATOR ', ') AS dosis,  
                            GROUP_CONCAT(med.nombre SEPARATOR ', ') AS medicamentos,  
                            d.nombre_departamento AS departamento_referencia
                          FROM 
                            historial_medico AS h
                          JOIN 
                            medico AS m ON h.id_medico = m.id_medico
                          LEFT JOIN 
                            receta AS r ON r.id_cita = h.id_cita
                          LEFT JOIN 
                            medicamento AS med ON r.id_medicamento = med.id_medicamento
                          LEFT JOIN 
                            departamento AS d ON h.id_departamento_referencia = d.id_departamento
                          WHERE 
                            h.cedula = :cedula
                          GROUP BY 
                            h.id_cita, h.fecha_cita, h.motivo, m.nombre_medico, h.diagnostico, 
                            h.presion_arterial, h.frecuencia_cardiaca, h.peso, h.altura, h.tratamiento, 
                            h.condicion_general, h.examenes, d.nombre_departamento";

            $stmtHistorial = $this->conn->prepare($sqlHistorial);
            $stmtHistorial->bindParam(':cedula', $cedula, PDO::PARAM_STR);
            $stmtHistorial->execute();

            $historial = $stmtHistorial->fetchAll(PDO::FETCH_ASSOC);

            // Procesar los datos antes de devolverlos
            foreach ($historial as &$registro) {
                // Formatear fecha (sin hora) si es necesario
                $registro['fecha_cita'] = date('Y-m-d', strtotime($registro['fecha_cita']));

                // Limpiar campos con saltos de línea o espacios adicionales
                $registro['motivo'] = $registro['motivo'] ?? 'No especificado';
                $registro['tratamiento'] = $registro['tratamiento'] ?? 'No especificado';
                $registro['condicion_general'] = $registro['condicion_general'] ?? 'No especificado';
                $registro['examenes'] = $registro['examenes'] ?? 'No especificado';

                // Reemplazar saltos de línea
                $registro['motivo'] = str_replace("\n", ' ', $registro['motivo']);
                $registro['tratamiento'] = str_replace("\n", ' ', $registro['tratamiento']);
                $registro['condicion_general'] = str_replace("\n", ' ', $registro['condicion_general']);
                $registro['examenes'] = str_replace("\n", ' ', $registro['examenes']);
            }

            // Estructurar la respuesta
            return [
                "success" => true,
                "paciente" => $paciente,
                "historial" => $historial
            ];
        } catch (PDOException $e) {
            error_log("Error en obtenerHistorialPorCedula: " . $e->getMessage());
            return [
                "success" => false,
                "error" => "Error al obtener los datos. Por favor, intente de nuevo."
            ];
        }
    }
}

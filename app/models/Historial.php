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
    try {
        // Obtener datos del paciente
        $sqlPaciente = "SELECT nombre_paciente, cedula, fecha_nacimiento, telefono, correo_paciente
                          FROM paciente
                          WHERE cedula = :cedula";
        $stmtPaciente = $this->conn->prepare($queryPaciente);
        $stmtPaciente->bindParam(':cedula', $cedula, PDO::PARAM_STR);

        $paciente = $stmtPaciente->fetch(PDO::FETCH_OBJ);

        if (!$paciente) {
            return ["success" => false, "message" => "No se encontraron datos del paciente"];
        }
        // Obtener historial médico asociado
        $sqlHistorial = "SELECT c.fecha_cita, c.motivo, m.nombre_medico AS medico, h.diagnostico, 
                                  h.presion_arterial, h.frecuencia_cardiaca, h.peso, h.altura, h.tratamiento, 
                                  h.condicion_general, h.examenes, r.duracion, r.frecuencia, r.dosis, med.nombre AS medicamento,
                                  d.nombre_departamento AS departamento_referencia
                           FROM cita AS c
                           JOIN medico AS m ON c.id_medico = m.id_medico
                           LEFT JOIN receta AS r ON r.id_cita = c.id_cita
                           LEFT JOIN medicamento AS med ON r.id_medicamento = med.id_medicamento
                           LEFT JOIN historial_medico AS h ON h.id_cita = c.id_cita
                           LEFT JOIN departamento AS d ON h.id_departamento_referencia = d.id_departamento
                           WHERE c.cedula = :cedula";
        $stmtHistorial = $this->conn->prepare($sqlHistorial);
        $stmtHistorial->bindParam(':cedula', $paciente->cedula, PDO::PARAM_STR);
        $stmtHistorial->execute();

        if ($stmtHistorial->execute()) {
            $historial = $stmtHistorial->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $historial = [];
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

<?php

class Cita
{
    private $conn; // Conexión a la base de datos
    private $table_name = "cita"; // Nombre de la tabla

    // Propiedades de la clase
    public $id_cita;
    public $estado;
    public $recordatorio;
    public $diagnostico;
    public $tratamiento;
    public $cedula;
    public $motivo;
    public $id_medico;
    public $id_servicio;
    public $fecha_cita;
    public $id_departamento;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function mapear_citas($input)
    {
        // Llamar al procedimiento almacenado con un solo parámetro de búsqueda
        $query = "CALL BuscarCitas(?)";
        $stmt = $this->conn->prepare($query);

        // Convertir la variable a cadena si es necesario
        $input_str = is_array($input) ? implode(",", $input) : $input;

        if ($stmt->bindParam(1, $input_str, PDO::PARAM_STR)) {
            if ($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return [];
            }
        } else {
            return [];
        }
    }

    public function mapear_citas_confirmadas()
    {
        $query = "SELECT * FROM cita WHERE estado = 'Confirmada'";
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }

    public function buscarCitasPorCriterio($criterio, $valor)
    {
        $valor = "%$valor%";
        $query = "SELECT * FROM cita WHERE $criterio LIKE :valor AND estado = 'Confirmada'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':valor', $valor, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarEstado($id_cita, $nuevo_estado)
    {
        $sql = "UPDATE cita SET estado = :estado WHERE id_cita = :id_cita";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':estado', $nuevo_estado);
            $stmt->bindParam(':id_cita', $id_cita);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al actualizar el estado: " . $e->getMessage();
            return false;
        }
    }

    public function obtener_citas()
    {
        $query = "SELECT id_cita, motivo, estado, fecha_cita, diagnostico, tratamiento, cedula, id_medico FROM cita";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function verificarPaciente($cedula)
    {
        $query = "SELECT * FROM paciente WHERE cedula = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $cedula);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function registrarCita($cedula, $motivo, $id_medico, $id_servicio, $fecha_cita)
    {
        try {
            // Sanitizar los datos de entrada
            $this->cedula = htmlspecialchars(trim($cedula));
            $this->motivo = htmlspecialchars(trim($motivo));
            $this->id_medico = htmlspecialchars(trim($id_medico));
            $this->id_servicio = htmlspecialchars(trim($id_servicio));
            $this->fecha_cita = htmlspecialchars(trim($fecha_cita));

            // Query para insertar la cita
            $query = "INSERT INTO cita (cedula, motivo, id_medico, id_servicio, fecha_cita) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->cedula);
            $stmt->bindParam(2, $this->motivo);
            $stmt->bindParam(3, $this->id_medico);
            $stmt->bindParam(4, $this->id_servicio);
            $stmt->bindParam(5, $this->fecha_cita);

            // Intentar ejecutar la consulta
            if ($stmt->execute()) {
                // Obtener el último ID insertado
                $id_cita = $this->conn->lastInsertId();

                // Obtener la información de la cita
                $info_cita = $this->obtenerInformacionCita($id_cita);

                // Enviar correo de confirmación
                $resultadoEnvio = $this->enviarCorreoCita($id_cita);

                if (!$resultadoEnvio) {
                    echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'La cita se ha registrado exitosamente.',
                    });
                </script>";
                }

                return true;
            } else {
                echo "<script>alert('Error al ejecutar la consulta para registrar la cita.');</script>";
                return false;
            }
        } catch (PDOException $e) {
            echo "<script>alert('Error al registrar la cita: {$e->getMessage()}');</script>";
            return false;
        }
    }



    public function obtener_detalles_cita($id_cita)
    {
        $sql = "
            SELECT 
                c.fecha_cita, 
                c.motivo, 
                p.cedula, 
                p.nombre_paciente, 
                p.fecha_nacimiento,
                p.telefono,
                p.correo_paciente,
                p.edad
            FROM 
                cita c 
            JOIN 
                paciente p ON c.cedula = p.cedula
            WHERE 
                c.id_cita = :id_cita
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id_cita', $id_cita, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtener_citas_medico($id_usuario)
    {
        $query = "
        SELECT
            c.id_cita,
            c.motivo,
            c.fecha_cita,
            c.estado,
            p.nombre_paciente,
            p.cedula AS id_paciente  -- Traemos la cédula del paciente como su ID
        FROM cita AS c
        JOIN paciente AS p ON p.cedula = c.cedula
        WHERE c.id_medico = (
            SELECT id_medico
            FROM medico
            WHERE id_usuario = :id_usuario
        ) AND c.estado = 'Pendiente'";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result ? $result : [];
    }

    public function obtenerCantidadCitas()
    {
        $query = "SELECT COUNT(*) as total_citas FROM cita WHERE estado = 'Programada'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_citas'] ?? 0;
    }

    public function obtenerCitasPorPeriodo($periodo)
    {
        if ($periodo === 'semana') {
            $query = "SELECT DATE(fecha_cita) AS fecha, COUNT(*) AS cantidad 
                  FROM cita 
                  WHERE fecha_cita >= CURDATE() - INTERVAL 7 DAY 
                  GROUP BY DATE(fecha_cita)
                  ORDER BY fecha ASC;";
        } elseif ($periodo === 'mes') {
            $query = "SELECT DATE(fecha_cita) AS fecha, COUNT(*) AS cantidad 
                  FROM cita 
                  WHERE fecha_cita >= CURDATE() - INTERVAL 1 MONTH 
                  GROUP BY DATE(fecha_cita) 
                  ORDER BY fecha ASC;";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerCitasPorPaciente($id_usuario)
    {
        $query = "
            SELECT 
                motivo, 
                fecha_cita, 
                estado, 
                (SELECT nombre_medico FROM medico WHERE id_medico = cita.id_medico) AS Doctor
            FROM cita 
            WHERE cedula = (
                SELECT cedula
                FROM paciente 
                WHERE id_usuario = :id_usuario
            )
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
    public function obtener_detalles_modal($id_cita)
    {
        // Consulta para obtener el diagnóstico y el servicio de la cita
        $query = "SELECT c.diagnostico, s.servicio 
                  FROM cita c
                  JOIN servicio s ON c.id_servicio = s.id_servicio
                  WHERE c.id_cita = :id_cita";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_cita', $id_cita);
        $stmt->execute();

        // Obtener el resultado
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si se encontró la cita
        if ($row) {
            return $row;
        }

        return null; // Si no se encuentra, devolver null
    }




    // Nuevas funciones para gestionar recetas
    public function registrarReceta($id_cita, $id_medicamento, $dosis, $duracion, $frecuencia)
    {
        $query = "INSERT INTO receta (id_cita, id_medicamento, dosis, duracion, frecuencia) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_cita);
        $stmt->bindParam(2, $id_medicamento);
        $stmt->bindParam(3, $dosis);
        $stmt->bindParam(4, $duracion);
        $stmt->bindParam(5, $frecuencia);
        return $stmt->execute();
    }

    public function obtenerRecetasPorCita($id_cita)
    {
        $query = "SELECT r.id_receta, r.dosis, r.duracion, r.frecuencia, m.nombre_medicamento 
                  FROM receta r 
                  JOIN medicamento m ON r.id_medicamento = m.id_medicamento 
                  WHERE r.id_cita = :id_cita";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_cita', $id_cita, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function obtenerInformacionCita($id_cita)
    {
        $query = "
        SELECT 
            p.correo_paciente AS correo,
            c.fecha_cita,
            p.nombre_paciente,
            m.nombre_medico AS doctor
        FROM 
            cita c
        JOIN 
            paciente p ON c.cedula = p.cedula
        JOIN 
            medico m ON c.id_medico = m.id_medico
        WHERE 
            c.id_cita = :id_cita
    ";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_cita', $id_cita, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                echo "Error en la ejecución de la consulta.";
                return null;
            }
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return null;
        }
    }

    public function enviarCorreoCita($id_cita)
    {

        $infoCita = $this->obtenerInformacionCita($id_cita);

        if (!$infoCita) {
            echo "<script>alert('No se pudo obtener la información de la cita.');</script>";
            return false;
        }
        $asunto = 'Recordatorio de Cita Medica';
        $mensaje = "
        <h1>Estimado(a) {$infoCita['nombre_paciente']}</h1>
        <p>Su cita ha sido programada para la fecha: <strong>{$infoCita['fecha_cita']}</strong></p>
        <p>El médico que lo(a) atenderá es: <strong>{$infoCita['doctor']}</strong></p>
        <p>Por favor, contacte a la clínica si necesita más información.</p>
    ";

        require_once '../helpers/correo.php';
        if (enviarCorreoSMTP($infoCita['correo'], $asunto, $mensaje)) {
            return true;
        } else {
            return false;
        }
    }


    public function registrarReferenciaEspecialidad($cedula_paciente, $id_departamento, $id_medico)
    {
        error_log("Intentando registrar referencia para el paciente: " . $cedula_paciente);

        if ($this->verificarReferencia($cedula_paciente, $id_departamento)) {
            error_log("El paciente ya tiene una referencia para esta especialidad.");
            return false;
        }

        $fecha_referencia = date("Y-m-d");
        $query = "INSERT INTO referencia_especialidad (cedula_paciente, id_departamento, fecha_referencia, id_medico) 
              VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $cedula_paciente);
        $stmt->bindParam(2, $id_departamento);
        $stmt->bindParam(3, $fecha_referencia);
        $stmt->bindParam(4, $id_medico);

        $resultado = $stmt->execute();
        error_log("Resultado de la inserción: " . ($resultado ? "éxito" : "fallo"));
        return $resultado;
    }


    // Método para verificar si el paciente ya tiene una referencia de especialidad
    public function verificarReferencia($cedula_paciente, $id_departamento)
    {
        $query = "SELECT * FROM referencia_especialidad WHERE cedula_paciente = ? AND id_departamento = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $cedula_paciente);
        $stmt->bindParam(2, $id_departamento);
        $stmt->execute();
        return $stmt->rowCount() > 0; // Si ya tiene una referencia, retorna verdadero
    }

    // Método para registrar la cita y asociar una especialidad (referencia) al paciente
    public function registrarCitaConReferencia($cedula, $motivo, $id_medico, $id_servicio, $fecha_cita, $id_departamento)
    {
        // Llamar al método para registrar la referencia de especialidad
        if (!$this->registrarReferenciaEspecialidad($cedula, $id_departamento, $id_medico)) {
            return false; // Si no se pudo registrar la referencia, detener el proceso
        }

        $this->cedula = htmlspecialchars(trim($cedula));
        $this->motivo = htmlspecialchars(trim($motivo));
        $this->id_medico = htmlspecialchars(trim($id_medico));
        $this->id_servicio = htmlspecialchars(trim($id_servicio));
        $this->fecha_cita = htmlspecialchars(trim($fecha_cita));

        // Inserción de la cita
        $query = "INSERT INTO cita (cedula, motivo, id_medico, id_servicio, fecha_cita) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->cedula);
        $stmt->bindParam(2, $this->motivo);
        $stmt->bindParam(3, $this->id_medico);
        $stmt->bindParam(4, $this->id_servicio);
        $stmt->bindParam(5, $this->fecha_cita);

        return $stmt->execute();
    }
}

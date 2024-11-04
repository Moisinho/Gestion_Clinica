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

    public function mapear_citas_pendientes()
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
        $this->cedula = htmlspecialchars(trim($cedula));
        $this->motivo = htmlspecialchars(trim($motivo));
        $this->id_medico = htmlspecialchars(trim($id_medico));
        $this->id_servicio = htmlspecialchars(trim($id_servicio));
        $this->fecha_cita = htmlspecialchars(trim($fecha_cita));

        $query = "INSERT INTO cita (cedula, motivo, id_medico, id_servicio, fecha_cita) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->cedula);
        $stmt->bindParam(2, $this->motivo);
        $stmt->bindParam(3, $this->id_medico);
        $stmt->bindParam(4, $this->id_servicio);
        $stmt->bindParam(5, $this->fecha_cita);

        return $stmt->execute();
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

    public function obtener_citas_medico($id_medico)
    {
        $query = "SELECT id_cita, motivo, estado, fecha_cita, diagnostico, tratamiento, cedula, id_medico 
              FROM cita 
              WHERE id_medico = :id_medico AND estado = 'Pendiente'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_medico', $id_medico, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
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
}
?>
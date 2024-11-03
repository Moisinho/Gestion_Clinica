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

        // Aquí hay un cambio: `bindParam` devuelve verdadero o falso, no el valor
        // Por eso, verifica si `bindParam` fue exitoso
        if ($stmt->bindParam(1, $input_str, PDO::PARAM_STR)) {
            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Si la consulta se ejecuta correctamente, devolver los resultados
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                // Manejo de errores si la ejecución falla
                return [];
            }
        } else {
            // Manejo de errores si bindParam falla
            return [];
        }
    }

    public function mapear_citas_pendientes()
    {
        // Llamar al procedimiento almacenado con un solo parámetro de búsqueda
        $query = "SELECT * FROM cita WHERE estado = 'Confirmada'";
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {
            // Si la consulta se ejecuta correctamente, devolver los resultados
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            // Manejo de errores si la ejecución falla
            return [];
        }
    }

    public function buscarCitasPorCriterio($criterio, $valor)
    {
        // Agregar los comodines de porcentaje a la variable $valor
        $valor = "%$valor%";

        // Construir la consulta con PDO
        $query = "SELECT * FROM cita WHERE $criterio LIKE :valor AND estado = 'Confirmada'";

        // Preparar la consulta
        $stmt = $this->conn->prepare($query);

        // Enlazar el valor con bindValue (PDO::PARAM_STR se usa para cadenas)
        $stmt->bindValue(':valor', $valor, PDO::PARAM_STR);

        // Ejecutar la consulta
        $stmt->execute();

        // Devolver los resultados como un array asociativo
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

        $query = "INSERT INTO cita (cedula, motivo, id_medico, id_servicio, fecha_cita) VALUES (?, ?, ?,?, ?)";
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
        // Preparar la consulta SQL
        $sql  = "
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

        // Cambiar $db por $conn
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
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result ?: []; // Retorna un arreglo vacío si no hay resultados
    }




    public function obtenerCantidadCitas()
    {
        $query = "SELECT COUNT(*) as total_citas FROM cita WHERE estado = 'Programada'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_citas'] ?? 0;
    }

    public function obtenerCitasPorPeriodo($periodo = 'semana')
    {
        if ($periodo === 'semana') {
            $query = "SELECT DATE(fecha_cita) AS fecha, COUNT(*) AS cantidad 
                  FROM cita 
                  WHERE fecha_cita >= CURDATE() - INTERVAL 7 DAY 
                  GROUP BY DATE(fecha_cita)";
        } elseif ($periodo === 'mes') {
            $query = "SELECT DATE(fecha_cita) AS fecha, COUNT(*) AS cantidad 
                  FROM cita 
                  WHERE fecha_cita >= CURDATE() - INTERVAL 1 MONTH 
                  GROUP BY DATE(fecha_cita)";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function obtenerCitasPorPaciente($id_usuario) {
        // Consulta SQL
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
    
        // Preparar y ejecutar
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

        $stmt->execute();
    
        // Obtener resultados
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result ? $result : []; // Asegúrate de que devuelves un array vacío si no hay resultados
    }
    
    

}

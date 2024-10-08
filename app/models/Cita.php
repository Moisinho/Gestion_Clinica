<?php
class Cita {
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
    public $fecha_cita;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }
    public function mapear_citas($input) {
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

    public function mapear_citas_pendientes() {
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
    
    public function actualizarEstado($id_cita, $nuevo_estado) {
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
    public function obtener_citas() {
        $query = "SELECT id_cita, motivo, estado, fecha_cita, diagnostico, tratamiento, cedula, id_medico FROM cita";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    public function verificarPaciente($cedula) {
        $query = "SELECT * FROM paciente WHERE cedula = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $cedula);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function registrarCita($cedula, $motivo, $id_medico, $fecha_cita) {
        $this->cedula = htmlspecialchars(trim($cedula));
        $this->motivo = htmlspecialchars(trim($motivo));
        $this->id_medico = htmlspecialchars(trim($id_medico));
        $this->fecha_cita = htmlspecialchars(trim($fecha_cita));

        $query = "INSERT INTO cita (cedula, motivo, id_medico, fecha_cita) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(1, $this->cedula);
        $stmt->bindParam(2, $this->motivo);
        $stmt->bindParam(3, $this->id_medico);
        $stmt->bindParam(4, $this->fecha_cita);
        
        return $stmt->execute();
    }

    
}
?>
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
    

    public function validar_cita($placa) {
        $query = "SELECT * FROM automoviles WHERE placa = :placa";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':placa', $placa, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);  // Devolver los datos del automóvil
        } else {
            return false;
        }
    }


        public function obtener_citas() {
        $query = "SELECT id_cita, motivo, estado, recordatorio, fecha_cita, diagnostico, tratamiento, cedula, id_medico FROM Cita";
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

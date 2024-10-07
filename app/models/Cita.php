<?php
class Cita {
    private $conn; // Conexión a la base de datos
    private $table_name = "cita"; // Nombre de la tabla

    // Propiedades de la clase
    public $id_cita;
    public $estado;
    public $recordatorio;
    public $fecha_cita;
    public $diagnostico;
    public $tratamiento;
    public $cedula;
    public $id_medico;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para registrar un nuevo automóvil
    public function registrar_cita() {
        // Query para insertar un nuevo automóvil
        $query = "INSERT INTO " . $this->table_name . " (placa, marca, modelo, anio, color, numero_motor, numero_chasis, tipo_vehiculo) VALUES (:placa, :marca, :modelo, :anio, :color, :motor, :chasis, :tipo_vehiculo)";

        // Preparar la declaración
        $stmt = $this->conn->prepare($query);

        // Limpiar los datos para evitar inyección SQL
        $this->placa = htmlspecialchars(strip_tags($this->placa));
        $this->marca = htmlspecialchars(strip_tags($this->marca));
        $this->modelo = htmlspecialchars(strip_tags($this->modelo));
        $this->anio = htmlspecialchars(strip_tags($this->anio));
        $this->color = htmlspecialchars(strip_tags($this->color));
        $this->motor = htmlspecialchars(strip_tags($this->motor));
        $this->chasis = htmlspecialchars(strip_tags($this->chasis));
        $this->tipo_vehiculo = htmlspecialchars(strip_tags($this->tipo_vehiculo));

        // Enlazar los parámetros
        $stmt->bindParam(":placa", $this->placa);
        $stmt->bindParam(":marca", $this->marca);
        $stmt->bindParam(":modelo", $this->modelo);
        $stmt->bindParam(":anio", $this->anio);
        $stmt->bindParam(":color", $this->color);
        $stmt->bindParam(":motor", $this->motor);
        $stmt->bindParam(":chasis", $this->chasis);
        $stmt->bindParam(":tipo_vehiculo", $this->tipo_vehiculo);

        // Ejecutar la declaración
        if ($stmt->execute()) {
            return true;
        }
        return false;
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
    
    

    public function eliminar_cita($placa) {
        $query = "DELETE FROM automoviles WHERE placa = :placa";
    
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(":placa", $placa, PDO::PARAM_INT);
    
        // Ejecutar la declaración
        if ($stmt->execute()) {
            return true; 
        } else {
            return false; }
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

    public function actualizar_cita() {
        $query = "UPDATE automoviles 
                  SET marca = :marca, 
                      modelo = :modelo, 
                      anio = :anio, 
                      color = :color,
                      numero_motor = :motor,
                      numero_chasis = :chasis, 
                      tipo_vehiculo = :tipo_vehiculo
                  WHERE placa = :placa";
        
        $stmt = $this->conn->prepare($query);

        $this->placa = htmlspecialchars(strip_tags($this->placa));
        $this->marca = htmlspecialchars(strip_tags($this->marca));
        $this->modelo = htmlspecialchars(strip_tags($this->modelo));
        $this->anio = htmlspecialchars(strip_tags($this->anio));
        $this->color = htmlspecialchars(strip_tags($this->color));
        $this->motor = htmlspecialchars(strip_tags($this->motor));
        $this->chasis = htmlspecialchars(strip_tags($this->chasis));
        $this->tipo_vehiculo = htmlspecialchars(strip_tags($this->tipo_vehiculo));

        
        $stmt->bindParam(':placa', $this->placa, PDO::PARAM_STR);
        $stmt->bindParam(':marca', $this->marca, PDO::PARAM_STR);
        $stmt->bindParam(':modelo', $this->modelo, PDO::PARAM_STR);
        $stmt->bindParam(':anio', $this->anio, PDO::PARAM_INT);
        $stmt->bindParam(':color', $this->color, PDO::PARAM_STR);
        $stmt->bindParam(':motor', $this->motor, PDO::PARAM_STR);
        $stmt->bindParam(':chasis', $this->chasis, PDO::PARAM_STR);
        $stmt->bindParam(':tipo_vehiculo', $this->tipo_vehiculo, PDO::PARAM_STR);

        
        return $stmt->execute();
    }

        public function obtener_citas() {
        $query = "SELECT id_cita, estado, recordatorio, fecha_cita, diagnostico, tratamiento, cedula, id_medico FROM Cita";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
}
?>

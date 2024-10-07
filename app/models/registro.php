<?php
// Incluir el archivo de conexión a la base de datos
require_once '../includes/Database.php';

class Registro {
    private $conn;

    // Constructor
    public function __construct() {
        // Crear una instancia de la conexión a la base de datos
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Método para registrar un nuevo usuario
    public function registrarUsuario($cedula, $nombre, $correo, $fecha_nacimiento, $direccion, $seguro, $telefono) {
        // Calcular la edad
        $fecha_actual = new DateTime();
        $fecha_nac = new DateTime($fecha_nacimiento);
        $edad = $fecha_actual->diff($fecha_nac)->y;

        // Preparar la consulta
        $sql = "INSERT INTO paciente (cedula, nombre_paciente, correo_paciente, fecha_nacimiento, direccion_paciente, seguro, telefono, edad) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);

        // Ejecutar la consulta
        if ($stmt->execute([$cedula, $nombre, $correo, $fecha_nacimiento, $direccion, $seguro, $telefono, $edad])) {
            return true; // Registro exitoso
        } else {
            return false; // Error en el registro
        }
    }
}

// Comprobar si el formulario fue enviado
// Comprobar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Depurar los datos recibidos
    var_dump($_POST); // Muestra los datos recibidos del formulario

    // Obtener datos del formulario
    $cedula = $_POST['cedula'] ?? null;
    $nombre = $_POST['nombre'] ?? null;
    $correo = $_POST['correo'] ?? null;
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? null;
    $direccion = $_POST['direccion'] ?? null;
    $seguro = $_POST['seguro'] ?? null;
    $telefono = $_POST['telefono'] ?? null;

    // Crear una instancia de la clase Registro
    $registro = new Registro();

    // Registrar al usuario
    if ($registro->registrarUsuario($cedula, $nombre, $correo, $fecha_nacimiento, $direccion, $seguro, $telefono)) {
        echo "Registro exitoso";
    } else {
        echo "Error en el registro";
    }
}

?>

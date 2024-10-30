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
    public function registrarUsuario($cedula, $nombre, $correo, $fecha_nacimiento, $direccion, $telefono, $contrasenia) {
        // Calcular la edad
        $fecha_actual = new DateTime();
        $fecha_nac = new DateTime($fecha_nacimiento);
        $edad = $fecha_actual->diff($fecha_nac)->y;

        try {
            // Iniciar una transacción
            $this->conn->beginTransaction();

            // Hashear la contraseña
            $contraseniaHashed = password_hash($contrasenia, PASSWORD_DEFAULT);

            // Insertar en la tabla usuario
            $sqlUsuario = "INSERT INTO usuario (correo, tipo_usuario, contrasenia) VALUES (?, 'paciente', ?)";
            $stmtUsuario = $this->conn->prepare($sqlUsuario);
            $stmtUsuario->execute([$correo, $contraseniaHashed]);
            $id_usuario = $this->conn->lastInsertId(); // Obtener el ID del usuario insertado

            // Preparar la consulta para insertar en paciente
            $sqlPaciente = "INSERT INTO paciente (cedula, nombre_paciente, correo_paciente, fecha_nacimiento, direccion_paciente, telefono, edad, id_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtPaciente = $this->conn->prepare($sqlPaciente);

            // Ejecutar la consulta para paciente
            if ($stmtPaciente->execute([$cedula, $nombre, $correo, $fecha_nacimiento, $direccion, $telefono, $edad, $id_usuario])) {
                // Confirmar la transacción
                $this->conn->commit();
                return true; // Registro exitoso
            } else {
                throw new Exception("Error al registrar en la tabla paciente");
            }
        } catch (Exception $e) {
            // Deshacer la transacción en caso de error
            $this->conn->rollBack();
            return false; // Error en el registro
        }
    }
}

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
    $telefono = $_POST['telefono'] ?? null;
    $contrasenia = $_POST['contrasenia'] ?? null; // Obtener la contraseña del formulario

    // Crear una instancia de la clase Registro
    $registro = new Registro();

    // Registrar al usuario
    if ($registro->registrarUsuario($cedula, $nombre, $correo, $fecha_nacimiento, $direccion, $telefono, $contrasenia)) {
        echo "Registro exitoso";
    } else {
        echo "Error en el registro";
    }
}
?>

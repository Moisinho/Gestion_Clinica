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

    // Método para registrar un nuevo usuario PD: Esto es para que lo redirija a la página de usuario
    public function registrarUsuario($cedula, $nombre, $correo, $fecha_nacimiento, $direccion, $telefono, $sexo, $seguro, $contrasenia) {
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
            $sqlUsuario = "INSERT INTO usuario (correo, tipo_usuario, contrasenia) VALUES (?, 'Paciente', ?)";
            $stmtUsuario = $this->conn->prepare($sqlUsuario);
            $stmtUsuario->execute([$correo, $contraseniaHashed]);
            $id_usuario = $this->conn->lastInsertId(); // Obtener el ID del usuario insertado

            // Obtener el id_seguro a partir del nombre de la aseguradora
            $sqlSeguro = "SELECT id_seguro FROM seguro WHERE nombre_aseguradora = ?";
            $stmtSeguro = $this->conn->prepare($sqlSeguro);
            $stmtSeguro->execute([$seguro]);
            $resultadoSeguro = $stmtSeguro->fetch(PDO::FETCH_ASSOC);

            if (!$resultadoSeguro) {
                throw new Exception("No se encontró el seguro seleccionado.");
            }
            $id_seguro = $resultadoSeguro['id_seguro']; // Obtener el id_seguro

            // Preparar la consulta para insertar en paciente
            $sqlPaciente = "INSERT INTO paciente (cedula, nombre_paciente, correo_paciente, fecha_nacimiento, direccion_paciente, telefono, edad, id_usuario, sexo, id_seguro) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtPaciente = $this->conn->prepare($sqlPaciente);
            $stmtPaciente->execute([$cedula, $nombre, $correo, $fecha_nacimiento, $direccion, $telefono, $edad, $id_usuario, $sexo, $id_seguro]);

            // Confirmar la transacción
            $this->conn->commit();

            // Iniciar sesión y almacenar información del usuario
            session_start(); // Llamar a session_start() aquí, después del éxito del registro
            $_SESSION['id_usuario'] = $id_usuario; // Almacena el ID del usuario
            $_SESSION['nombre'] = $nombre; // Almacena el nombre del usuario

            // Mostrar alerta y redirigir
            echo "<script>
                    alert('Registro exitoso. Bienvenido, $nombre.');
                    window.location.href = '../views/Paciente/index_paciente.php'; // Cambia esto a la ruta deseada
                  </script>";
        } catch (Exception $e) {
            // Revertir la transacción si ocurre un error
            $this->conn->rollBack();
            echo "Error en el registro: " . $e->getMessage();
        }
    }

    //Este es el método que no redirije, sino que lo deja en la pagina de admin
    public function registrarPaciente($cedula, $nombre, $correo, $fecha_nacimiento, $direccion, $telefono, $sexo, $seguro, $contrasenia) {
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
            $sqlUsuario = "INSERT INTO usuario (correo, tipo_usuario, contrasenia) VALUES (?, 'Paciente', ?)";
            $stmtUsuario = $this->conn->prepare($sqlUsuario);
            $stmtUsuario->execute([$correo, $contraseniaHashed]);
            $id_usuario = $this->conn->lastInsertId(); // Obtener el ID del usuario insertado

            // Obtener el id_seguro a partir del nombre de la aseguradora
            $sqlSeguro = "SELECT id_seguro FROM seguro WHERE nombre_aseguradora = ?";
            $stmtSeguro = $this->conn->prepare($sqlSeguro);
            $stmtSeguro->execute([$seguro]);
            $resultadoSeguro = $stmtSeguro->fetch(PDO::FETCH_ASSOC);

            if (!$resultadoSeguro) {
                throw new Exception("No se encontró el seguro seleccionado.");
            }
            $id_seguro = $resultadoSeguro['id_seguro']; // Obtener el id_seguro

            // Preparar la consulta para insertar en paciente
            $sqlPaciente = "INSERT INTO paciente (cedula, nombre_paciente, correo_paciente, fecha_nacimiento, direccion_paciente, telefono, edad, id_usuario, sexo, id_seguro) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtPaciente = $this->conn->prepare($sqlPaciente);
            $stmtPaciente->execute([$cedula, $nombre, $correo, $fecha_nacimiento, $direccion, $telefono, $edad, $id_usuario, $sexo, $id_seguro]);

            // Mostrar alerta y redirigir
            echo "<script>
                    alert('Registro exitoso. Bienvenido, $nombre.');
                  </script>";
        } catch (Exception $e) {
            // Revertir la transacción si ocurre un error
            $this->conn->rollBack();
            echo "Error en el registro: " . $e->getMessage();
        }
    }
}

// chamo que tas haciendo? hola, que falta? es que la idea es crear las vainas pa registrar aqui jeje, y en anadir medico namas las llamamos
$registro = new Registro();
$registro->registrarUsuario(
    $_POST['cedula'],
    $_POST['nombre'],
    $_POST['correo'],
    $_POST['fecha_nacimiento'],
    $_POST['direccion'],
    $_POST['telefono'],
    $_POST['sexo'],
    $_POST['seguro'],
    $_POST['contrasenia']
);
$registro->registrarPaciente(
    $_POST['cedula'],
    $_POST['nombre'],
    $_POST['correo'],
    $_POST['fecha_nacimiento'],
    $_POST['direccion'],
    $_POST['telefono'],
    $_POST['sexo'],
    $_POST['seguro'],
    $_POST['contrasenia']
);
?>

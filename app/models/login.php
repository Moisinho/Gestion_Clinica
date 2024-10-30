<?php
session_start();
require_once '../includes/Database.php'; // Asegúrate de que el archivo de conexión se incluya correctamente

// Crear una instancia de la conexión a la base de datos
$database = new Database();
$conn = $database->getConnection(); // Inicializa la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'] ?? null; // Asegúrate de que este nombre coincida con el del formulario
    $password = $_POST['password'] ?? null; // Asegúrate de que este nombre coincida con el del formulario

    if ($correo && $password) {
        // Consulta para identificar si el usuario existe y obtener el tipo de usuario
        $sql = "SELECT tipo_usuario FROM usuario WHERE correo = ? AND contrasenia = ?"; // Asegúrate de validar la contraseña
        $stmt = $conn->prepare($sql);

        // Usar bindValue para vincular los parámetros
        $stmt->bindValue(1, $correo, PDO::PARAM_STR);
        $stmt->bindValue(2, $password, PDO::PARAM_STR);

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC); // Cambiado a fetch para obtener los datos

        if ($result) {
            $_SESSION['correo'] = $correo;
            $_SESSION['tipo_usuario'] = $result['tipo_usuario'];

            // Mensaje de bienvenida y redirección
            if ($result['tipo_usuario'] == 'medico') {
                echo "Bienvenido, Médico.";
                header("Location: medico_dashboard.php");
            } elseif ($result['tipo_usuario'] == 'paciente') {
                echo "Bienvenido, Paciente.";
                header("Location: paciente_dashboard.php");
            }
            exit(); // Asegúrate de salir después de la redirección
        } else {
            echo "Usuario o contraseña incorrectos.";
        }
    } else {
        echo "Por favor, completa todos los campos.";
    }
}
?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
require_once '../includes/Database.php';
require '../../vendor/autoload.php';
require_once 'correo.php'; // Asegúrate de que la ruta sea correcta

function generarToken($correo) {
    // Crea una instancia de la clase Database y obtiene la conexión
    $database = new Database();
    $conn = $database->getConnection();  // Obtén la conexión PDO

    // Verifica si el correo existe
    $query = $conn->prepare("SELECT id_usuario FROM usuario WHERE correo = :correo");
    $query->bindValue(':correo', $correo, PDO::PARAM_STR);
    $query->execute();
    $resultado = $query->fetch(PDO::FETCH_ASSOC); // Utiliza fetch en vez de get_result

    if (!$resultado) {
        return false; // El correo no existe
    }

    // Verifica si ya existe un token para este correo
    $query = $conn->prepare("SELECT id FROM restablecimiento_tokens WHERE correo = :correo");
    $query->bindValue(':correo', $correo, PDO::PARAM_STR);
    $query->execute();
    $resultado = $query->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        $query = $conn->prepare("DELETE FROM restablecimiento_tokens WHERE correo = :correo");
        $query->bindValue(':correo', $correo, PDO::PARAM_STR);
        $query->execute();
    }
    $token = bin2hex(random_bytes(12));
    $query = $conn->prepare("INSERT INTO restablecimiento_tokens (correo, token, fecha_expiracion) VALUES (:correo, :token, DATE_ADD(NOW(), INTERVAL 1 HOUR))");
    $query->bindValue(':correo', $correo, PDO::PARAM_STR);
    $query->bindValue(':token', $token, PDO::PARAM_STR);
    $query->execute();


    return $token;
}

function enviarEnlaceRestablecimiento($correo, $token) {
    $url = "http://localhost/Gestion_clinica/reset-password?token=" . $token;
    $mensaje = "Haz clic en el siguiente enlace para restablecer tu contraseña: <a href='$url'>$url</a>";
    
    return enviarCorreoSMTP($correo, "Restablecimiento de Contrasena", $mensaje);
}

?>

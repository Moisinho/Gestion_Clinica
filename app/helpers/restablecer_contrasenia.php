<?php
use PHPMailer\PHPMailer\PHPMailer;
require_once '../includes/Database.php';
require '../../vendor/autoload.php';

function validarYRestablecerContrasena($token, $nueva_contrasena) {

    $database = new Database();
    $conn = $database->getConnection();

    if ($conn === null) {
        return "Error de conexión a la base de datos.";
    }

    // Verificar si el token es válido y no ha expirado
    $query = $conn->prepare("SELECT * FROM restablecimiento_tokens WHERE token = :token AND fecha_expiracion > NOW()");
    $query->bindValue(':token', $token, PDO::PARAM_STR);
    $query->execute();
    $resultado = $query->fetch(PDO::FETCH_ASSOC);

    if (!$resultado) {
        return "El token no es válido o ha expirado.";
    }

    // Obtener el correo asociado al token
    $correo = $resultado['correo'];

    // Encriptar la nueva contraseña
    $nueva_contrasena_encriptada = password_hash($nueva_contrasena, PASSWORD_BCRYPT);

    // Actualizar la contraseña en la base de datos
    $query = $conn->prepare("UPDATE usuario SET contrasenia = :contrasena WHERE correo = :correo");
    $query->bindValue(':contrasena', $nueva_contrasena_encriptada, PDO::PARAM_STR);
    $query->bindValue(':correo', $correo, PDO::PARAM_STR);
    
    if ($query->execute() === false) {
        return "Error al actualizar la contraseña.";
    }

    // Eliminar el token de la base de datos para evitar su reutilización
    $query = $conn->prepare("DELETE FROM restablecimiento_tokens WHERE token = :token");
    $query->bindValue(':token', $token, PDO::PARAM_STR);

    if ($query->execute() === false) {
        return "Error al eliminar el token.";
    }

    return "Contraseña restablecida con éxito.";
}

?>
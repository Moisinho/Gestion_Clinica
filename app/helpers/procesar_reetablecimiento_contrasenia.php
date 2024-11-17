<?php
require_once '../includes/Database.php';
require_once '../helpers/reestablecer_contrasenia.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_GET['token']; // Token obtenido de la URL
    $nuevaContrasenia = $_POST['nueva_contrasenia'];
    $confirmarContrasenia = $_POST['confirmar_contrasenia'];

    if ($nuevaContrasenia === $confirmarContrasenia) {
        // Verifica y restablece la contraseña
        if (validarYRestablecerContrasena($token, $nuevaContrasenia)) {
            // Elimina el token de la base de datos
            // Obtenemos la conexión de la base de datos
            $database = new Database();
            $conn = $database->getConnection();  // Obtén la conexión PDO

             // Actualizar el estado del token a 'usado'
             $query = $conn->prepare("UPDATE restablecimiento_tokens SET usado = 1 WHERE token = ?");
             $query->bindValue(1, $token, PDO::PARAM_STR);  // Usamos bindValue en lugar de bind_param
             if ($query->execute()) {
                 echo "Token marcado como utilizado. ";
             } else {
                 echo "Error al marcar el token como utilizado. ";
             }

            /// Eliminar el token de la base de datos
            $query = $conn->prepare("DELETE FROM restablecimiento_tokens WHERE token = ? AND usado = 1");
            $query->bindValue(1, $token, PDO::PARAM_STR);
            if ($query->execute()) {
                echo "Token eliminado correctamente. ";
            } else {
                echo "Error al eliminar el token. ";
            }
            
            echo '<script>
                alert("Tu contraseña ha sido restablecida exitosamente.");
                window.location.href = "../views/login.php";
            </script>';
        } else {
            echo '<script>
                alert("El token es inválido o ha expirado.");
                window.history.back();
            </script>';
        }
    } else {
        echo '<script>
            alert("Las contraseñas no coinciden. Intenta nuevamente.");
            window.history.back();
        </script>';
    }
}
?>

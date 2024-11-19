<?php 
require_once '../includes/Database.php';
require_once '../helpers/restablecer_contrasenia.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_GET['token']; // Token obtenido de la URL
    $nuevaContrasenia = $_POST['nueva_contrasenia'];
    $confirmarContrasenia = $_POST['confirmar_contrasenia'];

    // Verificar si el token existe y si ya ha expirado o fue usado
    $database = new Database();
    $conn = $database->getConnection();  // Obtén la conexión PDO

    // Verificar si el token es válido (existe y no ha sido usado ni expirado)
    $query = $conn->prepare("SELECT * FROM restablecimiento_tokens WHERE token = ? AND (usado = 0) AND fecha_expiracion > NOW()");
    $query->bindValue(1, $token, PDO::PARAM_STR);
    $query->execute();

    $tokenValido = $query->fetch(PDO::FETCH_ASSOC);

    if (!$tokenValido) {
        echo '<script>
                alert("El token ya ha sido utilizado o ha expirado.");
                window.location.href = "/Gestion_clinica/login";
              </script>';
        exit();
    }

    if ($nuevaContrasenia === $confirmarContrasenia) {
        // Verifica y restablece la contraseña
        if (validarYRestablecerContrasena($token, $nuevaContrasenia)) {
            // Actualizar el estado del token a 'usado'
            $query = $conn->prepare("UPDATE restablecimiento_tokens SET usado = 1 WHERE token = ?");
            $query->bindValue(1, $token, PDO::PARAM_STR);
            if ($query->execute()) {
                // Eliminar el token de la base de datos
                $query = $conn->prepare("DELETE FROM restablecimiento_tokens WHERE token = ? AND usado = 1");
                $query->bindValue(1, $token, PDO::PARAM_STR);
                if ($query->execute()) {
                    echo '<script>
                            alert("Tu contraseña ha sido restablecida exitosamente.");
                            window.location.href = "/Gestion_clinica/login";
                          </script>';
                } else {
                    echo '<script>
                            alert("Error al eliminar el token.");
                            window.history.back();
                          </script>';
                }
            } else {
                echo '<script>
                        alert("Error al marcar el token como utilizado.");
                        window.history.back();
                      </script>';
            }
        } else {
            echo '<script>
                    alert("Las contraseñas no coinciden. Intenta nuevamente.");
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

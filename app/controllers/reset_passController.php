<?php
require_once '../includes/Database.php';
require_once '../helpers/restablecer_contrasenia.php';
require_once '../helpers/crear_token.php';

// Manejo de la solicitud desde el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'] ?? '';

    // Verificamos si el correo no está vacío
    if (!empty($correo)) {
        // Generamos el token para el correo
        $token = generarToken($correo);

        if ($token) {
            // Enviamos el enlace de restablecimiento con el token generado
            if (enviarEnlaceRestablecimiento($correo, $token)) {
                echo '<script>
                alert("Hemos enviado un enlace para restablecer tu contraseña. Revisa tu correo.");
                window.location.href = "/Gestion_clinica/login";
                </script>';
            } else {
                echo '<script>
                alert("Hubo un problema al procesar tu solicitud. Intenta nuevamente.");
                window.history.back();
                </script>';
            }
        } else {
            echo '<script>
            alert("El correo no existe en nuestro sistema.");
            window.history.back();
            </script>';
        }
    } else {
        echo '<script>
        alert("El correo ingresado no es válido.");
        window.history.back();
        </script>';
    }
}


?>

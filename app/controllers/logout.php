<?php
session_start();
session_unset(); // Eliminar todas las variables de sesión
session_destroy(); // Destruir la sesión

// Redirigir al inicio principal
header('Location: ../../index.php'); // Cambia a la URL de tu página de inicio principal
exit();
?>

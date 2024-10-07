<?php
// Establecer conexión a la base de datos
include('../includes/Database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del segundo formulario
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $direccion = $_POST['direccion'];
    $sexo = $_POST['sexo'];
    $seguro = $_POST['seguro'];

    // Aquí deberías obtener el ID del usuario o cualquier otra lógica que uses para identificarlo
    // Si estás usando sesiones, asegúrate de comenzar la sesión
    session_start();
    // Suponiendo que guardaste el ID del usuario en la sesión después del primer registro
    $usuario_id = $_SESSION['usuario_id']; // Ajusta según tu lógica

    // Preparar la consulta para insertar los datos adicionales
    $stmt = $pdo->prepare("INSERT INTO detalles_usuarios (usuario_id, fecha_nacimiento, direccion, sexo, seguro) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$usuario_id, $fecha_nacimiento, $direccion, $sexo, $seguro]);

    // Redirigir a una página de éxito o la página principal
    header("Location: ../views/success.php");
    exit();
}
?>

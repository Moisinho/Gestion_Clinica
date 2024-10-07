<?php
// Incluir la clase Database con la ruta correcta
include_once '../includes/Database.php';

// Crear una instancia de la clase Database
$database = new Database();
$conn = $database->getConnection();

// Verificar si la conexión es exitosa
if ($conn) {
    echo "Conexión exitosa a la base de datos.";
} else {
    echo "Error al conectar a la base de datos.";
}
?>

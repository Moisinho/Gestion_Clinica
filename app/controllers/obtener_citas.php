<?php
include '../includes/Database.php'; // Asegúrate de incluir tu archivo de conexión
include '../models/Cita.php'; // Incluye tu modelo de Cita

// Crea una nueva instancia de la base de datos
$database = new Database();
$db = $database->getConnection();

// Crea una nueva instancia de Cita
$cita = new Cita($db);

// Obtiene todas las citas
$citas = $cita->obtener_citas();
?>

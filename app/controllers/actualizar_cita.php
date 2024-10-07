<?php
session_start();
require_once '../includes/Database.php';
require_once '../models/Cita.php';

// Obtener la conexión a la base de datos
$database = new Database();
$conn = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_cita = $_POST['id_cita'];
    $nuevo_estado = $_POST['nuevo_estado'];

    $cita = new Cita($conn);

    if ($cita->actualizarEstado($id_cita, $nuevo_estado)) {
        header('Location: ../views/medico_inicio.php');
    } else {
        echo "<script>alert('Error al actualizar la cita.');</script>";
    }
}


?>

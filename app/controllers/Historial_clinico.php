<?php
session_start();

require_once '../includes/Database.php';
include '../models/Historial.php';

$database = new Database();
$conn = $database->getConnection();
$model = new Historial($conn);

// Get id_paciente from query parameter
$id_paciente = filter_input(INPUT_GET, 'id_paciente', FILTER_SANITIZE_STRING);

if ($id_paciente) {
    $historial = $model->obtenerHistorialPorPaciente($id_paciente);

    if (!empty($historial)) {
        echo json_encode($historial);
    } else {
        echo json_encode(["error" => "No se encontraron registros para el paciente."]);
    }
} else {
    echo json_encode(["error" => "ID del paciente no proporcionado."]);
}
?>

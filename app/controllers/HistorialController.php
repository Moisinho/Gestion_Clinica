<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(["error" => "Usuario no autenticado"]);
    exit();
}

require_once '../includes/Database.php';
include '../models/Historial.php';

$id_usuario = $_SESSION['id_usuario'];
$database = new Database();
$conn = $database->getConnection();
$model = new Historial($conn);

$historial = $model->obtenerHistorialPorUsuario($id_usuario);

if (!empty($historial)) {
    echo json_encode($historial);
} else {
    echo json_encode(["error" => "No se encontraron registros para el usuario."]);
}
?>

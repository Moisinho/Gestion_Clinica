<?php
require_once '../models/ServicioModel.php';

$servicioModel = new ServicioModel($conn);

if ($_GET['action'] == 'obtenerTodos') {
    $servicios = $servicioModel->obtenerServicios();
    echo json_encode($servicios);
    exit();
}
?>

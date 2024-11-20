<?php
require_once '../includes/Database.php';
require_once '../models/Paciente.php';

$database = new Database();
$conn = $database->getConnection();

$paciente = new Paciente($conn);

// PETICIONES POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {

    if ($_POST['action'] == 'registrar') {
        $cedula = $_POST['cedula'];
        $motivo = $_POST['motivo'];
        $id_medico = $_POST['medico'];
        $id_servicio = $_POST['servicio'];
        $fecha_cita = $_POST['fecha_cita'];
    }
}

// PETICIONES GET
elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {

    if ($_GET['action'] == 'obtenerCedulaById' && isset($_GET['id_usuario'])) {
        $id_usuario = $_GET['id_usuario'];
        $cedula_user = $paciente->obtenerCedulaByUserId($id_usuario);
        echo json_encode($cedula_user ? $cedula_user[0] : ['error' => 'No se encontró la cédula']);
    }


}
?>



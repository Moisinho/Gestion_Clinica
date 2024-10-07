<?php

require_once '../includes/Database.php';
require_once '../models/Cita.php';

$database = new Database();
$db = $database->getConnection();

$cedula = $_POST['cedula'];
$motivo = $_POST['motivo'];
$id_medico = $_POST['medico'];
$fecha_cita = $_POST['fecha_cita'];

$cita = new Cita($db);

if ($cita->verificarPaciente($cedula)) {
    $resultado = $cita->registrarCita($cedula, $motivo, $id_medico, $fecha_cita);
    if ($resultado) {
        echo "<script>alert('Cita registrada exitosamente.'); 
        window.location.href='../views/agendar_cita.php';
        </script>";

    } else {
        echo "<script>
        alert('Hubo un error al registrar la cita.');
        </script>";
    }
} else {
    echo "<script>alert('El paciente no está registrado. Por favor, regístrese primero.');</script>";
}

?>

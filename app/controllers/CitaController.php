<?php
require_once '../includes/Database.php';
require_once '../models/Cita.php';

$database = new Database();
$conn = $database->getConnection();

$cita = new Cita($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    // MANEJO DE REGISTRO DE CITA
    if ($_POST['action'] == 'registrar') {
        $cedula = $_POST['cedula'];
        $motivo = $_POST['motivo'];
        $id_medico = $_POST['medico'];
        $fecha_cita = $_POST['fecha_cita'];

        if ($cita->verificarPaciente($cedula)) {
            $resultado = $cita->registrarCita($cedula, $motivo, $id_medico, $fecha_cita);
            if ($resultado) {
                echo "<script>alert('Cita registrada exitosamente.'); 
                window.location.href='../views/agendar_cita.php';
                </script>";
            } else {
                echo "<script>alert('Hubo un error al registrar la cita.');</script>";
            }
        } else {
            echo "<script>alert('El paciente no está registrado. Por favor, regístrese primero.');</script>";
        }
    }
    // MANEJO DE ACTUALIZACION DE CITA
    elseif ($_POST['action'] == 'actualizar') {
        $id_cita = $_POST['id_cita'];
        $nuevo_estado = $_POST['nuevo_estado'];

        if ($cita->actualizarEstado($id_cita, $nuevo_estado)) {
            header('Location: ../views/medico_inicio.php');
        } else {
            echo "<script>alert('Error al actualizar la cita.');</script>";
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {
    // MANEJO DE OBTENCION DE CITAS POR MÉDICO
    if ($_GET['action'] == 'obtenerPorMedico') {
        $id_medico = $_GET['id_medico'];
        $citasMedico = $cita->obtener_citas_medico($id_medico);
        echo json_encode($citasMedico);
        exit();
    }
    // MANEJO DE OBTENCION DE DETALLES DE CITA
    elseif ($_GET['action'] == 'obtenerDetallesCita') {
        $id_cita = $_GET['id_cita'];
        $detallesCita = $cita->obtener_detalles_cita($id_cita);
        echo json_encode($detallesCita);
        exit();
    }

    // MANEJO DE OBTENCION DE TODAS LAS CITAS
    elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $citas = $cita->obtener_citas();
        echo json_encode($citas);
    }
}

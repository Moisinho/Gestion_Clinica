<?php
session_start();
$id_usuario = $_GET['id_usuario'] ?? $_SESSION['id_usuario'] ?? null; // Prioriza GET sobre sesión

require_once '../includes/Database.php';
require_once '../models/Cita.php';
require_once '../models/Medico.php';
require_once '../models/ServicioModel.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$database = new Database();
$conn = $database->getConnection();

$cita = new Cita($conn);
$servicioModel = new ServicioModel($conn);
$medicoModel = new Medico($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    // MANEJO DE REGISTRO DE CITA
    if ($_POST['action'] == 'registrar') {
        $cedula = $_POST['cedula'];
        $motivo = $_POST['motivo'];
        $id_medico = $_POST['medico'];
        $id_servicio = $_POST['servicio'];
        $fecha_cita = $_POST['fecha_cita'];

        if ($cita->verificarPaciente($cedula)) {
            $resultado = $cita->registrarCita($cedula, $motivo, $id_medico, $id_servicio, $fecha_cita);
            if ($resultado) {
                echo "<script>alert('Cita registrada exitosamente.');
                window.location.href='/Gestion_clinica/agendar_cita';
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
            echo json_encode(['success' => true, 'message' => 'Cita actualizada exitosamente.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar la cita.']);
        }
        exit();
    }
}

// PETICIONES GET
elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {
    // MANEJO DE OBTENCION DE CITAS POR MÉDICO
    if ($_GET['action'] == 'obtenerPorMedico' && $id_usuario !== null) {
        $citasMedico = $cita->obtener_citas_medico($id_usuario);
        if (empty($citasMedico)) {
            error_log("No se encontraron citas para el médico con ID de usuario: $id_usuario");
        } else {
            error_log("Citas encontradas: " . json_encode($citasMedico));
        }
        echo json_encode($citasMedico);
        exit();

    }
    //OBTENER DETALLES DE CITAS PARA EL MODAL DE RECEPCIONISTA
    elseif ($_GET['action'] == 'obtenerDetallesCita' && isset($_GET['id_cita'])) {
        $id_cita = $_GET['id_cita'];
        $detallesCita = $cita->obtener_detalles_cita($id_cita);
        
        // Verificar si se obtuvieron detalles
        if ($detallesCita) {
            echo json_encode($detallesCita);
        } else {
            echo json_encode(['error' => 'No se encontraron detalles para esta cita.']);
        }
        exit();
    }

    // MANEJO DE OBTENCION DE TODAS LAS CITAS
    elseif ($_GET['action'] == 'obtenerCitas') {
        $citas = $cita->obtener_citas();
        echo json_encode($citas);
        exit();
    }

    // MANEJO PARA LA CANTIDAD DE CITAS PROGRAMADAS
    elseif ($_GET['action'] == 'cantidadCitasProgramadas') {
        $cantidad = $cita->obtenerCantidadCitas();
        echo json_encode(['success' => true, 'message' => $cantidad]);
        exit();
    }

    if ($_GET['action'] == 'obtenerServicios') {
        $servicios = $servicioModel->obtenerServicios();
        echo json_encode($servicios);
        exit();
    }
    
    elseif ($_GET['action'] == 'obtenerMedicos') {
        $medicos = $medicoModel->obtenerMedicos();
        echo json_encode($medicos);
        exit();
    }

    // OBTENER CITAS POR PACIENTE
    elseif ($_GET['action'] === 'obtenerPorPaciente' && $id_usuario !== null) {
        $citas = $cita->obtenerCitasPorPaciente($id_usuario); // Aquí usamos la instancia de Cita ya creada

        header('Content-Type: application/json');
        echo json_encode($citas);
        exit();
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Solicitud no válida.']);
        exit();
    }
    
}
?>



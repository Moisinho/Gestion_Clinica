<?php
require_once '../includes/Database.php';
require_once '../models/Medico.php';

$database = new Database();
$conn = $database->getConnection();
$medico = new Medico($conn);

// Verificar el método de solicitud
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {

    // AGREGAR MÉDICO
    if ($_POST['action'] == 'agregar') {
        $nombre_medico = $_POST['nombre_medico'];

        if ($medico->agregarMedico($nombre_medico)) {
            echo json_encode(['success' => true, 'message' => 'Médico agregado exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al agregar el médico']);
        }
    }

    // ACTUALIZAR MÉDICO
    elseif ($_POST['action'] == 'actualizar') {
        $id_medico = $_POST['id_medico'];
        $nombre_medico = $_POST['nombre_medico'];

        if ($medico->actualizarMedico($id_medico, $nombre_medico)) {
            echo json_encode(['success' => true, 'message' => 'Médico actualizado exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar el médico']);
        }
    }

    // BORRAR MÉDICO
    elseif ($_POST['action'] == 'borrar') {
        $id_medico = $_POST['id_medico'];

        if ($medico->borrarMedico($id_medico)) {
            echo json_encode(['success' => true, 'message' => 'Médico eliminado exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar el médico']);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {

    // OBTENER TODOS LOS MÉDICOS
    if ($_GET['action'] == 'obtenerTodos') {
        $medicos = $medico->obtenerMedicos();
        echo json_encode($medicos);

        // OBTENER MÉDICO POR ID
    } elseif ($_GET['action'] == 'obtenerPorId') {
        $id_medico = $_GET['id_medico'];
        $medicoData = $medico->obtenerMedicoPorId($id_medico);

        if ($medicoData) {
            echo json_encode(['success' => true, 'data' => $medicoData]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se encontró el médico']);
        }
    }

    // OBTENER MÉDICO POR SERVICIO
    elseif ($_GET['action'] == 'obtenerMedicosPorServicio') {
        $id_servicio = $_GET['id_servicio'];  // Obtener el id_servicio desde la solicitud GET
        $medicos = $medico->obtenerMedicosPorServicio($id_servicio);  // Llamar a la función en el modelo

        if ($medicos) {
            echo json_encode(['success' => true, 'data' => $medicos]);  // Devolver los médicos en formato JSON
        } else {
            echo json_encode(['success' => false, 'message' => 'No se encontraron médicos para este servicio']);
        }
    } elseif ($_GET['action'] == 'obtenerMedicoPorUsuario') {
        $id_usuario = $_GET['id_usuario'];
        $medicoData = $medico->obtenerMedicoPorUsuario($id_usuario);  // Llamar a la función en el modelo

        if ($medicoData) {
            echo json_encode($medicoData);  // Devolver los médicos en formato JSON
        } else {
            echo json_encode(['success' => false, 'message' => 'No se encontraron médicos para este servicio']);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Solicitud no válida']);
}

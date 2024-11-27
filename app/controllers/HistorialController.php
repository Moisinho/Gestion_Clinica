<?php
session_start();

require_once '../includes/Database.php';
require_once '../models/Historial.php';

// Inicializar base de datos y modelo
$database = new Database();
$conn = $database->getConnection();
$historialModel = new Historial($conn);

// Validar método de solicitud y acción
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'agregar') {
        echo ("Metodo cambiado a GestionController");
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'obtenerPorUsuario':
                obtenerHistorialPorUsuario($_GET, $historialModel);
                break;
            case 'obtenerPorCedula':
                obtenerHistorialPorCedula($_GET, $historialModel);
                break;
            case 'verificarCitaMedicinaGeneral':
                verificarCitaMedicinaGeneral($_GET, $historialModel);
                break;
            default:
                echo json_encode(['error' => 'Acción no válida']);
                exit();
        }
    }
} else {
    echo json_encode(['error' => 'Método no permitido']);
    exit();
}

// Funciones para manejar acciones específicas
function obtenerHistorialPorUsuario($params, $historialModel)
{
    $user = htmlspecialchars(strip_tags($params['usuario']));
    $historial = $historialModel->obtenerHistorialPorUsuario($user);

    if ($historial['success']) {
        echo json_encode($historial);
    } else {
        echo json_encode(["success" => false, "message" => "Aún no cuentas con historial médico."]);
    }
    exit();
}

function obtenerHistorialPorCedula($params, $historialModel)
{
    $cedula = htmlspecialchars(strip_tags($params['cedula']));
    if (empty($cedula)) {
        echo json_encode(["success" => false, "message" => "La cédula es requerida"]);
        exit();
    }

    $historial = $historialModel->obtenerHistorialPorCedula($cedula);

    if ($historial['success']) {
        echo json_encode([
            'success' => true,
            'paciente' => $historial['paciente'],
            'historial' => $historial['historial']
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "El paciente aún no cuenta con historial."]);
    }
    exit();
}

function verificarCitaMedicinaGeneral($params, $historialModel)
{
    $cedula = $params['cedula'];

    try {
        $resultado = $historialModel->verificarCitaMedicinaGeneral($cedula);

        if ($resultado['tiene_cita_medicina_general']) {
            echo json_encode([
                'success' => true,
                'mensaje' => 'El usuario ya tiene una cita de Medicina General.',
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'mensaje' => 'El usuario no tiene historial de Medicina General.',
            ]);
        }
    } catch (PDOException $e) {
        error_log("Error en verificarCitaMedicinaGeneral: " . $e->getMessage());
        echo json_encode(['error' => 'Error al verificar el historial.']);
    }
    exit();
}

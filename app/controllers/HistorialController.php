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
        agregarHistorial($_POST, $historialModel, $conn);
    } elseif (isset($_POST['accion']) && $_POST['accion'] === 'ver') {
        verHistorial($_POST);
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
function agregarHistorial($data, $historialModel, $conn)
{
    $data = [
        "cedula" => $data['cedula'] ?? '',
        "id_cita" => $data['id_cita'] ?? '',
        "id_medico" => $data['id_medico'] ?? '',
        "peso" => $data['peso'],
        "altura" => $data['altura'],
        "presion_arterial" => $data['presion_arterial'],
        "frecuencia_cardiaca" => $data['frecuencia_cardiaca'],
        "tipo_sangre" => $data['tipo_sangre'],
        "antecedentes_patologicos" => is_array($data['antecedentes_personales'])
            ? implode(", ", $data['antecedentes_personales'])
            : $data['antecedentes_personales'],
        "otros_antecedentes_patologicos" => $data['otros_antecedentes'] ?? '',
        "antecedentes_no_patologicos" => is_array($data['antecedentes_no_patologicos'])
            ? implode(", ", $data['antecedentes_no_patologicos'])
            : $data['antecedentes_no_patologicos'],
        "otros_antecedentes_no_patologicos" => $data['otros_antecedentes_no_patologicos'] ?? '',
        "condicion_general" => $data['condicion_general'],
        "examenes_sangre" => $data['examenes_sangre'],
        "laboratorios" => $data['laboratorios'],
        "diagnostico" => $data['diagnostico'],
        "tratamiento" => $data['tratamiento'],
        "id_departamento_referencia" => $data['id_departamento_referencia'] ?? null
    ];

    if ($historialModel->agregarHistorial($data)) {
        $id_cita = $conn->lastInsertId();

        if (isset($data['medicamento'], $data['dosis'], $data['frecuencia'], $data['duracion'])) {
            $recetas = [];
            foreach ($data['medicamento'] as $index => $medicamento) {
                $recetas[] = [
                    'medicamento' => $medicamento,
                    'dosis' => $data['dosis'][$index],
                    'frecuencia' => $data['frecuencia'][$index],
                    'duracion' => $data['duracion'][$index]
                ];
            }
            $historialModel->agregarRecetas($id_cita, $recetas);
        }

        echo json_encode(['success' => true, 'message' => 'Historial médico y receta guardados con éxito']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al guardar el historial médico']);
    }
    exit();
}

function obtenerHistorialPorUsuario($params, $historialModel)
{
    $user = htmlspecialchars(strip_tags($params['usuario']));
    $historial = $historialModel->obtenerHistorialPorUsuario($user);

    if (!empty($historial)) {
        echo json_encode($historial);
    } else {
        echo json_encode(["success" => false, "message" => "Aún noo cuentas con historial médico."]);
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

    if (!empty($historial)) {
        echo json_encode(['success' => true, 'data' => $historial]);
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


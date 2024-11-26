<?php
session_start();

require_once '../includes/Database.php';
require_once '../models/Historial.php';
require_once '../models/Cita.php';

// Validar sesión (descomentarlo si es necesario)
// if (!isset($_SESSION['id_usuario'])) {
//     echo json_encode(["success" => false, "message" => "Usuario no autenticado"]);
//     exit();
// }

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);

if ($input === null) {
    echo json_encode(['success' => false, 'message' => 'Error al decodificar el JSON enviado.']);
    exit();
}


// Conexión a la base de datos
$database = new Database();
$conn = $database->getConnection();
$historialModel = new Historial($conn);
$citaModel = new Cita($conn);

// Validar si 'action' está definida y centralizar su manejo
$action = $input['action'];

if (!$action) {
    echo json_encode(['success' => false, 'message' => 'Acción no especificada']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($action) {
        case 'agregar':
            $data = [
                "cedula" => $input['cedula'] ?? '',
                "id_cita" => $input['id_cita'] ?? '',
                "id_medico" => $input['id_medico'] ?? '',
                "peso" => $input['peso'],
                "altura" => $input['altura'],
                "presion_arterial" => $input['presion_arterial'],
                "frecuencia_cardiaca" => $input['frecuencia_cardiaca'],
                "tipo_sangre" => $input['tipo_sangre'],
                "antecedentes_patologicos" => is_array($input['antecedentes_patologicos'])
                    ? implode(", ", $input['antecedentes_patologicos'])
                    : $input['antecedentes_patologicos'],
                "otros_antecedentes_patologicos" => $input['otros_antecedentes_patologicos'] ?? '',
                "antecedentes_no_patologicos" => is_array($input['antecedentes_no_patologicos'])
                    ? implode(", ", $input['antecedentes_no_patologicos'])
                    : $input['antecedentes_no_patologicos'],
                "otros_antecedentes_no_patologicos" => $input['otros_antecedentes_no_patologicos'] ?? '',
                "condicion_general" => $input['condicion_general'],
                "examenes_sangre" => $input['examenes_sangre'],
                "laboratorios" => $input['laboratorios'],
                "diagnostico" => $input['diagnostico'],
                "tratamiento" => $input['tratamiento'],
                "id_departamento_referencia" => $input['id_departamento_referencia'] ?? null
            ];

            // Guardar historial médico
            if ($historialModel->agregarHistorial($data)) {
                // Guardar la referencia si se proporciona un departamento de referencia
                if (isset($input['id_departamento_referencia'])) {
                    if (!$historialModel->agregarReferencia($input['cedula'], $input['id_departamento_referencia'], $input['id_medico'])) {
                        echo json_encode(['success' => false, 'message' => 'Error al guardar la referencia']);
                        exit();
                    }
                }

                if ($citaModel->actualizarEstado($input['id_cita'], 'Atendida')) {
                    echo json_encode(['success' => true, 'message' => 'Historial médico guardado y cita marcada como atendida']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al actualizar el estado de la cita']);
                }

                // Guardar recetas si se proporcionaron
                if (isset($input['medicamento'], $input['dosis'], $input['frecuencia'], $input['duracion'])) {
                    $recetas = [];
                    foreach ($input['medicamento'] as $index => $medicamento) {
                        $recetas[] = [
                            'medicamento' => $medicamento,
                            'dosis' => $input['dosis'][$index],
                            'frecuencia' => $input['frecuencia'][$index],
                            'duracion' => $input['duracion'][$index]
                        ];
                    }
                    if (!$historialModel->agregarRecetas($data['id_cita'], $recetas)) {
                        echo json_encode(['success' => false, 'message' => 'Error al guardar las recetas']);
                        exit();
                    }
                }

                echo json_encode(['success' => true, 'message' => 'Historial médico guardado con éxito']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al guardar el historial médico']);
            }
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Acción POST no válida']);
            break;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método HTTP no soportado']);
}

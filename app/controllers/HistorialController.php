<?php
session_start();
//BORRAR ---------------------------------------------------------
$_SESSION['id_usuario'] = 12;
//-----------------------------------------------------------------
if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(["success" => false, "message" => "Usuario no autenticado"]);
    exit();
}

require_once '../includes/Database.php';
require_once '../models/Historial.php';

$database = new Database();
$conn = $database->getConnection();
$historialModel = new Historial($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    // AGREGAR HISTORIAL
    if ($_POST['action'] == 'agregar') {
        $data = [
            "cedula" => $_POST['cedula'] ?? '',
            "id_cita" => $_POST['id_cita'] ?? '',
            "id_medico" => $_POST['id_medico'] ?? '',
            "peso" => $_POST['peso'],
            "altura" => $_POST['altura'],
            "presion_arterial" => $_POST['presion_arterial'],
            "frecuencia_cardiaca" => $_POST['frecuencia_cardiaca'],
            "tipo_sangre" => $_POST['tipo_sangre'],
            "antecedentes_patologicos" => is_array($_POST['antecedentes_patologicos'])
                ? implode(", ", $_POST['antecedentes_patologicos'])
                : $_POST['antecedentes_patologicos'],

            "otros_antecedentes_patologicos" => $_POST['otros_antecedentes_patologicos'] ?? '',

            "antecedentes_no_patologicos" => is_array($_POST['antecedentes_no_patologicos'])
                ? implode(", ", $_POST['antecedentes_no_patologicos'])
                : $_POST['antecedentes_no_patologicos'],
            "otros_antecedentes_no_patologicos" => $_POST['otros_antecedentes_no_patologicos'] ?? '',
            "condicion_general" => $_POST['condicion_general'],
            "examenes_sangre" => $_POST['examenes_sangre'],
            "laboratorios" => $_POST['laboratorios'],
            "diagnostico" => $_POST['diagnostico'],
            "recomendaciones" => $_POST['recomendaciones'],
            "tratamiento" => $_POST['tratamiento'],
            "id_departamento_referencia" => $_POST['id_departamento_referencia'] ?? null
        ];

        if ($historialModel->agregarHistorial($data)) {
            $id_cita = $conn->lastInsertId();

            // Agregar recetas si existen
            if (isset($_POST['medicamento'], $_POST['dosis'], $_POST['frecuencia'], $_POST['duracion'])) {
                $recetas = [];
                foreach ($_POST['medicamento'] as $index => $medicamento) {
                    $recetas[] = [
                        'medicamento' => $medicamento,
                        'dosis' => $_POST['dosis'][$index],
                        'frecuencia' => $_POST['frecuencia'][$index],
                        'duracion' => $_POST['duracion'][$index]
                    ];
                }

                $historialModel->agregarRecetas($id_cita, $recetas);
            }

            echo json_encode(['success' => true, 'message' => 'Historial médico y receta guardados con éxito']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al guardar el historial médico']);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {

    // OBTENER HISTORIAL POR USUARIO
    if ($_GET['action'] == 'obtenerPorUsuario') {
        $id_usuario = $_SESSION['id_usuario'];

        $historial = $historialModel->obtenerHistorialPorUsuario($id_usuario);

        if (!empty($historial)) {
            echo json_encode($historial);
        } else {
            echo json_encode(["success" => false, "message" => "No se encontraron registros para el usuario"]);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Solicitud no válida']);
}

<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(["error" => "Usuario no autenticado"]);
    exit();
}

require_once '../includes/Database.php';
require_once '../models/Historial.php';

$database = new Database();
$conn = $database->getConnection();
$model = new Historial($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        "cedula" => $_POST['cedula'] ?? '',
        "id_cita" => $_POST['id_cita'] ?? '',
        "id_medico" => $_POST['id_medico'] ?? '',
        "peso" => $_POST['peso'],
        "altura" => $_POST['altura'],
        "presion_arterial" => $_POST['presion_arterial'],
        "frecuencia_cardiaca" => $_POST['frecuencia_cardiaca'],
        "tipo_sangre" => $_POST['tipo_sangre'],
        "antecedentes_patologicos" => implode(", ", $_POST['antecedentes_patologicos'] ?? []),
        "otros_antecedentes_patologicos" => $_POST['otros_antecedentes_patologicos'] ?? '',
        "antecedentes_no_patologicos" => implode(", ", $_POST['antecedentes_no_patologicos'] ?? []),
        "otros_antecedentes_no_patologicos" => $_POST['otros_antecedentes_no_patologicos'] ?? '',
        "condicion_general" => $_POST['condicion_general'],
        "examenes_sangre" => $_POST['examenes_sangre'],
        "laboratorios" => $_POST['laboratorios'],
        "diagnostico" => $_POST['diagnostico'],
        "recomendaciones" => $_POST['recomendaciones'],
        "tratamiento" => $_POST['tratamiento']
    ];

    // Insertar historial
    if ($model->agregarHistorial($data)) {
        $id_cita = $conn->lastInsertId();

        // Insertar receta
        if (isset($_POST['medicamento']) && isset($_POST['dosis']) && isset($_POST['frecuencia']) && isset($_POST['duracion'])) {
            $recetas = [];
            foreach ($_POST['medicamento'] as $index => $medicamento) {
                $recetas[] = [
                    'medicamento' => $medicamento,
                    'dosis' => $_POST['dosis'][$index],
                    'frecuencia' => $_POST['frecuencia'][$index],
                    'duracion' => $_POST['duracion'][$index]
                ];
            }

            $model->agregarRecetas($id_cita, $recetas);
        }

        echo json_encode(["success" => "Historial médico y receta guardados con éxito."]);
    } else {
        echo json_encode(["error" => "Error al guardar el historial médico."]);
    }
} else {
    $id_usuario = $_SESSION['id_usuario'];
    $historial = $model->obtenerHistorialPorUsuario($id_usuario);

    if (!empty($historial)) {
        echo json_encode($historial);
    } else {
        echo json_encode(["error" => "No se encontraron registros para el usuario."]);
    }
}

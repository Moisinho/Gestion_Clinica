<?php
session_start();

// if (!isset($_SESSION['id_usuario'])) {
//     echo json_encode(["success" => false, "message" => "Usuario no autenticado"]);
//     exit();
// }

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

            $recetasGuardadas = true;
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

                $recetasGuardadas = $historialModel->agregarRecetas($id_cita, $recetas);
            }


            echo json_encode(['success' => true, 'message' => 'Historial médico y receta guardados con éxito']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al guardar el historial médico']);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {

    // OBTENER HISTORIAL POR USUARIO
    if ($_GET['action'] == 'obtenerPorUsuario' && isset($_GET['usuario'])) {
        $user = htmlspecialchars(strip_tags($_GET['usuario']));
        $historial = $historialModel->obtenerHistorialPorUsuario($user);

        if (!empty($historial)) {
            echo json_encode($historial);
        } else {
            echo json_encode(["success" => false, "message" => "No se encontraron registros para el usuario"]);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Solicitud no válida']);
}

if ($_GET['action'] == 'obtenerPorCedula' && isset($_GET['cedula'])) {
    $cedula = htmlspecialchars(strip_tags($_GET['cedula']));

    if (empty($cedula)) {
        echo json_encode(["success" => false, "message" => "La cédula es requerida"]);
        exit();
    }

    $historial = $historialModel->obtenerHistorialPorCedula($cedula);

    if (!empty($historial)) {
        echo json_encode(['success' => true, 'data' => $historial]); // Devuelve todos los registros
    } else {
        echo json_encode(["success" => false, "message" => "No se encontraron registros para la cédula proporcionada"]);
    }
}

if ($_GET['action'] === 'verificarCitaMedicinaGeneral' && isset($_GET['cedula'])) {
    $cedula = $_GET['cedula'];

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
} else {
    echo json_encode(['error' => 'Acción no válida o datos incompletos.']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = filter_input(INPUT_POST, 'accion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if ($accion === 'ver') {
        $cedula = filter_input(INPUT_POST, 'cedula', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id_cita = filter_input(INPUT_POST, 'id_cita', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!empty($cedula) || !empty($id_cita)) {
            $database = new Database();
            $db = $database->getConnection();

            // Consulta para obtener el historial usando cédula o id_cita
            $sql = "
            SELECT
                hm.*,
                m.nombre_medico,
                p.nombre_paciente,
                p.cedula,
                p.fecha_nacimiento,
                p.telefono,
                p.correo_paciente
            FROM
                historial_medico hm
            JOIN
                medico m ON hm.id_medico = m.id_medico
            JOIN
                paciente p ON hm.cedula = p.cedula
            WHERE
                hm.cedula = :cedula OR hm.id_cita = :id_cita";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);
            $stmt->bindParam(':id_cita', $id_cita, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $historial = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Serializar los datos y enviarlos mediante POST a historial_clinico.php
                echo '<form id="form_historial" action="/Gestion_clinica/historial_medico" method="POST">';
                foreach ($historial as $registro) {
                    echo '<input type="hidden" name="historial[]" value="' . htmlspecialchars(json_encode($registro)) . '">';
                }
                echo '</form>';
                echo '<script>document.getElementById("form_historial").submit();</script>';
                exit();
            } else {
                echo "<p>No se encontró ningún historial para la cédula o ID de cita proporcionados.</p>";
            }
        } else {
            echo "<p>Error: Cédula o ID de cita no válidos.</p>";
        }
    }
}

<?php
header("Content-Type: application/json");

require_once '../controllers/PacienteHospitalizadoController.php'; // Controlador de paciente hospitalizado
require_once '../controllers/CamaController.php';               // Controlador de cama
require_once '../controllers/HabitacionController.php';         // Controlador de habitación
require_once '../includes/Database.php';

// Obtener el recurso desde la URL
$resource = isset($_GET['resource']) ? $_GET['resource'] : null;

// Verificar el método HTTP
$method = $_SERVER['REQUEST_METHOD'];

// Parsear el cuerpo de la solicitud para las peticiones PUT, POST y PATCH
$inputData = json_decode(file_get_contents('php://input'), true);

// Instanciar el controlador correspondiente
$controller = null;

switch ($resource) {
    case 'paciente_hospitalizado':
        $controller = new PacienteHospitalizadoController();
        break;
    
    case 'cama':
        $controller = new CamaController();
        break;
    
    case 'habitacion':
        $controller = new HabitacionController();
        break;
    
    default:
        echo json_encode(["message" => "Recurso no encontrado"]);
        exit();
}

// Acciones según el método HTTP
switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Obtener el recurso específico
            $id = $_GET['id'];
            if ($resource == 'paciente_hospitalizado') {
                $data = $controller->getPacienteHospitalizado($id);
            } elseif ($resource == 'cama') {
                $data = $controller->getCama($id);
            } elseif ($resource == 'habitacion') {
                $data = $controller->getHabitacion($id);
            }
            echo json_encode($data ?: ["message" => ucfirst($resource) . " no encontrado"]);
        } else {
            // Obtener todos los recursos
            if ($resource == 'paciente_hospitalizado') {
                $data = $controller->getAllPacientesHospitalizados();
            } elseif ($resource == 'cama') {
                $data = $controller->getAllCamas();
            } elseif ($resource == 'habitacion') {
                $data = $controller->getAllHabitaciones();
            }
            echo json_encode($data);
        }
        break;

    case 'POST':
        // Crear un nuevo recurso
        if ($resource == 'paciente_hospitalizado' && isset($inputData['cedula'], $inputData['id_cama'], $inputData['id_medico'], $inputData['fecha_ingreso'], $inputData['motivo'])) {
            $result = $controller->createPacienteHospitalizado($inputData);
            echo json_encode(["message" => $result ? "Paciente hospitalizado creado" : "Error al crear paciente hospitalizado"]);
        } elseif ($resource == 'cama' && isset($inputData['estado'], $inputData['id_habitacion'], $inputData['tipo_cama'])) {
            $result = $controller->createCama($inputData);
            echo json_encode(["message" => $result ? "Cama creada" : "Error al crear cama"]);
        } elseif ($resource == 'habitacion' && isset($inputData['capacidad_disponible'], $inputData['ubicacion'], $inputData['tipo'])) {
            $result = $controller->createHabitacion($inputData);
            echo json_encode(["message" => $result ? "Habitación creada" : "Error al crear habitación"]);
        } else {
            echo json_encode(["message" => "Datos inválidos"]);
        }
        break;

        case 'PUT':
            // Actualizar un recurso
            if ($resource == 'paciente_hospitalizado' && isset($_GET['cedula'])) {
                $cedula = $_GET['cedula'];
                if (isset($inputData['id_cama'], $inputData['id_medico'], $inputData['fecha_egreso'], $inputData['motivo'], $inputData['estado_pacienteH'])) {
                    $result = $controller->updatePacienteHospitalizado($cedula, $inputData);
                    echo json_encode(["message" => $result ? "Paciente hospitalizado actualizado" : "Error al actualizar paciente hospitalizado"]);
                } else {
                    echo json_encode(["message" => "Datos inválidos para actualizar paciente hospitalizado"]);
                }
            } elseif ($resource == 'cama' && isset($_GET['id_cama'])) {
                $id_cama = $_GET['id_cama'];
                if (isset($inputData['estado'], $inputData['id_habitacion'], $inputData['tipo_cama'])) {
                    $result = $controller->updateCama($id_cama, $inputData);
                    echo json_encode(["message" => $result ? "Cama actualizada" : "Error al actualizar cama"]);
                } else {
                    echo json_encode(["message" => "Datos inválidos para actualizar cama"]);
                }
            } elseif ($resource == 'habitacion' && isset($_GET['id_habitacion'])) {
                $id_habitacion = $_GET['id_habitacion'];
                if (isset($inputData['capacidad_disponible'], $inputData['tipo'])) {
                    $result = $controller->updateHabitacion($id_habitacion, $inputData);
                    echo json_encode(["message" => $result ? "Habitación actualizada" : "Error al actualizar habitación"]);
                } else {
                    echo json_encode(["message" => "Datos inválidos para actualizar habitación"]);
                }
            } else {
                echo json_encode(["message" => "Datos inválidos o identificador no proporcionado"]);
            }
            break;

    case 'PATCH':
        // Actualizar parcialmente un recurso
        if ($resource == 'paciente_hospitalizado' && isset($_GET['cedula'])) {
            $cedula = $_GET['cedula'];
            $result = $controller->patchPacienteHospitalizado($cedula, $inputData);
            echo json_encode(["message" => $result ? "Paciente hospitalizado actualizado parcialmente" : "Error al actualizar parcialmente"]);
        } elseif ($resource == 'cama' && isset($_GET['id_cama'])) {
            $id_cama = $_GET['id_cama'];
            $result = $controller->patchCama($id_cama, $inputData);
            echo json_encode(["message" => $result ? "Cama actualizada parcialmente" : "Error al actualizar parcialmente"]);
        } elseif ($resource == 'habitacion' && isset($_GET['id_habitacion'])) {
            $id_habitacion = $_GET['id_habitacion'];
            $result = $controller->patchHabitacion($id_habitacion, $inputData);
            echo json_encode(["message" => $result ? "Habitación actualizada parcialmente" : "Error al actualizar parcialmente"]);
        } else {
            echo json_encode(["message" => "Datos inválidos o identificador no proporcionado"]);
        }
        break;
        

    case 'DELETE':
        // Eliminar un recurso
        if ($resource == 'paciente_hospitalizado' && isset($_GET['cedula'])) {
            $cedula = $_GET['cedula'];
            $result = $controller->deletePacienteHospitalizado($cedula);
            echo json_encode(["message" => $result ? "Paciente hospitalizado eliminado" : "Error al eliminar paciente hospitalizado"]);
        } elseif ($resource == 'cama' && isset($_GET['id_cama'])) {
            $id_cama = $_GET['id_cama'];
            $result = $controller->deleteCama($id_cama);
            echo json_encode(["message" => $result ? "Cama eliminada" : "Error al eliminar cama"]);
        } elseif ($resource == 'habitacion' && isset($_GET['id_habitacion'])) {
            $id_habitacion = $_GET['id_habitacion'];
            $result = $controller->deleteHabitacion($id_habitacion);
            echo json_encode(["message" => $result ? "Habitación eliminada" : "Error al eliminar habitación"]);
        } else {
            echo json_encode(["message" => "Datos inválidos o identificador no proporcionado"]);
        }
        break;
    
    default:
        echo json_encode(["message" => "Método no permitido"]);
        break;
}
?>





<?php
require_once '../includes/Database.php';
require_once '../models/ServicioModel.php';

$database = new Database();
$conn = $database->getConnection();
$servicioModel = new ServicioModel($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {

    // AGREGAR SERVICIO
    if ($_POST['action'] == 'agregar') {
        $nombre_servicio = $_POST['nombre_servicio'];
        $descripcion = $_POST['descripcion'];
        $costo = $_POST['costo'];

        if ($servicioModel->agregarServicio($nombre_servicio, $descripcion, $costo)) {
            echo json_encode(['success' => true, 'message' => 'Servicio agregado exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al agregar el servicio']);
        }
    }

    // ACTUALIZAR SERVICIO
    elseif ($_POST['action'] == 'actualizar') {
        $id_servicio = $_POST['id_servicio'];
        $nombre_servicio = $_POST['nombre_servicio'];
        $descripcion = $_POST['descripcion'];
        $costo = $_POST['costo'];

        if ($servicioModel->actualizarServicio($id_servicio, $nombre_servicio, $descripcion, $costo)) {
            echo json_encode(['success' => true, 'message' => 'Servicio actualizado exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar el servicio']);
        }
    }

    // BORRAR SERVICIO
    elseif ($_POST['action'] == 'borrar') {
        $id_servicio = $_POST['id_servicio'];

        if ($servicioModel->borrarServicio($id_servicio)) {
            echo json_encode(['success' => true, 'message' => 'Servicio eliminado exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar el servicio']);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {

    // OBTENER TODOS LOS SERVICIOS
    if ($_GET['action'] == 'obtenerTodos') {
        $servicios = $servicioModel->obtenerServicios();
        echo json_encode($servicios);
    }

    // OBTENER SERVICIO POR USUARIO
    elseif ($_GET['action'] == 'obtenerServiciosPorUsuario') {
        $cedula = $_GET['cedula'];
        $servicioData = $servicioModel->obtenerServiciosPorUsuario($cedula);

        if ($servicioData) {
            echo json_encode(['success' => true, 'data' => $servicioData]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se encontró el servicio']);
        }
    }

    // OBTENER SERVICIO POR ID
    elseif ($_GET['action'] == 'obtenerPorId') {
        $id_servicio = $_GET['id_servicio'];
        $servicioData = $servicioModel->obtenerServicioPorId($id_servicio);

        if ($servicioData) {
            echo json_encode(['success' => true, 'data' => $servicioData]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se encontró el servicio']);
        }
    }

    // OBTENER MONTO POR ID_CITA
    elseif ($_GET['action'] == 'obtenerMonto' && isset($_GET['id_cita'])) {
        $id_cita = $_GET['id_cita'];
        $resultado = $servicioModel->obtenerMonto($id_cita);

        if ($resultado) {
            echo json_encode(['success' => true, 'monto' => $resultado['costo']]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se encontró el monto para la cita especificada']);
        }
    }

    // OBTENER SERVICIOS EXCLUYENDO "Cita Medicina General"
    else if ($_GET['action'] == 'obtenerServiciosSinMedicinaGeneral' && isset($_GET['excluir'])) {
        $excluir = $_GET['excluir'];
        $servicios = $servicioModel->obtenerServiciosSinMedicinaGeneral($excluir);

        if ($servicios) {
            echo json_encode($servicios);  // Devuelve los datos en formato JSON
        } else {
            echo json_encode(['success' => false, 'message' => 'No se encontraron servicios']);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Solicitud no válida']);
}

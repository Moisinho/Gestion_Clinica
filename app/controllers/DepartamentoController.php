<?php
require_once '../includes/Database.php';
require_once '../models/Departamento.php';

$database = new Database();
$conn = $database->getConnection();
$departamentoModel = new Departamento($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {

    // AGREGAR DEPARTAMENTO
    if ($_POST['action'] == 'agregar') {
        $nombre_departamento = $_POST['nombre_departamento'];
        $descripcion = $_POST['descripcion'];

        if ($departamentoModel->crear($nombre_departamento, $descripcion)) {
            echo json_encode(['success' => true, 'message' => 'Departamento agregado exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al agregar el departamento']);
        }
    }

    // ACTUALIZAR DEPARTAMENTO
    elseif ($_POST['action'] == 'actualizar') {
        $id_departamento = $_POST['id_departamento'];
        $nombre_departamento = $_POST['nombre_departamento'];
        $descripcion = $_POST['descripcion'];

        if ($departamentoModel->actualizar($id_departamento, $nombre_departamento, $descripcion)) {
            echo json_encode(['success' => true, 'message' => 'Departamento actualizado exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar el departamento']);
        }
    }

    // BORRAR DEPARTAMENTO
    elseif ($_POST['action'] == 'borrar') {
        $id_departamento = $_POST['id_departamento'];

        if ($departamentoModel->eliminar($id_departamento)) {
            echo json_encode(['success' => true, 'message' => 'Departamento eliminado exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar el departamento']);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {

    // OBTENER TODOS LOS DEPARTAMENTOS
    if ($_GET['action'] == 'obtenerTodos') {
        $departamentos = $departamentoModel->obtenerTodos();
        echo json_encode($departamentos);
    }

    // OBTENER DEPARTAMENTO POR ID
    elseif ($_GET['action'] == 'obtenerPorId') {
        $id_departamento = $_GET['id_departamento'];
        $departamentoData = $departamentoModel->obtenerPorId($id_departamento);

        if ($departamentoData) {
            echo json_encode($departamentoData);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se encontró el departamento']);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Solicitud no válida']);
}

<?php
require_once __DIR__ . '/../models/Farmacia.php';
require_once __DIR__ . '/../includes/Database.php';

class FarmaciaController {
    private $model;
    private $db;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection(); // Obtiene la conexión
        $this->model = new Farmacia($this->db);
    }
    
    // Método para la API
    public function obtenerRecetas() {
        $recetas = $this->model->obtenerRecetas();
        echo json_encode($recetas);
    }
    
    // Método para la vista PHP
    public function obtenerRecetasParaVista() {
        return $this->model->obtenerRecetas();
    }
    
    public function actualizarEstado() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Asegurarse de enviar el encabezado correcto
            header('Content-Type: application/json');
    
            $data = json_decode(file_get_contents('php://input'), true);
            $idReceta = $data['id_receta'];
            $nuevoEstado = $data['estado'];
            
            $resultado = $this->model->actualizarEstadoReceta($idReceta, $nuevoEstado);
            echo json_encode(['success' => $resultado]);
        }
    }
}

// Solo procesar como API si se llama directamente con parámetro action
if (isset($_GET['action'])) {
    $controller = new FarmaciaController();
    
    switch($_GET['action']) {
        case 'obtener':
            $controller->obtenerRecetas();
            break;
        case 'actualizar':
            $controller->actualizarEstado();
            break;
        default:
            http_response_code(404);
            echo json_encode(['error' => 'Acción no encontrada']);
    }
}
?>


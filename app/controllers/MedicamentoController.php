<?php
// Incluye el archivo de conexión y el modelo necesario
require_once '../includes/Database.php';
require_once '../models/Medicamento.php';

// Verifica que la clase Database exista y esté correctamente definida en `Database.php`
$db = (new Database())->getConnection(); // Obtén la conexión de la base de datos
$medicamentoModel = new Medicamento($db);

class MedicamentoController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    // Método para mostrar todos los medicamentos
    public function mostrarTodosLosMedicamentos() {
        header('Content-Type: application/json');
        
        try {
            $medicamentos = $this->model->obtenerMedicamentos();
            echo json_encode($medicamentos);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Error al obtener medicamentos: ' . $e->getMessage()]);
        }
    }

    // Método para mostrar un medicamento específico
    public function mostrarMedicamentoPorId($id) {
        header('Content-Type: application/json');
        
        try {
            $medicamento = $this->model->obtenerMedicamentoPorId($id);
            if ($medicamento) {
                echo json_encode($medicamento);
            } else {
                echo json_encode(['error' => 'Medicamento no encontrado']);
            }
        } catch (Exception $e) {
            echo json_encode(['error' => 'Error al obtener medicamento: ' . $e->getMessage()]);
        }
    }

    // Método para actualizar un medicamento
    public function actualizarMedicamento() {
        header('Content-Type: application/json');
        if (isset($_POST['id'], $_POST['nombre'], $_POST['descripcion'], $_POST['cantidad'], $_POST['precio'])) {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $cantidad = $_POST['cantidad'];
            $precio = $_POST['precio'];
    
            // Validación de cantidad y precio
            if ($cantidad < 0 || $precio < 0) {
                echo json_encode(['error' => 'La cantidad y el precio no pueden ser negativos.']);
                return;
            }
    
            $updated = $this->model->actualizarMedicamento($id, $nombre, $descripcion, $cantidad, $precio);
    
            if ($updated) {
                echo json_encode(['message' => 'Medicamento actualizado exitosamente']);
            } else {
                echo json_encode(['error' => 'Error al actualizar medicamento']);
            }
        } else {
            echo json_encode(['error' => 'Datos faltantes para actualizar']);
        }
    }
    

    public function agregarMedicamento() {
        header('Content-Type: application/json');
        if (isset($_POST['nombre'], $_POST['descripcion'], $_POST['cantidad'], $_POST['precio'])) {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $cantidad = $_POST['cantidad'];
            $precio = $_POST['precio'];
    
            // Validación de cantidad y precio
            if ($cantidad < 0 || $precio < 0) {
                echo json_encode(['error' => 'La cantidad y el precio no pueden ser negativos.']);
                return;
            }
    
            $added = $this->model->agregarMedicamento($nombre, $descripcion, $cantidad, $precio);
    
            if ($added) {
                echo json_encode(['message' => 'Medicamento agregado exitosamente']);
            } else {
                echo json_encode(['error' => 'Error al agregar el medicamento']);
            }
        } else {
            echo json_encode(['error' => 'Datos incompletos']);
        }
    }
    
    
    
}

// Crear una instancia del controlador
$controller = new MedicamentoController($medicamentoModel);

// Determinar la acción a realizar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion'])) {
        if ($_POST['accion'] === 'agregar') {
            $controller->agregarMedicamento();
        } elseif ($_POST['accion'] === 'actualizar') {
            $controller->actualizarMedicamento();
        }
    }
} elseif (isset($_GET['id'])) {
    // Si hay un ID en el parámetro GET, mostrar los datos del medicamento
    $controller->mostrarMedicamentoPorId($_GET['id']);
} else {
    // Si no hay acción específica, mostrar todos los medicamentos
    $controller->mostrarTodosLosMedicamentos();
}
?>


<?php
require_once '../includes/Database.php';
require_once '../models/Cita.php';
require_once '../models/Factura.php';
require_once '../models/UserModel.php';

class AdminController
{
    private $cita;
    private $factura;
    private $usuario;

    public function __construct($conn)
    {
        $this->cita = new Cita($conn);
        $this->factura = new Factura($conn);
        $this->usuario = new UserModel($conn);
    }

    public function obtenerResumenDashboard()
    {
        $cantidadCitas = $this->cita->obtenerCantidadCitas();
        $usuariosActivos = $this->usuario->obtenerCantidadUsuarios();
        $ingresosRecientes = $this->factura->obtenerIngresosRecientes();

        echo json_encode([
            'cantidadCitas' => $cantidadCitas,
            'usuariosActivos' => $usuariosActivos,
            'ingresosRecientes' => $ingresosRecientes,
        ]);
    }

    public function obtenerDatosGrafica($periodo = 'semana')
    {
        $datosGrafica = $this->cita->obtenerCitasPorPeriodo($periodo);
        echo json_encode($datosGrafica);
    }
}

// Configuración del endpoint
$database = new Database();
$conn = $database->getConnection();
$adminController = new AdminController($conn);

// Manejo de solicitudes
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {
    if ($_GET['action'] == 'resumenDashboard') {
        $adminController->obtenerResumenDashboard();
    }
    //DATOS PARA LA GRAFICA
    elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'obtenerDatosGrafica') {
        $periodo = $_GET['periodo'] ?? 'semana';
        $adminController->obtenerDatosGrafica($periodo);
    }
}

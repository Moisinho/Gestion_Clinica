<?php
include_once '../models/UserModel.php';
require_once '../includes/Database.php';

class AuthController {
    private $db;
    private $userModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->userModel = new UserModel($this->db);
    }

    
    public function login($correo, $password) {
        $user = $this->userModel->getUserByEmail($correo);
    
        if ($user && password_verify($password, $user['contrasenia'])) {
            $id_usuario = $user['id_usuario'];
            $tipo_usuario = $user['tipo_usuario'];
    
            // Almacenar el ID del usuario en la sesión
            session_start();
            $_SESSION['id_usuario'] = $id_usuario;
    
            // Redirigir según el tipo de usuario
            switch ($tipo_usuario) {
                case 'Administrador':
                    $pagina_inicio = '../views/Admin/dashboard.php'; // Definir la página para admin
                    break;
                case 'Médico':
                    $pagina_inicio = '/Gestion_clinica/home_medico';
                    break;
                case 'Paciente':
                    $pagina_inicio = '/Gestion_clinica/home_paciente';
                    break;
                case 'Farmaceutico':
                    $pagina_inicio = '../views/Farmaceutico/farmacia_inicio.php';
                    break;
                case 'Recepcionista':
                    $pagina_inicio = '../views/facturacion/facturacion_cita.php';
                    break;
                default:
                    $pagina_inicio = '../../index.php';
            }
    
            // Redirigir a la página de inicio
            header("Location: $pagina_inicio");
            exit();
        } else {
            echo "Credenciales incorrectas. Intenta nuevamente.";
        }
    }
    
    
}

// Proceso de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $authController = new AuthController();
    $authController->login($correo, $password);
}

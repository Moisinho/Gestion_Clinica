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
                    $pagina_inicio = '/Gestion_clinica/home_admin'; // Definir la página para admin
                    break;
                case 'Médico':
                    $pagina_inicio = '/Gestion_clinica/home_medico';
                    break;
                case 'Paciente':
                    $pagina_inicio = '/Gestion_clinica/home_paciente';
                    break;
                case 'Farmaceutico':
                    $pagina_inicio = '/Gestion_clinica/home_farmacia';
                    break;
                case 'Recepcionista':
                    $pagina_inicio = '/Gestion_clinica/home_recepcionista';
                    break;
                default:
                    $pagina_inicio = '/Gestion_clinica/';
            }
    
            // Redirigir a la página de inicio
            header("Location: $pagina_inicio");
            exit();
        } else {
            header("Location: /Gestion_clinica/login?error=Credenciales%20incorrectas");
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

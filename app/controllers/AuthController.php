<?php
include_once '../models/UserModel.php';
require_once '../includes/Database.php';

class AuthController {
    private $db;
    private $userModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection(); // Obtiene la conexión
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
                case 'admin':
                    $pagina_inicio = ''; // Definir la página para admin
                    break;
                case 'medico':
                    $pagina_inicio = '../views/Doctor/medico_inicio.php';
                    break;
                case 'paciente':
                    $pagina_inicio = '../views/Paciente/index_paciente.php';
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

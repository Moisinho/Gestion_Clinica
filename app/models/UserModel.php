<?php
class UserModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getUserByEmail($email)
    {
        $query = "SELECT id_usuario, contrasenia, tipo_usuario FROM usuario WHERE correo = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]); // Pasar el email directamente en un array
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerCantidadUsuarios()
    {
        $query = "SELECT COUNT(*) as total_usuarios_activos FROM usuario WHERE correo IS NOT NULL";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_usuarios_activos'] ?? 0;
    }
}

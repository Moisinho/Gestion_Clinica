

<?php
/*
    private $host = "autorack.proxy.rlwy.net";
    private $db_name = "Gestion_ClinicaDB";
    private $username = "root"; // Cambia a tu nombre de usuario de MySQL
    private $password = "QrythNCGsIPDUxnFylEEsiDjVWFELQwO"; // Cambia a tu contraseña de MySQL
    private $conn;
    
    private $host = "localhost";
    private $db_name = "railway";
    private $username = "root"; // Cambia a tu nombre de usuario de MySQL
    private $password = ""; // Cambia a tu contraseña de MySQL
    private $conn;
    
    */

class Database {
    private $host = "localhost";
    private $db_name = "railway";
    private $username = "root"; // Cambia a tu nombre de usuario de MySQL
    private $password = ""; // Cambia a tu contraseña de MySQL
    private $conn;

    // Método para obtener la conexión a la base de datos
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Modo de error de PDO
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>

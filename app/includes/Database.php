

<?php
/*
    private $host = "autorack.proxy.rlwy.net";
    private $port = "47824"; // Puerto especificado
    private $db_name = "gestion_clinicadb";
    private $username = "root"; // Usuario proporcionado
    private $password = "QrythNCGsIPDUxnFylEEsiDjVWFELQwO"; // Contraseña proporcionada
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
            // Incluyendo el puerto en la cadena de conexión
            $this->conn = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Modo de error de PDO
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>

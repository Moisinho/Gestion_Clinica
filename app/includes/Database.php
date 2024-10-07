<?php
class Database {
    private $host = "autorack.proxy.rlwy.net";
    private $port = "47824";
    private $db_name = "gestion_clinicadb";
    private $username = "root";
    private $password = "QrythNCGsIPDUxnFylEEsiDjVWFELQwO";
    private $conn;

    // Método para obtener la conexión a la base de datos
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";port=" .$this->port . ";dbname=" . $this->db_name, $this->username, $this->password, [
                PDO::ATTR_TIMEOUT => 55, // Tiempo de espera en segundos
            ]);
            
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
<?php
class Database
{
    private $host = "localhost";
    private $port = "3317"; // Puerto especificado
    private $db_name = "gestionclinica_db";
    private $username = "root"; // Usuario proporcionado
    private $password = "1234"; // Contraseña proporcionada
    private $conn;

    // Método para obtener la conexión a la base de datos
    public function getConnection()
    {
        $this->conn = null;

        try {
            // Incluyendo el puerto en la cadena de conexión
            $this->conn = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Modo de error de PDO
        } catch (PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}

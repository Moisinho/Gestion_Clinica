<?php

class Paciente
{
    private $conn; // Conexión a la base de datos

    // Propiedades de la clase
    public $cedula;
    public $nombre_paciente;
    public $correo_paciente;
    public $fecha_nacimiento;
    public $direccion_paciente;
    public $telefono;
    public $edad;
    public $id_usuario;
    public $sexo;
    public $id_seguro;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function obtenerCedulaByUserId($id_usuario){
        $query = "SELECT cedula FROM paciente WHERE id_usuario = :id_usuario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_usuario', $id_usuario);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }

}
?>
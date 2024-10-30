<?php
class Departamento {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerServicios() {
        $query = "SELECT * FROM departamento";
        $statement = $this->conn->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }
}

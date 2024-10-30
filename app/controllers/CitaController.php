<?php
require_once '../../includes/Database.php';
require_once '../../models/Cita.php';

class CitaController {
    private $db;
    private $citaModel;

    public function __construct() {
        // Conexión a la base de datos
        $database = new Database();
        $this->db = $database->getConnection();
        $this->citaModel = new Cita($this->db); // Se pasa la conexión al modelo Cita
    }

    public function obtenerDetallesCita($id_cita) {
        return $this->citaModel->obtenerDetalles($id_cita);
    }
}

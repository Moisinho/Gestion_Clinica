<?php
require_once '../models/Habitacion.php';  // Modelo de habitacion
require_once '../includes/Database.php';

class HabitacionController {

    private $model;
    private $db;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection(); // Obtiene la conexión
        $this->model = new Habitacion($this->db);
    }

    public function getAllHabitaciones() {
        return $this->model->getAll();
    }

    public function getHabitacion($id_habitacion) {
        return $this->model->getById($id_habitacion);
    }

    public function createHabitacion($data) {
        return $this->model->create($data);
    }

    public function updateHabitacion($id_habitacion, $data) {
        return $this->model->update($id_habitacion, $data);
    }

    public function patchHabitacion($id_habitacion, $data) {
        return $this->model->patch($id_habitacion, $data);
    }

    public function deleteHabitacion($id_habitacion) {
        return $this->model->delete($id_habitacion);
    }
}
?>

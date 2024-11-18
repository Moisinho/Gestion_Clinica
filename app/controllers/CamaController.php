<?php
require_once '../models/Cama.php';  // Modelo de cama
require_once '../includes/Database.php';

class CamaController {

    private $model;
    private $db;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection(); // Obtiene la conexión
        $this->model = new Cama($this->db);
    }

    public function getAllCamas() {
        return $this->model->getAll();
    }

    public function getCama($id_cama) {
        return $this->model->getById($id_cama);
    }

    public function createCama($data) {
        return $this->model->create($data);
    }

    public function updateCama($id_cama, $data) {
        return $this->model->update($id_cama, $data);
    }

    public function patchCama($id_cama, $data) {
        return $this->model->patch($id_cama, $data);
    }

    public function deleteCama($id_cama) {
        return $this->model->delete($id_cama);
    }
}
?>

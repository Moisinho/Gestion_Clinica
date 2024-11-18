<?php
require_once '../models/PacienteHospitalizado.php';  // Modelo de paciente hospitalizado
require_once '../includes/Database.php';

class PacienteHospitalizadoController {

    private $model;
    private $db;
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection(); // Obtiene la conexión
        $this->model = new PacienteHospitalizado($this->db);
    }

    public function getAllPacientesHospitalizados() {
        return $this->model->getAll();
    }

    public function getPacienteHospitalizado($cedula) {
        return $this->model->getByCedula($cedula);
    }

    public function createPacienteHospitalizado($data) {
        return $this->model->create($data);
    }

    public function patchPacienteHospitalizado($cedula, $data) {
        return $this->model->patch($cedula, $data);
    }

    public function updatePacienteHospitalizado($cedula, $data) {
        return $this->model->update($cedula, $data);
    }

    public function deletePacienteHospitalizado($cedula) {
        return $this->model->delete($cedula);
    }
}
?>

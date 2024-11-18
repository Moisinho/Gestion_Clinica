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
        try {
            // Intenta crear el paciente hospitalizado
            $this->model->create($data);
            return ["success" => true, "message" => "Paciente hospitalizado creado con éxito."];
        } catch (Exception $e) {
            // Maneja la excepción y devuelve el mensaje de error
            return ["success" => false, "message" => $e->getMessage()];
        }
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

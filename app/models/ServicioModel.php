<?php
class ServicioModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function obtenerServicios() {
        $stmt = $this->db->prepare("SELECT id_servicio, nombre_servicio, descripcion FROM servicio");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

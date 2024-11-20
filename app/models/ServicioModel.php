<?php
class ServicioModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }


    // Método para obtener todos los servicios
    public function obtenerServicios()
    {
        $query = "SELECT * FROM servicio";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para agregar un nuevo servicio
    public function agregarServicio($nombre_servicio, $descripcion, $costo)
    {
        $query = "INSERT INTO servicio (nombre_servicio, descripcion, costo) VALUES (:nombre_servicio, :descripcion, :costo)";
        $stmt = $this->conn->prepare($query);

        // Vincular los parámetros
        $stmt->bindParam(':nombre_servicio', $nombre_servicio);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':costo', $costo);

        return $stmt->execute();
    }

    // Método para actualizar un servicio existente
    public function actualizarServicio($id_servicio, $nombre_servicio, $descripcion, $costo)
    {
        $query = "UPDATE servicio SET nombre_servicio = :nombre_servicio, descripcion = :descripcion, costo = :costo WHERE id_servicio = :id_servicio";
        $stmt = $this->conn->prepare($query);

        // Vincular los parámetros
        $stmt->bindParam(':id_servicio', $id_servicio);
        $stmt->bindParam(':nombre_servicio', $nombre_servicio);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':costo', $costo);

        return $stmt->execute();
    }

    // Método para eliminar un servicio por ID
    public function borrarServicio($id_servicio)
    {
        $query = "DELETE FROM servicio WHERE id_servicio = :id_servicio";
        $stmt = $this->conn->prepare($query);

        // Vincular el parámetro
        $stmt->bindParam(':id_servicio', $id_servicio);

        return $stmt->execute();
    }

    // Método para obtener un servicio por ID
    public function obtenerServicioPorId($id_servicio)
    {
        $query = "SELECT * FROM servicio WHERE id_servicio = :id_servicio";
        $stmt = $this->conn->prepare($query);

        // Vincular el parámetro
        $stmt->bindParam(':id_servicio', $id_servicio);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerMonto($id_cita){
        $query = "SELECT s.costo
                    FROM servicio AS s
                    JOIN cita AS c ON c.id_servicio = s.id_servicio
                    WHERE c.id_cita = :id_cita";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_cita', $id_cita);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerServiciosSinMedicinaGeneral($medicina_general){
        // Consulta para obtener todos los servicios excepto "Cita Medicina General"
        $query = "SELECT * FROM servicio WHERE nombre_servicio != :medicina_general";
        $stmt = $this->conn->prepare($query);

        // Vincular el parámetro del nombre del servicio a excluir
        $stmt->bindParam(':medicina_general', $medicina_general);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

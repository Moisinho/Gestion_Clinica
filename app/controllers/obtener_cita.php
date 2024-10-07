<?php
// Suponiendo que ya tienes la conexión a la base de datos configurada
require_once '../includes/Database.php';
require_once '../models/Cita.php';

$database = new Database();
$db = $database->getConnection();

// Aquí puedes cambiar el id de la cita a lo que necesites, por ejemplo, un parámetro que venga de la sesión o de un formulario.
$id_cita = 3; // Cambia por la lógica adecuada

// Consulta para obtener la información de la cita
$sql  = "
    SELECT 
        c.fecha_cita, 
        c.motivo, 
        p.cedula, 
        p.nombre_paciente, 
        p.fecha_nacimiento,
        p.telefono,
        p.correo_paciente,
        p.edad
    FROM 
        cita c 
    JOIN 
        paciente p ON c.cedula = p.cedula
    WHERE 
        c.id_cita = :id_cita
";
$stmt = $db->prepare($sql);
$stmt->bindValue(':id_cita', $id_cita, PDO::PARAM_INT);
$stmt->execute();

$cita = $stmt->fetch(PDO::FETCH_ASSOC);

if ($cita) {
    $fecha_cita = $cita['fecha_cita'];
    $motivo = $cita['motivo'];
    $cedula = $cita['cedula'];
    $nombre_paciente = $cita['nombre_paciente'];
    $fecha_nacimiento = $cita['fecha_nacimiento'];
    $telefono_paciente = $cita['telefono'];
    $correo_paciente = $cita['correo_paciente'];
    $edad_paciente = $cita['edad'];
} else {
    $fecha_cita = "No disponible";
    $motivo = "No disponible";
    $cedula = "No disponible";
    $nombre_paciente = "No disponible";
    $fecha_nacimiento = "No disponible";
    $telefono_paciente = "No disponible";
    $correo_paciente = "No disponible";
    $edad_paciente = "No disponible";
}



?>

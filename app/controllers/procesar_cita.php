<?php

require_once '../includes/Database.php';
require_once '../models/Cita.php';

$database = new Database();
$db = $database->getConnection();

$cedula = $_POST['cedula'];
$motivo = $_POST['motivo'];
$id_medico = $_POST['medico'];
$fecha_cita = $_POST['fecha_cita'];

// Optional: Prescription data, assuming you have fields in your form for these.
$id_medicamento = $_POST['medicamento'] ?? null; // If you're using a select input for medications
$dosis = $_POST['dosis'] ?? null;
$duracion = $_POST['duracion'] ?? null;
$frecuencia = $_POST['frecuencia'] ?? null;

$cita = new Cita($db);

if ($cita->verificarPaciente($cedula)) {
    $resultado = $cita->registrarCita($cedula, $motivo, $id_medico, $fecha_cita);
    if ($resultado) {
        // Retrieve the last inserted appointment ID
        $id_cita = $db->lastInsertId();

        // If medication data is provided, register the prescription
        if ($id_medicamento && $dosis && $duracion && $frecuencia) {
            $resultado_receta = $cita->registrarReceta($id_cita, $id_medicamento, $dosis, $duracion, $frecuencia);
            if (!$resultado_receta) {
                echo "<script>alert('Cita registrada exitosamente, pero hubo un error al registrar la receta.');</script>";
            }
        }

        echo "<script>alert('Cita registrada exitosamente.'); 
        window.location.href='../views/agendar_cita.php';
        </script>";
    } else {
        echo "<script>
        alert('Hubo un error al registrar la cita.');
        </script>";
    }
} else {
    echo "<script>alert('El paciente no está registrado. Por favor, regístrese primero.');</script>";
}

?>

<?php
require_once '../includes/Database.php';

// Verifica si el formulario se ha enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibe los datos del formulario
    $cedula = $_POST['cedula'];
    $nombre_medico = $_POST['nombre_medico'];
    $correo_medico = $_POST['correo_medico'];
    $id_hora = $_POST['id_hora'];
    $id_departamento = $_POST['id_departamento'];

    // Crear instancia de la conexión
    $database = new Database();
    $conn = $database->getConnection();

    // Preparar la consulta
    $query = "INSERT INTO medico (nombre_medico, correo_medico, id_hora, id_departamento, id_usuario) VALUES (:nombre_medico, :correo_medico, :id_hora, :id_departamento, NULL)";
    $stmt = $conn->prepare($query);

    // Asigna valores a los parámetros
    $stmt->bindParam(':nombre_medico', $nombre_medico);
    $stmt->bindParam(':correo_medico', $correo_medico);
    $stmt->bindParam(':id_hora', $id_hora, PDO::PARAM_INT);
    $stmt->bindParam(':id_departamento', $id_departamento, PDO::PARAM_INT);

    // Ejecuta la consulta y verifica si se inserta correctamente
    if ($stmt->execute()) {
        // Redirige con un mensaje de éxito
        echo "<script>alert('Médico añadido exitosamente.'); window.location.href='/proyectos/Gestion_Clinica/app/views/admin_soli.php';</script>";
    } else {
        echo "<script>alert('Error al añadir el médico.'); window.location.href='/proyectos/Gestion_Clinica/app/views/admin_soli.php';</script>";
    }
}
?>

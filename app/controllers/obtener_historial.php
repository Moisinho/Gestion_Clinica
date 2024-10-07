<?php
require_once '../includes/Database.php';

try {
    $database = new Database();
    $db = $database->getConnection();

    // Consulta para obtener el historial médico con datos relacionados
    $sql = "
    SELECT
        hm.*,
        m.nombre_medico,
        p.nombre_paciente,
        p.cedula,
        p.fecha_nacimiento,
        p.telefono,
        p.correo_paciente
    FROM
        historial_medico hm
    JOIN
        medico m ON hm.id_medico = m.id_medico
    JOIN
        paciente p ON hm.cedula = p.cedula
    WHERE
        hm.cedula = :cedula"; // Usando un marcador de posición

$stmt = $db->prepare($sql);


    // Definir el ID del paciente
    $cedula = '123987456';
    $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR); // Usar bindParam

    // Ejecutar la consulta
    $stmt->execute();

    // Verificar si hay resultados
    if ($stmt->rowCount() > 0) {
        $historial = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $historial = [];
    }

    $stmt->closeCursor(); // Cerrar el cursor
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage()); // Manejo de excepciones
}
?>

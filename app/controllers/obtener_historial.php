<?php
require_once '../includes/Database.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $accion = filter_input(INPUT_POST, 'accion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
        if ($accion === 'ver') {
            $cedula = filter_input(INPUT_POST, 'cedula', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $id_cita = filter_input(INPUT_POST, 'id_cita', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
            if (!empty($cedula) || !empty($id_cita)) {
                $database = new Database();
                $db = $database->getConnection();
    
                // Consulta para obtener el historial usando cédula o id_cita
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
                    hm.cedula = :cedula OR hm.id_cita = :id_cita";
    
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);
                $stmt->bindParam(':id_cita', $id_cita, PDO::PARAM_STR);
                $stmt->execute();
    
                if ($stmt->rowCount() > 0) {
                    $historial = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    // Serializar los datos y enviarlos mediante POST a historial_clinico.php
                    echo '<form id="form_historial" action="../views/historial_clinico.php" method="POST">';
                    foreach ($historial as $registro) {
                        echo '<input type="hidden" name="historial[]" value="' . htmlspecialchars(json_encode($registro)) . '">';
                    }
                    echo '</form>';
                    echo '<script>document.getElementById("form_historial").submit();</script>';
                    exit();
                } else {
                    echo "<p>No se encontró ningún historial para la cédula o ID de cita proporcionados.</p>";
                }
            } else {
                echo "<p>Error: Cédula o ID de cita no válidos.</p>";
            }
        }
    }
} catch (PDOException $e) {
    // Manejo de excepciones
    $_SESSION['error'] = "Error en la base de datos: " . $e->getMessage();
    header('Location: ../views/cita_medica_doc.php'); // Redirigir en caso de error
    exit();
}
?>



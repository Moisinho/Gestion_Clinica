<?php
require_once '../includes/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->getConnection();

    $peso = $_POST['peso'];
    $altura = $_POST['altura'];
    $presion_arterial = $_POST['presion_arterial'];
    $frecuencia_cardiaca = $_POST['frecuencia_cardiaca'];
    $tipo_sangre = $_POST['tipo_sangre'];

    $antecedentes_patologicos = isset($_POST['antecedentes_patologicos']) ? implode(", ", $_POST['antecedentes_patologicos']) : '';
    $otros_antecedentes_patologicos = isset($_POST['otros_antecedentes_patologicos']) ? $_POST['otros_antecedentes_patologicos'] : '';


    $antecedentes_no_patologicos = isset($_POST['antecedentes_no_patologicos']) ? implode(", ", $_POST['antecedentes_no_patologicos']) : '';
    $otros_antecedentes_no_patologicos = isset($_POST['otros_antecedentes_no_patologicos']) ? $_POST['otros_antecedentes_no_patologicos'] : '';

    $condicion_general = $_POST['condicion_general'];
    $examenes_sangre = $_POST['examenes_sangre'];
    $laboratorios = $_POST['laboratorios'];
    $diagnostico = $_POST['diagnostico'];
    $recomendaciones = $_POST['recomendaciones'];
    $tratamiento = $_POST['tratamiento'];

    $sql = "INSERT INTO historial_medico
            (cedula, id_cita, id_medico, peso, altura, presion_arterial, frecuencia_cardiaca, tipo_sangre, 
            antecedentes_personales, otros_antecedentes, antecedentes_no_patologicos, otros_antecedentes_no_patologicos, 
            condicion_general, examenes, laboratorios, diagnostico, recomendaciones, tratamiento) 
            VALUES (:cedula, :id_cita, :id_medico, :peso, :altura, :presion_arterial, :frecuencia_cardiaca, :tipo_sangre, 
            :antecedentes_patologicos, :otros_antecedentes_patologicos, :antecedentes_no_patologicos, 
            :otros_antecedentes_no_patologicos, :condicion_general, :examenes_sangre, :laboratorios, :diagnostico, :recomendaciones, :tratamiento)";

    // Preparar la consulta con PDO
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':cedula', '123987456');
    $stmt->bindValue(':id_cita', 3);
    $stmt->bindValue(':id_medico', 1);
    $stmt->bindValue(':peso', $peso);
    $stmt->bindValue(':altura', $altura);
    $stmt->bindValue(':presion_arterial', $presion_arterial);
    $stmt->bindValue(':frecuencia_cardiaca', $frecuencia_cardiaca);
    $stmt->bindValue(':tipo_sangre', $tipo_sangre);
    $stmt->bindValue(':antecedentes_patologicos', $antecedentes_patologicos);
    $stmt->bindValue(':otros_antecedentes_patologicos', $otros_antecedentes_patologicos);
    $stmt->bindValue(':antecedentes_no_patologicos', $antecedentes_no_patologicos);
    $stmt->bindValue(':otros_antecedentes_no_patologicos', $otros_antecedentes_no_patologicos);
    $stmt->bindValue(':condicion_general', $condicion_general);
    $stmt->bindValue(':examenes_sangre', $examenes_sangre);
    $stmt->bindValue(':laboratorios', $laboratorios);
    $stmt->bindValue(':diagnostico', $diagnostico);
    $stmt->bindValue(':recomendaciones', $recomendaciones);
    $stmt->bindValue(':tratamiento', $tratamiento);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Registro guardado con éxito.";
    } else {
        echo "Error al guardar el registro.";
    }
}
?>



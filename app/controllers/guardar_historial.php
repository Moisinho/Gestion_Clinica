<?php
require_once '../includes/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->getConnection(); // Conexión usando PDO

    // Recibir los datos del formulario
    $peso = $_POST['peso'];
    $altura = $_POST['altura'];
    $presion_arterial = $_POST['presion_arterial'];
    $frecuencia_cardiaca = $_POST['frecuencia_cardiaca'];
    $tipo_sangre = $_POST['tipo_sangre'];

    // Recoger antecedentes patológicos
    $antecedentes_patologicos = isset($_POST['antecedentes_patologicos']) ? implode(", ", $_POST['antecedentes_patologicos']) : '';
    $otros_antecedentes_patologicos = isset($_POST['otros_antecedentes_patologicos']) ? $_POST['otros_antecedentes_patologicos'] : '';

    // Recoger antecedentes no patológicos
    $antecedentes_no_patologicos = isset($_POST['antecedentes_no_patologicos']) ? implode(", ", $_POST['antecedentes_no_patologicos']) : '';
    $otros_antecedentes_no_patologicos = isset($_POST['otros_antecedentes_no_patologicos']) ? $_POST['otros_antecedentes_no_patologicos'] : '';

    $condicion_general = $_POST['condicion_general'];
    $examenes_sangre = $_POST['examenes_sangre'];
    $laboratorios = $_POST['laboratorios'];
    $diagnostico = $_POST['diagnostico'];
    $recomendaciones = $_POST['recomendaciones'];
    $tratamiento = $_POST['tratamiento'];

    // Preparar la consulta para insertar la cita
        $sql = "INSERT INTO historial_medico 
            (cedula, id_cita, id_medico, peso, altura, presion_arterial, frecuencia_cardiaca, tipo_sangre, 
            antecedentes_personales, otros_antecedentes, antecedentes_no_patologicos, otros_antecedentes_no_patologicos, 
            condicion_general, examenes, laboratorios, diagnostico, recomendaciones, tratamiento) 
            VALUES (:cedula, :id_cita, :id_medico, :peso, :altura, :presion_arterial, :frecuencia_cardiaca, :tipo_sangre, 
            :antecedentes_patologicos, :otros_antecedentes_patologicos, :antecedentes_no_patologicos, 
            :otros_antecedentes_no_patologicos, :condicion_general, :examenes_sangre, :laboratorios, :diagnostico, :recomendaciones, :tratamiento)";

    // Preparar la consulta con PDO
    $stmt = $db->prepare($sql);

    // Asignar valores a los placeholders usando bindValue()
    $stmt->bindValue(':cedula', '8-12903-23'); // Aquí se debería obtener la cédula del paciente
    $stmt->bindValue(':id_cita', 5); // Aquí se debería obtener el id de la cita
    $stmt->bindValue(':id_medico', 2); // Aquí se debería obtener el id del médico
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

    // Ejecutar la consulta de inserción de cita
    if ($stmt->execute()) {
        // Obtener el id_cita generado automáticamente
        $id_cita = $db->lastInsertId();
        echo "Cita registrada con éxito. id_cita: " . $id_cita;

        // Ahora insertar los datos de la receta
        if (isset($_POST['medicamento']) && isset($_POST['dosis']) && isset($_POST['frecuencia']) && isset($_POST['duracion'])) {
            $medicamentos = $_POST['medicamento'];
            $dosis = $_POST['dosis'];
            $frecuencia = $_POST['frecuencia'];
            $duracion = $_POST['duracion'];

            // Insertar receta en la tabla `receta`
            $receta_sql = "INSERT INTO receta (id_cita, id_medicamento, dosis, duracion, frecuencia) 
                           VALUES (:id_cita, :id_medicamento, :dosis, :duracion, :frecuencia)";

            $receta_stmt = $db->prepare($receta_sql);

            // Insertar cada receta
            for ($i = 0; $i < count($medicamentos); $i++) {
                $receta_stmt->bindValue(':id_cita', $id_cita); // Usar el id_cita generado
                $receta_stmt->bindValue(':id_medicamento', $medicamentos[$i]);
                $receta_stmt->bindValue(':dosis', $dosis[$i]);
                $receta_stmt->bindValue(':duracion', $duracion[$i]);
                $receta_stmt->bindValue(':frecuencia', $frecuencia[$i]);

                // Ejecutar la consulta de inserción para cada medicamento
                $receta_stmt->execute();
            }
            echo "Recetas guardadas con éxito.";
        }
    } else {
        echo "Error al guardar el registro de la cita.";
    }
}
?>

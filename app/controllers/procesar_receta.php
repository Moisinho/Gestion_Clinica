<?php
//creo que esto se puede borrar, no se
//creo que esto se puede borrar, no se
//creo que esto se puede borrar, no se
//creo que esto se puede borrar, no se
//creo que esto se puede borrar, no se
//creo que esto se puede borrar, no se
//creo que esto se puede borrar, no se
//creo que esto se puede borrar, no se
//creo que esto se puede borrar, no se
//creo que esto se puede borrar, no se
//creo que esto se puede borrar, no se
//creo que esto se puede borrar, no se
//creo que esto se puede borrar, no se

require_once '../includes/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'guardar_receta') {
    // Recibir los datos del formulario
    $id_cita = $_POST['id_cita']; // ID de la cita, debes enviarlo en el formulario
    $medicamentos = $_POST['medicamento'];
    $dosis = $_POST['dosis'];
    $duracion = $_POST['duracion'];
    $frecuencia = $_POST['frecuencia'];

    // Verificar que todos los datos sean válidos
    if (empty($id_cita) || empty($medicamentos) || empty($dosis) || empty($duracion) || empty($frecuencia)) {
        die('Faltan datos necesarios para guardar la receta');
    }

    // Conectar a la base de datos
    $db = new Database();
    $conn = $db->getConnection();

    // Insertar cada medicamento en la tabla `receta`
    foreach ($medicamentos as $index => $medicamento) {
        $dosisValue = $dosis[$index];
        $duracionValue = $duracion[$index];
        $frecuenciaValue = $frecuencia[$index];

        // Crear la consulta SQL
        $sql = "INSERT INTO receta (id_cita, id_medicamento, dosis, duracion, frecuencia)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisss", $id_cita, $medicamento, $dosisValue, $duracionValue, $frecuenciaValue);

        if (!$stmt->execute()) {
            die('Error al guardar la receta: ' . $stmt->error);
        }
    }

    // Redirigir o mostrar mensaje de éxito
    echo "Receta guardada con éxito.";
    header('Location: /ruta_a_la_pagina_de_exito');
    exit;
}
?>

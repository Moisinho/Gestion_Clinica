<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial Clínico - Clínica Condado Real</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../js/tailwind-config.js"></script>
</head>

<body class="bg-gray-50 font-sans">
<?php include '../includes/header.php'; ?>

    <!-- Contenido principal -->
    <div class="container mx-auto p-5">
        <div class="bg-white p-5 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-Moradote mb-4">Historial Clínico</h2>
            
                        <!-- Datos personales del paciente -->
            <div class="mb-5">
                <h3 class="text-xl font-bold text-Moradote">Datos personales</h3>
                <div class="bg-blue-100 p-4 rounded-lg mt-2">
                    <div class="grid grid-cols-3 gap-4">
                        <?php
                        include '../controllers/obtener_historial.php';
                        // Asegúrate de que la variable $historial no esté vacía
                        if (!empty($historial)) {
                            // Usar el primer elemento del array $historial para mostrar los datos personales
                            $paciente = $historial[0]; // Usamos solo el primer elemento, ya que es el mismo paciente
                            echo "<p><strong>Nombre del paciente:</strong> " . htmlspecialchars($paciente['nombre_paciente']) . "</p>";
                            echo "<p><strong>Cédula:</strong> " . htmlspecialchars($cedula) . "</p>"; // Cédula ya que la estamos utilizando
                            
                            echo "<p><strong>Fecha de nacimiento:</strong> " . htmlspecialchars($paciente['fecha_nacimiento']) . "</p>";
                            echo "<p><strong>Teléfono:</strong> " . htmlspecialchars($paciente['telefono']) . "</p>";
                            echo "<p><strong>Correo:</strong> " . htmlspecialchars($paciente['correo_paciente']) . "</p>";
                        } else {
                            echo "<p>No se encontraron datos personales para este paciente.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Citas Médicas -->
            <div>
                <h3 class="text-xl font-bold text-Moradote">Citas Médicas</h3>

                <?php
                // Incluir el archivo que carga los datos
                include '../controllers/obtener_historial.php';

                // Verificar si hay historial
                if (!empty($historial)) {
                    foreach ($historial as $entry) {
                        echo '<div class="bg-blue-100 p-4 rounded-lg mt-2">';
                        echo "<p><strong>Médico asignado:</strong> " . htmlspecialchars($entry['nombre_medico']) . "</p>";
                        echo "<p><strong>Fecha de la cita:</strong> " . htmlspecialchars($entry['fecha_cita']) . "</p>";
                        echo "<p><strong>Diagnóstico:</strong> " . htmlspecialchars($entry['diagnostico']) . "</p>";
                        echo "<p><strong>Tratamiento:</strong> " . htmlspecialchars($entry['tratamiento']) . "</p>";
                        echo "<p><strong>Receta:</strong> " . htmlspecialchars($entry['receta']) . "</p>";
                        echo "<p><strong>Exámenes:</strong> " . htmlspecialchars($entry['examenes']) . "</p>";
                        echo "<p><strong>Observaciones:</strong> " . htmlspecialchars($entry['recomendaciones']) . "</p>";
                        echo '</div>'; // Cerrar contenedor de la cita
                    }
                } else {
                    echo "<p>No se encontraron registros para este paciente.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>

</html>

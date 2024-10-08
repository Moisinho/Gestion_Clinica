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
    <!-- Encabezado -->
    <header class="bg-purple-300 py-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold text-purple-900">Clínica Condado Real</h1>
            <nav>
                <ul class="flex space-x-4 text-purple-900">
                    <li><a href="#" class="hover:text-purple-600">Inicio</a></li>
                    <li><a href="#" class="hover:text-purple-600">Gestión de Citas</a></li>
                    <li><a href="#" class="hover:text-purple-600">Pacientes</a></li>
                    <li><a href="#" class="hover:text-purple-600">Datos personales</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Contenido principal -->
    <div class="container mx-auto p-5">
        <div class="bg-white p-5 rounded-lg shadow-md">
            <?php
                include '../controllers/obtener_historial.php';
            ?>
            <h2 class="text-2xl font-bold text-Moradote mb-4">Historial Clínico</h2>
            
                        <!-- Datos personales del paciente -->
            <div class="mb-5">
                <h3 class="text-xl font-bold text-Moradote">Datos personales</h3>
                <div class="bg-blue-100 p-4 rounded-lg mt-2">
                    <div class="grid grid-cols-3 gap-4">
                    <?php
                        // Verificar si el historial ha sido enviado mediante POST
                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['historial'])) {
                            $historial = array_map('json_decode', $_POST['historial']); // Decodificar cada entrada JSON

                            if (!empty($historial)) {
                                // Usar el primer elemento del array $historial para mostrar los datos personales del paciente
                                $paciente = $historial[0]; // Primer elemento del historial corresponde al paciente
                                echo "<p><strong>Nombre del paciente:</strong> " . htmlspecialchars($paciente->nombre_paciente) . "</p>";
                                echo "<p><strong>Cédula:</strong> " . htmlspecialchars($paciente->cedula) . "</p>";
                                echo "<p><strong>Fecha de nacimiento:</strong> " . htmlspecialchars($paciente->fecha_nacimiento) . "</p>";
                                echo "<p><strong>Teléfono:</strong> " . htmlspecialchars($paciente->telefono) . "</p>";
                                echo "<p><strong>Correo:</strong> " . htmlspecialchars($paciente->correo_paciente) . "</p>";
                            }
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
                    // Mostrar las citas médicas
                    if (!empty($historial)) {
                        foreach ($historial as $entry) {
                            echo '<div class="bg-blue-100 p-4 rounded-lg mt-2">';
                            echo "<p><strong>Médico asignado:</strong> " . htmlspecialchars($entry->nombre_medico) . "</p>"; // Usa '->' para acceder a las propiedades del objeto
                            echo "<p><strong>Fecha de la cita:</strong> " . htmlspecialchars($entry->fecha_cita) . "</p>";
                            echo "<p><strong>Diagnóstico:</strong> " . htmlspecialchars($entry->diagnostico) . "</p>";
                            echo "<p><strong>Tratamiento:</strong> " . htmlspecialchars($entry->tratamiento) . "</p>";
                            echo "<p><strong>Receta:</strong> " . htmlspecialchars($entry->receta) . "</p>";
                            echo "<p><strong>Exámenes:</strong> " . htmlspecialchars($entry->examenes) . "</p>";
                            echo "<p><strong>Observaciones:</strong> " . htmlspecialchars($entry->recomendaciones) . "</p>";
                            echo '</div>'; // Cerrar contenedor de la cita
                        }
                    } else {
                        echo "<p>No se encontraron registros de citas médicas para este paciente.</p>";
                    }
                ?>
            </div>
            <!-- Mensaje de error si no hay historial -->
            <?php
            if (isset($mensaje_error)) {
                echo "<p class='text-red-500'>$mensaje_error</p>";
            }
            ?>
        </div>
    </div>

    <!-- Pie de página -->
    <footer class="bg-purple-300 text-Moradote font-bold text-center py-4 mt-5">
        <p>&copy; 2024 Clínica Condado Real. Todos los derechos reservados.</p>
    </footer>
</body>

</html>

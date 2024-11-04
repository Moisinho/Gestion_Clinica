<?php
// Incluir la conexión a la base de datos
require_once '../includes/Database.php';

// Crear una nueva conexión
$database = new Database();
$db = $database->getConnection();

// Consulta para obtener los medicamentos
$query = "SELECT id_medicamento, nombre FROM medicamento";
$stmt = $db->prepare($query);
$stmt->execute();
$medicamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Reservas de Citas Médicas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../js/tailwind-config.js"></script>
    <script>
        function agregarReceta() {
            // Crear un nuevo div para la receta
            const nuevoDiv = document.createElement('div');
            nuevoDiv.className = 'mb-4 receta';

            // Contenido del nuevo div
            nuevoDiv.innerHTML = `
                <h3 class="text-lg font-bold text-Moradote mb-4">Receta adicional</h3>
                <label for="medicamento" class="block text-gray-700">Medicamento</label>
                <select name="id_medicamento[]" required class="w-full px-4 py-2 border rounded-lg">
                    <option value="">Seleccione un medicamento</option>
                    <?php if (!empty($medicamentos)): ?>
                        <?php foreach ($medicamentos as $medicamento): ?>
                            <option value="<?php echo htmlspecialchars($medicamento['id_medicamento']); ?>">
                                <?php echo htmlspecialchars($medicamento['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                
                <div class="mb-4">
                    <label for="dosis" class="block text-gray-700">Dosis</label>
                    <input type="text" name="dosis[]" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="mb-4">
                    <label for="duracion" class="block text-gray-700">Duración</label>
                    <input type="text" name="duracion[]" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="mb-4">
                    <label for="frecuencia" class="block text-gray-700">Frecuencia</label>
                    <input type="text" name="frecuencia[]" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
            `;

            // Agregar el nuevo div al contenedor de recetas
            document.getElementById('recetasContainer').appendChild(nuevoDiv);
        }
    </script>
</head>

<body class="bg-gray-100">
    <!-- Encabezado -->
    <?php include '../includes/header.php'; ?>

    <div class="flex justify-end">
        <a href="index_paciente.php" class="flex-end">
            <img src="media/arrow-right.png" alt="siguiente" class="w-12">
        </a>
    </div>
    <!-- Título Principal -->
    <section class="my-8">
        <h2 class="text-Moradote text-3xl font-bold text-center">Registro de Reservas de Citas Médicas</h2>
        <hr class="mt-2 border-t-2 border-purple-700 w-1/2 mx-auto">
    </section>

    <!-- Contenido Principal -->
    <div class="container mx-auto w-6/12 mb-10">
        <!-- Formulario de Reserva de Cita -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-bold text-Moradote mb-4">Datos de la Reserva de Cita</h3>
            <hr class="mb-8 border-t-4 border-Moradote w-full"> <!-- Línea gruesa morada -->
            <form method="POST" action="../../controllers/procesar_cita.php">
                <input type="hidden" name="action" value="registrar"> <!-- Campo oculto para la acción -->

                <div class="mb-4">
                    <label for="cedula" class="block text-gray-700">Cédula</label>
                    <input type="text" id="cedula" name="cedula" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                
                <div class="mb-4">
                    <label for="servicio" class="block text-gray-700">Servicios</label>
                    <select id="servicio" name="servicio" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="">Seleccione un servicio</option>
                        <?php foreach ($servicios as $servicio): ?>
                            <option value="<?php echo htmlspecialchars($servicio['id_servicio']); ?>">
                                <?php echo htmlspecialchars($servicio['nombre_servicio']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="motivo" class="block text-gray-700">Motivo de cita</label>
                    <input type="text" id="motivo" name="motivo" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>

                <div class="mb-4">
                    <label for="medico" class="block text-gray-700">Médico de atención</label>
                    <select id="medico" name="medico" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="">Seleccione un médico</option>
                        <?php if (empty($medicos)): ?>
                            <option value="" disabled>No hay médicos disponibles</option>
                        <?php else: ?>
                            <?php foreach ($medicos as $medico): ?>
                                <option value="<?php echo htmlspecialchars($medico['id_medico']); ?>">
                                    <?php echo htmlspecialchars($medico['nombre_medico']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="fecha" class="block text-gray-700">Fecha de cita</label>
                    <input type="date" id="fecha" name="fecha_cita" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>

                <h3 class="text-lg font-bold text-Moradote mb-4">Agregar Recetas</h3>
                <hr class="mb-8 border-t-4 border-Moradote w-full"> <!-- Línea gruesa morada -->

                <!-- Contenedor para las recetas -->
                <div id="recetasContainer">
                    <div class="mb-4 receta">
                        <label for="medicamento" class="block text-gray-700">Medicamento</label>
                        <select name="id_medicamento[]" required class="w-full px-4 py-2 border rounded-lg">
                            <option value="">Seleccione un medicamento</option>
                            <?php if (!empty($medicamentos)): ?>
                                <?php foreach ($medicamentos as $medicamento): ?>
                                    <option value="<?php echo htmlspecialchars($medicamento['id_medicamento']); ?>">
                                        <?php echo htmlspecialchars($medicamento['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Campos adicionales para la receta -->
                    <div class="mb-4">
                        <label for="dosis" class="block text-gray-700">Dosis</label>
                        <input type="text" name="dosis[]" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div class="mb-4">
                        <label for="duracion" class="block text-gray-700">Duración</label>
                        <input type="text" name="duracion[]" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div class="mb-4">
                        <label for="frecuencia" class="block text-gray-700">Frecuencia</label>
                        <input type="text" name="frecuencia[]" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                </div>

                <!-- Botón para agregar otra receta -->
                <button type="button" onclick="agregarReceta()" class="mb-4 px-4 py-2 bg-purple-600 text-white rounded-lg">
                    Agregar Otra Receta
                </button>

                <div class="mb-4">
                    <button type="submit" class="w-full bg-Moradote text-white font-bold py-2 px-4 rounded-lg">
                        Reservar Cita
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Pie de Página -->
    <?php include '../includes/footer.php'; ?>
</body>
</html>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Reservas de Citas Médicas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../js/tailwind-config.js"></script>
</head>

<body class="bg-gray-100">
    <!-- Encabezado -->
    <?php include '../../includes/header.php'; ?>

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
                        <!-- Opciones de médicos se llenarán dinámicamente -->
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
                <div class="flex justify-between">
                    <button type="submit" required
                        class="bg-Moradote text-white px-4 py-2 rounded-lg hover:bg-Moradito">Agendar</button>
                    <button type="button"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">Borrar reserva</button>
                </div>
            </form>
        </div>

        
    </div>
    
</body>

</html>

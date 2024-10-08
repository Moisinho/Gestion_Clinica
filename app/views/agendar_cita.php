<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Reservas de Citas Médicas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../js/tailwind-config.js"></script>

</head>

<body class="bg-gray-100">
    <!-- Encabezado -->
    <?php include '../includes/header.php'; ?>

    <div class="flex justify-end">
        <a href="medico_inicio.php" class="flex-end">
            <img src="media/arrow-right.png" alt="siguiente" class="w-12">
        </a>
        
    </div>
    <!-- Título Principal -->
    <section class="my-8">
        <h2 class="text-Moradote text-3xl font-bold text-center">Registro de Reservas de Citas Médicas</h2>
        <hr class="mt-2 border-t-2 border-purple-700 w-1/2 mx-auto">
    </section>

    <!-- Contenido Principal -->
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Formulario de Reserva de Cita -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-bold text-Moradote mb-4">Datos de la Reserva de Cita</h3>
            <form method="POST" action="../controllers/procesar_cita.php">


                <div class="mb-4">
                    <label for="cedula" class="block text-gray-700">Cédula</label>
                    <input type="text" id="cedula" name="cedula" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="mb-4">
                    <label for="motivo" class="block text-gray-700">Motivo de cita</label>
                    <input type="text" id="motivo" name="motivo" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                
                <?php include '../controllers/obtener_medicos.php'; ?>
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

        <!-- Tabla de Citas Programadas -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-bold text-Moradote mb-4">Citas Programadas</h3>
            <table class="min-w-full table-auto">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-gray-600">Motivo</th>
                        <th class="px-4 py-2 text-left text-gray-600">Fecha</th>
                        <th class="px-4 py-2 text-left text-gray-600">Estado</th>
                        <th class="px-4 py-2"></th>
                    </tr>
                </thead>
    <?php include '../controllers/obtenerCitas.php'; ?>
<tbody>
    <?php if (!empty($citas)): ?>
        <?php foreach ($citas as $cita): ?>
            <tr class="border-b">
                <td class="px-4 py-2"><?php echo htmlspecialchars($cita['motivo']); ?></td>
                <td class="px-4 py-2"><?php echo htmlspecialchars($cita['fecha_cita']); ?></td>
                <td class="px-4 py-2"><?php echo htmlspecialchars($cita['estado']); ?></td>
                <td class="px-4 py-2">
                    <button class="bg-Moradote text-white px-4 py-2 rounded-lg hover:bg-purple-500">Detalles</button>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4" class="px-4 py-2 text-center">No hay citas programadas</td>
        </tr>
    <?php endif; ?>
</tbody>

            </table>
        </div>
    </div>
        <?php include '../includes/footer.php'; ?>
</body>

</html>
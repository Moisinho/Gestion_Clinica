<?php 
// Inicializa $citas como un array vacío si no está definido
if (!isset($citas)) {
    $citas = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturar Citas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Encabezado -->
    <div class="bg-[#6A5492] text-white p-4 flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <form method="POST">
                <select name="criterio" class="p-2 bg-white text-black rounded-md">
                    <option value="estado">Estado</option>
                    <option value="diagnostico">Diagnóstico</option>
                    <option value="tratamiento">Tratamiento</option>
                </select>
                <input type="text" name="busqueda" class="p-2 rounded-md" placeholder="Ingrese criterio de búsqueda">
                <button type="submit" class="p-2 bg-white text-purple-600 rounded-md">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10 2a8 8 0 106.32 3.16l4.92 4.92-1.41 1.41-4.92-4.92A8 8 0 0010 2z"></path>
                    </svg>
                </button>
            </form>
        </div>
        <button class="bg-gray-200 text-purple-600 p-2 rounded-md">Buscar</button>
    </div>

    <!-- Contenido principal -->
    <div class="flex">
        <div class="flex flex-col mt-4 mx-8">
            <!-- Tabla de citas -->
            <h2 class="flex text-xl font-bold text-gray-700 p-4">CITAS SIN COBRAR</h2>
            <div class="flex-1 bg-white shadow-md rounded-lg">
                <table class="min-w-full table-auto">
                    <thead class="bg-purple-600 text-white text-center">
                        <tr>
                            <th class="p-2">id_cita</th>
                            <th class="p-2">Estado</th>
                            <th class="p-2">Recordatorio</th>
                            <th class="p-2">Fecha Cita</th>
                            <th class="p-2">Diagnóstico</th>
                            <th class="p-2">Tratamiento</th>
                            <th class="p-2">cedula</th>
                            <th class="p-2">id_medico</th>
                            <th class="p-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Incluir la clase Database y Cita
                            require_once '../../includes/Database.php';
                            require_once '../../models/Cita.php';

                            // Crear instancia de la clase Database y obtener la conexión
                            $database = new Database();
                            $conn = $database->getConnection();

                            // Crear la instancia de Cita
                            $cita = new Cita($conn);

                            // Definir la variable de búsqueda al cargar la página
                            $busqueda = isset($_POST['busqueda']) ? $_POST['busqueda'] : '';

                            // Mapear las citas usando el método en la clase Cita
                            $citas = $cita->mapear_citas($busqueda); // Asignar el resultado a $citas
                        ?>
                        <?php if (!empty($citas)):?>
                            <?php foreach ($citas as $row): ?>
                                <tr class="border-b text-center">
                                    <td class="border-r p-2"><?php echo htmlspecialchars($row['id_cita']); ?></td>
                                    <td class="border-r p-2"><?php echo htmlspecialchars($row['estado']); ?></td>
                                    <td class="border-r p-2"><?php echo htmlspecialchars($row['recordatorio']); ?></td>
                                    <td class="border-r p-2"><?php echo htmlspecialchars($row['fecha_cita']); ?></td>
                                    <td class="border-r p-2"><?php echo htmlspecialchars($row['diagnostico']); ?></td>
                                    <td class="border-r p-2"><?php echo htmlspecialchars($row['tratamiento']); ?></td>
                                    <td class="border-r p-2"><?php echo htmlspecialchars($row['cedula']); ?></td>
                                    <td class="border-r p-2"><?php echo htmlspecialchars($row['id_medico']); ?></td>
                                    <td class="border-r p-2"><button class="bg-blue-500 text-white p-2 rounded-md">COBRAR</button></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="p-2 text-center">No se encontraron registros</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

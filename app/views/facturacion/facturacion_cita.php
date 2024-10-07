<?php
// Inicializa la variable de selección del criterio
$criterioSeleccionado = isset($_POST['criterio']) ? $_POST['criterio'] : '';
$valorBusqueda = isset($_POST['busqueda']) ? $_POST['busqueda'] : '';

// Incluir la clase Database y Cita
require_once '../../includes/Database.php';
require_once '../../models/Cita.php';

// Crear instancia de la clase Database y obtener la conexión
$database = new Database();
$conn = $database->getConnection();

// Crear la instancia de Cita
$cita = new Cita($conn);

// Lógica para convertir el criterio a la columna correspondiente en la base de datos
if ($criterioSeleccionado == 'Fecha') {
    $criterioBD = 'fecha_cita';
} elseif ($criterioSeleccionado == 'Cédula') {
    $criterioBD = 'cedula';
} else {
    $criterioBD = '';
}

// Si se ha enviado el formulario y hay un valor de búsqueda y criterio válidos
if (!empty($criterioBD) && !empty($valorBusqueda)) {
    // Llamar a la función de búsqueda con los parámetros proporcionados
    $citas = $cita->buscarCitasPorCriterio($criterioBD, "%$valorBusqueda%");
    // Limpiar el valor de búsqueda para que el campo aparezca vacío después de la búsqueda
    $valorBusqueda = '';
    // Reiniciar el criterio seleccionado para que el select vuelva a "Seleccione una opción"
    $criterioSeleccionado = ''; // Aquí reiniciamos el criterio seleccionado
} else {
    // Si no se ingresó un criterio o un valor de búsqueda, mostrar todas las citas pendientes
    $citas = $cita->mapear_citas_pendientes();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturar Citas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100">
    <!-- Encabezado -->
    <div class="bg-[#6A5492] text-white p-4 flex items-center justify-center w-full">
        <div class="flex items-center w-full justify-center">
            <form method="POST" class="flex items-center space-x-2 w-3/4">
                <!-- Select con opción seleccionada reiniciada -->
                <select name="criterio" class="p-2 bg-white text-black rounded-md w-1/3">
                    <option value="" disabled <?php echo $criterioSeleccionado == '' ? 'selected' : ''; ?>>Seleccione una opción</option>
                    <option value="Fecha" <?php echo $criterioSeleccionado == 'Fecha' ? 'selected' : ''; ?>>Fecha</option>
                    <option value="Cédula" <?php echo $criterioSeleccionado == 'Cédula' ? 'selected' : ''; ?>>Cédula</option>
                </select>
                <input type="text" name="busqueda" class="p-2 rounded-md w-1/2 text-black" placeholder="Ingrese criterio de búsqueda" value="<?php echo htmlspecialchars($valorBusqueda); ?>">
                <button class="text-xl font-bold bg-gray-200 text-purple-600 p-2 rounded-md w-32">Buscar</button>
            </form>
        </div>
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
                            <th class="p-2">Motivo</th>
                            <th class="p-2">Fecha Cita</th>
                            <th class="p-2">Diagnóstico</th>
                            <th class="p-2">Tratamiento</th>
                            <th class="p-2">Cédula</th>
                            <th class="p-2">id_medico</th>
                            <th class="p-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($citas)):?>
                            <?php foreach ($citas as $row): ?>
                                <tr class="border-b text-center">
                                    <td class="border-r p-2"><?php echo htmlspecialchars($row['id_cita']); ?></td>
                                    <td class="border-r p-2"><?php echo htmlspecialchars($row['estado']); ?></td>
                                    <td class="border-r p-2"><?php echo htmlspecialchars($row['motivo']); ?></td>
                                    <td class="border-r p-2"><?php echo htmlspecialchars($row['fecha_cita']); ?></td>
                                    <td class="border-r p-2"><?php echo htmlspecialchars($row['diagnostico']); ?></td>
                                    <td class="border-r p-2"><?php echo htmlspecialchars($row['tratamiento']); ?></td>
                                    <td class="border-r p-2"><?php echo htmlspecialchars($row['cedula']); ?></td>
                                    <td class="border-r p-2"><?php echo htmlspecialchars($row['id_medico']); ?></td>
                                    <td class="border-r p-2">
                                        <!-- Formulario para enviar el id_cita al menú de cobro -->
                                        <form action="menu_cobro.php" method="post">
                                            <input type="hidden" name="id_cita" value="<?php echo htmlspecialchars($row['id_cita']); ?>">
                                            <button type="submit" class="bg-blue-500 text-white p-2 rounded-md">COBRAR</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="p-2 text-center">No se encontraron registros</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

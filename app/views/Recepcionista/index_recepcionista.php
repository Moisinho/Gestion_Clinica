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
    $citas = $cita->buscarCitasPorCriterio($criterioBD, $valorBusqueda);
    // Limpiar el valor de búsqueda para que el campo aparezca vacío después de la búsqueda
    $valorBusqueda = '';
    // Reiniciar el criterio seleccionado para que el select vuelva a "Seleccione una opción"
    $criterioSeleccionado = ''; // Aquí reiniciamos el criterio seleccionado
} else {
    // Si no se ingresó un criterio o un valor de búsqueda, mostrar todas las citas pendientes
    $citas = $cita->mapear_citas_confirmadas();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturar Citas</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .table-container {
            height: 500px; /* Altura máxima */
            overflow-y: auto; /* Scroll vertical */
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">
    <?php include '../../includes/header.php'; ?>
    <div class="bg-[#6A5492] text-white p-4 flex items-center justify-center w-full">
        <div class="flex items-center w-full justify-center">
            <form method="POST" action="" class="flex items-center space-x-2 w-3/4">
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
    <main class="flex flex-col mt-8 mx-4 md:mx-8 mb-8">
        <!-- Tabla de citas -->
        <div class="bg-white rounded-lg shadow-md p-6 w-full mb-6 overflow-y-auto table-container">
            <h2 class="text-2xl font-semibold text-purple-700 mb-4">Citas Sin Cobrar</h2>
            <table class="w-full border-collapse">
                <thead class="bg-purple-600 text-white">
                    <tr>
                        <th class="p-3 text-left">id_cita</th>
                        <th class="p-3 text-left">Estado</th>
                        <th class="p-3 text-left">Motivo</th>
                        <th class="p-3 text-left">Fecha Cita</th>
                        <th class="p-3 text-left">Diagnóstico</th>
                        <th class="p-3 text-left">Tratamiento</th>
                        <th class="p-3 text-left">Cédula</th>
                        <th class="p-3 text-left">id_medico</th>
                        <th class="p-3 text-left">id_servicio</th>
                        <th class="p-3 text-left">Acciones</th>
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
                                <td class="border-r p-2"><?php echo htmlspecialchars($row['id_servicio']); ?></td>
                                <td class="border-r p-2">
                                    <form action="menu_cobro.php" method="POST">
                                        <input type="hidden" name="id_cita" value="<?php echo htmlspecialchars($row['id_cita']); ?>">
                                        <input type="hidden" name="diagnostico" value="<?php echo htmlspecialchars($row['diagnostico']); ?>">
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
    </main>
    <!-- Modal Cobro -->
    <div id="modalCobro" class="hidden fixed inset-0 flex items-center justify-center z-50 bg-gray-900 bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
            <!-- Header del Modal -->
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Cobrar Cita</h3>
                <button onclick="cerrarModal()" class="text-gray-500 hover:text-gray-800">&times;</button>
            </div>

            <input type="hidden" id="id_cita" name="id_cita">
            
            <!-- Radio Button para Método de Pago -->
            <div class="mb-4">
                <label class="block font-bold mb-2">Método de Pago:</label>
                <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                        <input type="radio" name="metodo_pago" value="tarjeta" onclick="mostrarCampos('tarjeta')" class="mr-2"> Tarjeta
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="metodo_pago" value="efectivo" onclick="mostrarCampos('efectivo')" class="mr-2"> Efectivo
                    </label>
                </div>
            </div>
            
            <!-- Campos para Tarjeta -->
            <div id="campos-tarjeta" class="mx-4 mb-4 hidden">
                <label class="block text-left font-bold mb-2" for="monto_tarjeta">Monto:</label>
                <input class="bg-gray-200 p-2 w-full mb-2" type="number" id="monto_tarjeta" name="monto_tarjeta" placeholder="Ingrese monto">

                <label class="block text-left font-bold mb-2" for="detalles_tarjeta">Detalles:</label>
                <input class="bg-gray-200 p-2 w-full mb-2" type="text" id="detalles" name="detalles" value="<?php
                ?>" readonly>
                <select class="bg-gray-200 p-2 w-full mb-2" id="detalles_tarjeta" name="detalles_tarjeta">
                    <option value="">Seleccione un diagnóstico</option>
                    <?php
                        require_once '../../includes/Database.php';
                        $database = new Database();
                        $conn = $database->getConnection();
                        $stmt = $conn->prepare("SELECT DISTINCT diagnostico FROM cita");
                        $stmt->execute();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . htmlspecialchars($row['diagnostico']) . "'>" . htmlspecialchars($row['diagnostico']) . "</option>";
                        }
                    ?>
                </select>

                <label class="block text-left font-bold mb-2" for="numero_tarjeta">Número de Tarjeta:</label>
                <input class="bg-gray-200 p-2 w-full mb-2" type="text" id="numero_tarjeta" name="numero_tarjeta" placeholder="Ingrese número de tarjeta">

                <label class="block text-left font-bold mb-2" for="nombre_propietario">Nombre del Propietario:</label>
                <input class="bg-gray-200 p-2 w-full mb-2" type="text" id="nombre_propietario" name="nombre_propietario" placeholder="Ingrese nombre del propietario">

                <label class="block text-left font-bold mb-2" for="fecha_vencimiento">Fecha de Vencimiento:</label>
                <input class="bg-gray-200 p-2 w-full mb-2" type="month" id="fecha_vencimiento" name="fecha_vencimiento">

                <label class="block text-left font-bold mb-2" for="cvv">CVV:</label>
                <input class="bg-gray-200 p-2 w-full mb-2" maxlength="3" type="text" id="cvv" name="cvv" placeholder="Ingrese CVV">
            </div>

            <!-- Campo para Efectivo -->
            <div id="campo-efectivo" class="mx-4 mb-4 hidden">
                <label class="block text-left font-bold mb-2" for="monto_efectivo">Monto:</label>
                <input class="bg-gray-200 p-2 w-full mb-2" type="number" id="monto_efectivo" name="monto_efectivo" placeholder="Ingrese monto">

                <label class="block text-left font-bold mb-2" for="detalles_efectivo">Detalles:</label>
                <select class="bg-gray-200 p-2 w-full mb-2" id="detalles_efectivo" name="detalles_efectivo">
                    <option value="">Seleccione un diagnóstico</option>
                    <?php
                        $stmt = $conn->prepare("SELECT DISTINCT diagnostico FROM cita");
                        $stmt->execute();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . htmlspecialchars($row['diagnostico']) . "'>" . htmlspecialchars($row['diagnostico']) . "</option>";
                        }
                    ?>
                </select>
            </div>

            <!-- Botones de Acción -->
            <div class="flex justify-end mt-4">
                <button onclick="cerrarModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2">Cancelar</button>
                <button class="bg-purple-600 text-white px-4 py-2 rounded-md">Cobrar</button>
            </div>
        </div>
    </div>
</body>
</html>

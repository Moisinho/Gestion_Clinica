
<?php
// Iniciar la sesión
session_start();

// Verificar si el id_usuario está en la sesión; si no, redirigir al usuario a la página de login
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../../../index.php');
    exit();
}
require_once '../../controllers/FarmaciaController.php';

$controller = new FarmaciaController();
$recetas = $controller->obtenerRecetasParaVista();

function obtenerBadgeEstado($estado) {
    $badges = [
        'Confirmada' => '<span class="px-2 py-1 rounded text-sm bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>Confirmada
                        </span>',
        'Pendiente' => '<span class="px-2 py-1 rounded text-sm bg-yellow-100 text-yellow-800">
                            <i class="fas fa-clock mr-1"></i>Pendiente
                        </span>',
        'Rechazada' => '<span class="px-2 py-1 rounded text-sm bg-red-100 text-red-800">
                            <i class="fas fa-times-circle mr-1"></i>Rechazada
                        </span>'
    ];
    
    return $badges[$estado] ?? '';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Recetas Digitales</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<?php include '../../includes/header_farmacia.php'; ?>
    <div class="p-4 max-w-6xl mx-auto space-y-4 h-screen">
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800">Gestión de Recetas Digitales</h2>
                <p class="text-gray-600">Sistema de Farmacia Hospitalaria</p>
            </div>
            <div class="p-6">
                <?php if (empty($recetas)): ?>
                    <div class="text-center py-4 text-gray-600">
                        No hay recetas disponibles en este momento.
                    </div>
                <?php else: ?>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3">ID Receta</th>
                                    <th class="px-6 py-3">Paciente</th>
                                    <th class="px-6 py-3">Medicamento</th>
                                    <th class="px-6 py-3">Médico</th>
                                    <th class="px-6 py-3">Fecha</th>
                                    <th class="px-6 py-3">Estado</th>
                                    <th class="px-6 py-3">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recetas as $receta): ?>
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium">
                                            <?php echo htmlspecialchars($receta['id_receta']); ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?php echo htmlspecialchars($receta['nombre_paciente']); ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?php echo htmlspecialchars($receta['nombre_medicamento']); ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?php echo htmlspecialchars($receta['nombre_medico']); ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?php echo date('d/m/Y', strtotime($receta['fecha'])); ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?php echo obtenerBadgeEstado($receta['estado']); ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?php if ($receta['estado'] === 'Pendiente'): ?>
                                                <button 
                                                    onclick="mostrarModal(<?php echo htmlspecialchars(json_encode($receta), ENT_QUOTES, 'UTF-8'); ?>)"
                                                    class="px-4 py-2 text-sm bg-green-50 hover:bg-green-100 text-green-700 rounded border border-green-300">
                                                    Revisar
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación -->
    <div id="modalConfirmacion" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-36 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Confirmar Receta</h3>
                <div class="mt-2 space-y-2" id="modalContent">
                    <!-- Contenido del modal se cargará dinámicamente -->
                </div>
                <div class="mt-4 flex justify-end space-x-2">
                    <button id="btnCancelar" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                        Cancelar
                    </button>
                    <button id="btnRechazar" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                        Rechazar
                    </button>
                    <button id="btnConfirmar" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                        Confirmar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php include '../../includes/footer.php'; ?>
    <script src="../Js/Farmaceutico/acciones_receta.js"></script>
</body>
</html>


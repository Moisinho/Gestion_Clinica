<?php
// Iniciar la sesión
session_start();

// Verificar si el id_usuario está en la sesión; si no, redirigir al usuario a la página de login
if (!isset($_SESSION['id_usuario'])) {
    header('Location: /Gestion_clinica/');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Servicios - Clínica Condado Real</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../js/tailwind-config.js"></script>
</head>

<body class="bg-gray-50 font-sans min-h-screen flex flex-col">

    <?php include('../../includes/header_admin.php'); ?>

    <div class="container mx-auto p-5 flex-grow">
        <div class="bg-purple-300 p-5 rounded-lg shadow-md mt-8">
            <!-- Barra de búsqueda y botón de añadir -->
            <div class="flex items-center space-x-3 mb-4">
                <input type="text" id="buscar" placeholder="Buscar servicio..." class="ml-5 w-full max-w-4xl px-4 py-2 rounded-lg border border-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                <button type="button" class="bg-purple-600 text-white font-semibold px-4 py-2 rounded-lg shadow hover:bg-purple-700" onclick="openModal()">Añadir Servicio</button>
            </div>

            <!-- Tabla de servicios -->
            <div class="bg-white p-5 rounded-lg shadow-md overflow-y-auto h-[50vh]">
                <table class="min-w-full divide-y divide-gray-200" id="serviciosTable">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Costo</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="serviciosTbody" class="bg-white divide-y divide-gray-200">
                        <!-- Aquí se cargan dinámicamente los servicios -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal para añadir y editar servicios -->
    <div id="modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
            <button class="absolute top-2 right-2 text-gray-600 hover:text-gray-800" onclick="closeModal()">&times;</button>
            <h2 class="text-xl font-semibold mb-4" id="modalTitle">Añadir Servicio</h2>
            <form id="servicioForm">
                <input type="hidden" name="id_servicio" id="id_servicio">
                <label class="block mb-2">Nombre del Servicio:</label>
                <input type="text" name="nombre_servicio" id="nombre_servicio" class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg" required>

                <label class="block mb-2">Descripción:</label>
                <textarea name="descripcion" id="descripcion" class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg" required></textarea>

                <label class="block mb-2">Costo:</label>
                <input type="number" name="costo" id="costo" class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg" required>

                <div class="flex flex-wrap justify-around">
                    <button class="bg-gray-500 hover:bg-gray-700 text-white font-semibold px-4 py-2 mt-4 rounded-lg shadow " onclick="closeModal()">Cancelar</button>
                    <button type="submit" class="bg-purple-800 text-white font-semibold px-4 py-2 mt-4 rounded-lg shadow hover:bg-purple-700">Guardar</button>
                </div>

            </form>
        </div>
    </div>

    <!-- Modal de Confirmación -->
    <div id="confirmModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
            <h2 class="text-xl font-semibold mb-4">¿Estás seguro?</h2>
            <p>¿Deseas eliminar este servicio?</p>
            <div class="flex justify-end mt-4">
                <button class="bg-red-600 text-white font-semibold px-4 py-2 rounded-lg shadow hover:bg-red-700" id="confirmDelete">Eliminar</button>
                <button class="bg-gray-300 text-gray-700 font-semibold px-4 py-2 rounded-lg shadow hover:bg-gray-400 ml-2" onclick="closeConfirmModal()">Cancelar</button>
            </div>
        </div>
    </div>
    <?php include '../../includes/footer.php'; ?>
    <script src="/Gestion_clinica/app/views/Js/Admin/gestion_servicios.js"></script>
</body>

</html>
<?php
// Iniciar la sesión
session_start();

// Verificar si el id_usuario está en la sesión; si no, redirigir al usuario a la página de login
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../../../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Farmacéutico</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../js/tailwind-config.js"></script>
</head>
<body class="bg-gray-100">
    <!-- Barra de navegación -->
    <?php include '../../includes/header_farmacia.php'; ?>
    <!-- Contenido principal -->
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Panel de Control Farmacéutico</h1>
        
        <!-- Primera fila: Gestión de medicamentos y recetas -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-[#6A5492] mb-4 px-4">Gestión de Medicamentos</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-4">
                <!-- Tarjeta de Solicitudes de Recetas -->
                <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="p-6">
                        <div class="bg-button/10 rounded-full w-16 h-16 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-button" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Solicitudes de Recetas</h3>
                        <p class="text-gray-600 mb-4">Gestiona las solicitudes de recetas digitales enviadas por los médicos.</p>
                        <a href="consultar_recetas.php" class="inline-block bg-purple-300 text-purple-900 px-4 py-2 rounded-lg font-bold hover:bg-purple-400 transition-colors duration-300">
                            Gestionar Solicitudes
                        </a>
                    </div>
                </div>

                <!-- Tarjeta de Consulta de Medicamentos -->
                <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="p-6">
                        <div class="bg-button/10 rounded-full w-16 h-16 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-button" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Consultar Medicamentos</h3>
                        <p class="text-gray-600 mb-4">Consulta y gestiona el inventario actual de medicamentos.</p>
                        <a href="medicamentos.php" class="inline-block bg-purple-300 text-purple-900 px-4 py-2 rounded-lg font-bold hover:bg-purple-400 transition-colors duration-300">
                            Ver Medicamentos
                        </a>
                    </div>
                </div>

                <!-- Tarjeta de Registro de Medicamentos -->
                <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="p-6">
                        <div class="bg-button/10 rounded-full w-16 h-16 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-button" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Registrar Medicamentos</h3>
                        <p class="text-gray-600 mb-4">Añade nuevos medicamentos al sistema o actualiza los existentes.</p>
                        <a href="registro-medicamentos.php" class="inline-block bg-purple-300 text-purple-900 px-4 py-2 rounded-lg font-bold hover:bg-purple-400 transition-colors duration-300">
                            Registrar Nuevo
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Segunda fila: Proveedores y Reportes -->
        <div>
            <h2 class="text-xl font-semibold text-[#6A5492] mb-4 px-4">Administración y Reportes</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-4">
                <!-- Tarjeta de Proveedores -->
                <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="p-6">
                        <div class="bg-button/10 rounded-full w-16 h-16 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-button" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Proveedores</h3>
                        <p class="text-gray-600 mb-4">Gestiona la comunicación con proveedores de medicamentos.</p>
                        <a href="proveedores.php" class="inline-block bg-purple-300 text-purple-900 px-4 py-2 rounded-lg font-bold hover:bg-purple-400 transition-colors duration-300">
                            Gestionar Proveedores
                        </a>
                    </div>
                </div>

                <!-- Tarjeta de Reportes -->
                <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="p-6">
                        <div class="bg-button/10 rounded-full w-16 h-16 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-button" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Reportes y Estadísticas</h3>
                        <p class="text-gray-600 mb-4">Genera informes y visualiza estadísticas de la farmacia.</p>
                        <a href="reportes.php" class="inline-block bg-purple-300 text-purple-900 px-4 py-2 rounded-lg font-bold hover:bg-purple-400 transition-colors duration-300">
                            Ver Reportes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../../includes/footer.php'; ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.addEventListener('click', function(e) {
                    if (!e.target.matches('a')) {
                        const link = this.querySelector('a');
                        if (link) link.click();
                    }
                });
            });
        });

        function logout() {
            fetch('logout.php', {
                method: 'POST',
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'login.php';
                }
            });
        }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Administración</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <!-- Encabezado -->
    <?php include('../../includes/header.php'); ?>

    <!-- Contenedor Principal -->
    <div class="container mx-auto my-8">
        <h2 class="text-3xl font-bold text-center text-Moradote mb-6">Dashboard de Administración</h2>

        <!-- Sección de Resumen -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <!-- Tarjeta Citas Programadas -->
            <div class="bg-white shadow-lg rounded-lg p-4 text-center">
                <h3 class="text-xl font-bold text-gray-700">Citas Programadas</h3>
                <p class="text-3xl font-bold text-purple-700">123</p>
            </div>
            <!-- Tarjeta Usuarios Activos -->
            <div class="bg-white shadow-lg rounded-lg p-4 text-center">
                <h3 class="text-xl font-bold text-gray-700">Usuarios Activos</h3>
                <p class="text-3xl font-bold text-purple-700">45</p>
            </div>
            <!-- Tarjeta Ingresos Recientes -->
            <div class="bg-white shadow-lg rounded-lg p-4 text-center">
                <h3 class="text-xl font-bold text-gray-700">Ingresos Recientes</h3>
                <p class="text-3xl font-bold text-purple-700">$5,000</p>
            </div>

        </div>

        <!-- Sección de Gráficos y Alertas -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Gráfico de Citas -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-700 mb-4">Citas por Semana</h3>
                <!-- Aquí iría un gráfico de citas usando una librería como Chart.js -->
                <canvas id="chartCitas"></canvas>
            </div>

            <!-- Notificaciones y Alertas -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-700 mb-4">Notificaciones</h3>
                <ul class="space-y-2">
                    <li class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-lg">3 citas sin confirmar</li>
                    <li class="bg-red-100 text-red-800 px-4 py-2 rounded-lg">2 médicos no disponibles</li>
                    <li class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg">Próxima actualización de software</li>
                </ul>
            </div>
        </div>

        <!-- Botones de Acceso Rápido -->
        <div class="flex justify-center mt-8 space-x-4">
            <a href="gestionar_citas.php" class="bg-purple-700 text-white px-4 py-2 rounded-lg hover:bg-purple-600">Gestionar Usuarios</a>
            <a href="gestionar_servicios.php" class="bg-purple-700 text-white px-4 py-2 rounded-lg hover:bg-purple-600">Gestionar Servicios</a>
        </div>
    </div>

    <!-- Pie de Página -->
    <?php include '../../includes/footer.php'; ?>

    <!-- Scripts para gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Configuración del gráfico de citas
        const ctxCitas = document.getElementById('chartCitas').getContext('2d');
        const chartCitas = new Chart(ctxCitas, {
            type: 'line',
            data: {
                labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
                datasets: [{
                    label: 'Citas',
                    data: [10, 15, 8, 5, 12, 18, 7],
                    borderColor: 'rgba(91, 33, 182, 0.7)',
                    backgroundColor: 'rgba(91, 33, 182, 0.2)',
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>
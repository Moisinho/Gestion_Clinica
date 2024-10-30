<?php
$id_medico = 1;

// Incluye el controlador de citas que contiene la conexión a la base de datos
include '../../controllers/obtenerCitas.php';

// Crea la instancia de Cita pasándole la conexión
$citas = new Cita($db);

// Llama al método obtener_citas con el id del médico
$citasMedico = $citas->obtener_citas($id_medico);

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Médico</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .today {
            color: blue;
            font-weight: bold;
            border-radius: 50%;
        }
        .table-container {
            height: 500px; /* Altura máxima */
            overflow-y: auto; /* Scroll vertical */
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800">
    <?php include '../../includes/header.php'; ?>

    <!-- Contenido principal -->
    <main class="flex flex-col md:flex-row mt-8 mx-4 md:mx-8 mb-8">
        <!-- Tabla de citas -->
        <div class="bg-white rounded-lg shadow-md p-6 md:w-2/3 lg:w-3/4 mb-6 md:mb-0 overflow-y-auto table-container" >
            <h2 class="text-2xl font-semibold text-purple-700 mb-4">Citas Programadas</h2>
            <table class="w-full border-collapse">
                <thead class="bg-purple-600 text-white">
                    <tr>
                        <th class="p-3 text-left">Motivo</th>
                        <th class="p-3 text-left">Fecha</th>
                        <th class="p-3 text-left">Estado</th>
                        <th class="p-3 text-left"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Verifica si hay datos de citas para el médico
                    if (!empty($citasMedico)) {
                        foreach ($citasMedico as $cita) {
                            echo "<tr class='border-b hover:bg-purple-50'>";
                            echo "<td class='p-3'>" . ($cita['motivo'] ?? 'Sin motivo') . "</td>";
                            echo "<td class='p-3'>" . ($cita['fecha_cita'] ?? 'Sin fecha') . "</td>";
                            echo "<td class='p-3'>" . ($cita['estado'] ?? 'Sin estado') . "</td>";
                            echo "<td class='p-3'>"; // Nueva celda para el botón
                            echo "<a href='cita_medica_doc.php?id_cita=" . htmlspecialchars($cita['id_cita']) . "' class='bg-purple-300 text-purple-900 font-bold py-2 px-4 rounded hover:bg-purple-400'>Ver Detalles de Cita</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='p-3 text-center text-gray-500'>No hay citas pendientes para mostrar.</td></tr>"; // Aumenta el colspan a 4
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Calendario -->
        <div class="w-full md:w-1/3 lg:w-1/4 bg-gray-200 rounded-lg shadow-md p-6 ml-0 md:ml-4">
            <h3 class="font-bold text-lg text-purple-700 mb-4 text-center" id="monthYear"></h3>
            <div class="grid grid-cols-7 gap-2 text-center">
                <div class="font-bold">Dom</div>
                <div class="font-bold">Lun</div>
                <div class="font-bold">Mar</div>
                <div class="font-bold">Mié</div>
                <div class="font-bold">Jue</div>
                <div class="font-bold">Vie</div>
                <div class="font-bold">Sáb</div>
                <!-- Contenedor de los días -->
                <div id="calendarDays" class="col-span-7 grid grid-cols-7 gap-2"></div>
            </div>
        </div>
    </main>

    <?php include '../../includes/footer.php'; ?>

    <script>
        // Función para construir el calendario
        function buildCalendar() {
            const date = new Date();
            const month = date.getMonth();
            const year = date.getFullYear();
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const today = date.getDate();

            // Mostrar el mes y el año
            document.getElementById('monthYear').innerText = `${date.toLocaleString('es-ES', { month: 'long' })} ${year}`;

            const calendarDays = document.getElementById('calendarDays');
            calendarDays.innerHTML = ''; // Limpiar días anteriores

            // Espacios en blanco para los días antes del inicio del mes
            for (let i = 0; i < firstDay; i++) {
                const emptyCell = document.createElement('div');
                calendarDays.appendChild(emptyCell);
            }

            // Días del mes
            for (let day = 1; day <= daysInMonth; day++) {
                const dayCell = document.createElement('div');
                dayCell.className = 'text-center p-2 rounded-full bg-white hover:bg-gray-300 cursor-pointer';
                dayCell.innerText = day;

                if (day === today) {
                    dayCell.classList.add('today');
                }

                calendarDays.appendChild(dayCell);
            }
        }

        window.onload = buildCalendar;
    </script>
</body>
</html>

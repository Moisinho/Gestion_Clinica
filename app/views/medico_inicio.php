<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Médico</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../js/tailwind-config.js"></script>
    <style>
        .today {
            color: Blue;
            border-radius: 50%;
        }
    </style>
</head>

<body class="bg-gray-100">
    <?php include '../includes/header.php'; ?>
    <div class="bg-purple-400 text-white p-4 flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <select class="p-2 bg-white text-black rounded-md">
                <option>Criterio de búsqueda</option>
                <option>Nombre</option>
                <option>Cédula</option>
            </select>
            <input type="text" class="p-2 rounded-md" placeholder="Ingrese criterio de búsqueda">
            
        </div>
        <button class="bg-gray-200 text-purple-600 p-2 rounded-md">Buscar</button>
    </div>

    <!-- Contenido principal -->
    <div class="flex mt-4 mx-8">
        <!-- Tabla de citas -->
        <div class="flex-1 bg-white shadow-md rounded-lg">
            <h2 class="text-xl font-bold text-gray-700 p-4">Pacientes sin atender</h2>
            <table class="min-w-full table-auto">
                <thead class="bg-purple-600 text-white">
                    <tr>
                        <th class="p-2">Nombre</th>
                        <th class="p-2">Hora</th>
                        <th class="p-2">Motivo</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <!-- Ejemplo de datos -->
                    <tr class="border-b">
                        <td class="p-2">Maria Antonieta</td>
                        <td class="p-2">8:45 am</td>
                        <td class="p-2">Dolor de cabeza constante</td>
                        
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Calendario -->
        <div class="w-64 bg-gray-200 ml-4 rounded-lg shadow-md p-4">
            <h3 class="font-bold text-lg mb-2 text-center" id="monthYear"></h3>
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
    </div>
    
    <?php include '../includes/footer.php'; ?>

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

            
            for (let i = 0; i < firstDay; i++) {
                const emptyCell = document.createElement('div');
                calendarDays.appendChild(emptyCell);
            }

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

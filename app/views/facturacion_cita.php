<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturar Citas</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Encabezado -->
    <div class="bg-purple-600 text-white p-4 flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <select class="p-2 bg-white text-black rounded-md">
                <option>Criterio de búsqueda</option>
                <option>Nombre</option>
                <option>DNI</option>
            </select>
            <input type="text" class="p-2 rounded-md" placeholder="Ingrese criterio de búsqueda">
            <button class="p-2 bg-white text-purple-600 rounded-md">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M10 2a8 8 0 106.32 3.16l4.92 4.92-1.41 1.41-4.92-4.92A8 8 0 0010 2z"></path>
                </svg>
            </button>
        </div>
        <button class="bg-gray-200 text-purple-600 p-2 rounded-md">Buscar</button>
    </div>

    <!-- Contenido principal -->
    <div class="flex mt-4 mx-8">
        <!-- Tabla de citas -->
        <div class="flex-1 bg-white shadow-md rounded-lg">
            <h2 class="text-xl font-bold text-gray-700 p-4">CITAS SIN COBRAR</h2>
            <table class="min-w-full table-auto">
                <thead class="bg-purple-600 text-white">
                    <tr>
                        <th class="p-2">Nombre</th>
                        <th class="p-2">Teléfono</th>
                        <th class="p-2">Dirección</th>
                        <th class="p-2">E-mail</th>
                        <th class="p-2">DNI</th>
                        <th class="p-2">Fecha de reserva</th>
                        <th class="p-2">Estado</th>
                        <th class="p-2">Atención</th>
                        <th class="p-2">NHC</th>
                        <th class="p-2">Más</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="p-2">Maria</td>
                        <td class="p-2">777</td>
                        <td class="p-2">1542 Lima</td>
                        <td class="p-2">abc@...</td>
                        <td class="p-2">741</td>
                        <td class="p-2">29/11/22</td>
                        <td class="p-2 text-green-500">Activo</td>
                        <td class="p-2">Presencial</td>
                        <td class="p-2">MD01</td>
                        <td class="p-2"><button class="bg-blue-500 text-white p-2 rounded-md">COBRAR</button></td>
                    </tr>
                    <tr class="border-b">
                        <td class="p-2">Maria</td>
                        <td class="p-2">777</td>
                        <td class="p-2">1542 Lima</td>
                        <td class="p-2">abc@...</td>
                        <td class="p-2">741</td>
                        <td class="p-2">29/11/22</td>
                        <td class="p-2 text-green-500">Activo</td>
                        <td class="p-2">Presencial</td>
                        <td class="p-2">MD01</td>
                        <td class="p-2"><button class="bg-blue-500 text-white p-2 rounded-md">COBRAR</button></td>
                    </tr>
                    <tr class="border-b">
                        <td class="p-2">Maria</td>
                        <td class="p-2">777</td>
                        <td class="p-2">1542 Lima</td>
                        <td class="p-2">abc@...</td>
                        <td class="p-2">741</td>
                        <td class="p-2">29/11/22</td>
                        <td class="p-2 text-green-500">Activo</td>
                        <td class="p-2">Presencial</td>
                        <td class="p-2">MD01</td>
                        <td class="p-2"><button class="bg-blue-500 text-white p-2 rounded-md">COBRAR</button></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Publicidad -->
        <div class="w-64 bg-gray-200 ml-4 rounded-lg shadow-md p-4 text-center">
            <p class="text-xl font-bold">Publicidad o foto fina</p>
        </div>
    </div>
</body>
</html>
